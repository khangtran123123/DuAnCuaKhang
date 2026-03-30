<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\TourBooking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class BookingController extends Controller
{
    public function book(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'ma_kh' => ['required', 'integer', 'exists:tbl_KhachHang,MaKH'],
                // ma_phong có thể không truyền – hệ thống sẽ tự tìm phòng nhỏ nhất trống
                'ma_phong' => ['nullable', 'string', 'exists:tbl_Phong,MaPhong'],
                'ma_loai' => ['nullable', 'integer', 'exists:tbl_LoaiPhong,MaLoai'],
                'room_type' => ['nullable', 'string'],
                'room_variant' => ['nullable', 'string', 'in:nt,view'],
                'ngay_nhan_phong' => ['required', 'date'],
                'ngay_tra_phong' => ['required', 'date', 'after_or_equal:ngay_nhan_phong'],
                'tong_tien' => ['nullable', 'numeric', 'min:0'],
                'payment_method' => ['nullable', 'string', 'in:counter,online'],
            ]);

            $paymentMethod = $data['payment_method'] ?? 'counter';
            $isOnlinePayment = $paymentMethod === 'online';

            // Nếu FE không gửi ma_phong, tự động chọn phòng có MaPhong nhỏ nhất đang trống
            if (empty($data['ma_phong'])) {
                $assignedRoom = $this->findMinAvailableRoom(
                    checkIn: $data['ngay_nhan_phong'],
                    checkOut: $data['ngay_tra_phong'],
                    maLoai: $data['ma_loai'] ?? null,
                    roomType: $data['room_type'] ?? null,
                    roomVariant: $data['room_variant'] ?? null,
                );

                if (!$assignedRoom) {
                    return response()->json([
                        'success' => false,
                        'code' => 'NO_ROOM_AVAILABLE',
                        'message' => 'Không còn phòng trống trong khoảng thời gian này.',
                    ], Response::HTTP_CONFLICT);
                }

                $data['ma_phong'] = $assignedRoom->MaPhong;
                $room = $assignedRoom;
            } else {
                $room = Room::with('type')->find($data['ma_phong']);
            }

            if (!$room || is_null($room->GiaPhong)) {
                return response()->json([
                    'success' => false,
                    'code' => 'ROOM_PRICE_NOT_FOUND',
                    'message' => 'Khong tim thay gia phong cho phong da chon.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $checkInDate = Carbon::parse($data['ngay_nhan_phong'])->startOfDay();
            $checkOutDate = Carbon::parse($data['ngay_tra_phong'])->startOfDay();
            $totalDays = max(1, $checkInDate->diffInDays($checkOutDate));
            $roomPrice = (float) $room->GiaPhong;
            $calculatedTotal = round($roomPrice * $totalDays, 2);

            $conflict = RoomBooking::where('MaPhong', $data['ma_phong'])
                ->where('TrangThai', 1)
                ->where(function ($q) use ($data) {
                    $q->whereBetween('NgayNhanPhong', [$data['ngay_nhan_phong'], $data['ngay_tra_phong']])
                        ->orWhereBetween('NgayTraPhong', [$data['ngay_nhan_phong'], $data['ngay_tra_phong']])
                        ->orWhere(function ($sub) use ($data) {
                            $sub->where('NgayNhanPhong', '<', $data['ngay_nhan_phong'])
                                ->where('NgayTraPhong', '>', $data['ngay_tra_phong']);
                        });
                })
                ->exists();

            if ($conflict) {
                return response()->json([
                    'success' => false,
                    'code' => 'ROOM_CONFLICT',
                    'message' => 'Phòng đã được đặt trong khoảng thời gian này.',
                ], Response::HTTP_CONFLICT);
            }

            // Tìm hóa đơn của cùng khách hàng có hóa đơn phòng trùng ngày
            $existingInvoice = Invoice::where('MaKH', $data['ma_kh'])
                ->where('TrangThai', 0)
                ->whereHas('rooms', function ($q) use ($data) {
                    $q->where('NgayNhanPhong', $data['ngay_nhan_phong'])
                      ->where('NgayTraPhong', $data['ngay_tra_phong'])
                      ->where('TrangThai', 1);
                })
                ->first();

            $result = DB::transaction(function () use ($data, $calculatedTotal, $roomPrice, $totalDays, $existingInvoice, $isOnlinePayment, $paymentMethod) {
                if ($existingInvoice !== null) {
                    // Thêm phòng vào hóa đơn hiện tại, cập nhật tổng tiền
                    $roomBooking = RoomBooking::create([
                        'MaHD' => $existingInvoice->MaHD,
                        'MaPhong' => $data['ma_phong'],
                        'NgayNhanPhong' => $data['ngay_nhan_phong'],
                        'NgayTraPhong' => $data['ngay_tra_phong'],
                        'TongTien' => $calculatedTotal,
                        'TrangThai' => 1,
                        'ThanhToan' => 0,
                    ]);

                    $existingInvoice->ThanhTien = round((float) $existingInvoice->ThanhTien + $calculatedTotal, 2);
                    $existingInvoice->save();

                    $freshInvoice = $existingInvoice->fresh()->load('rooms.room.type');
                    $transferDesc = $this->buildTransferDescription((int) $freshInvoice->MaHD);

                    return [
                        'invoice' => $freshInvoice,
                        'booking' => $roomBooking->load('room.type'),
                        'pricing' => [
                            'gia_phong' => $roomPrice,
                            'so_ngay_o' => $totalDays,
                            'tong_tien' => $calculatedTotal,
                        ],
                        'payment_method' => $paymentMethod,
                        'payment_method_label' => $isOnlinePayment ? 'Thanh toán trực tuyến' : 'Thanh toán tại quầy',
                        'qr_payload' => $isOnlinePayment ? $transferDesc : null,
                        'qr_code_url' => $isOnlinePayment ? $this->buildVietQrUrl((float) $freshInvoice->ThanhTien, $transferDesc) : null,
                        'bank_info' => $isOnlinePayment ? $this->getBankInfo() : null,
                        'reused_invoice' => true,
                    ];
                }

                // Tạo hóa đơn mới – luôn TrangThai=0, xác nhận qua confirm-payment
                $invoice = Invoice::create([
                    'MaKH' => $data['ma_kh'],
                    'NgayTao' => now()->toDateString(),
                    'ThanhTien' => $calculatedTotal,
                    'TrangThai' => 0,
                ]);

                $roomBooking = RoomBooking::create([
                    'MaHD' => $invoice->MaHD,
                    'MaPhong' => $data['ma_phong'],
                    'NgayNhanPhong' => $data['ngay_nhan_phong'],
                    'NgayTraPhong' => $data['ngay_tra_phong'],
                    'TongTien' => $calculatedTotal,
                    'TrangThai' => 1,
                    'ThanhToan' => 0,
                ]);

                $invoice = $invoice->fresh()->load('rooms.room.type');
                $transferDesc = $this->buildTransferDescription((int) $invoice->MaHD);

                return [
                    'invoice' => $invoice,
                    'booking' => $roomBooking->load('room.type'),
                    'pricing' => [
                        'gia_phong' => $roomPrice,
                        'so_ngay_o' => $totalDays,
                        'tong_tien' => $calculatedTotal,
                    ],
                    'payment_method' => $paymentMethod,
                    'payment_method_label' => $isOnlinePayment ? 'Thanh toán trực tuyến' : 'Thanh toán tại quầy',
                    'qr_payload' => $isOnlinePayment ? $transferDesc : null,
                    'qr_code_url' => $isOnlinePayment ? $this->buildVietQrUrl($calculatedTotal, $transferDesc) : null,
                    'bank_info' => $isOnlinePayment ? $this->getBankInfo() : null,
                    'reused_invoice' => false,
                ];
            });

            $reused = $result['reused_invoice'];
            return response()->json([
                'success' => true,
                'code' => $reused ? 'ROOM_ADDED_TO_INVOICE' : 'BOOKING_CREATED',
                'message' => $reused ? 'Phòng đã được thêm vào hóa đơn hiện tại.' : 'Đặt phòng thành công.',
                'data' => [
                    'invoice' => $this->mapInvoice($result['invoice']),
                    'booking' => $this->mapRoomBooking($result['booking']),
                    'pricing' => $result['pricing'],
                    'payment_method' => $result['payment_method'],
                    'payment_method_label' => $result['payment_method_label'],
                    'qr_payload' => $result['qr_payload'],
                    'qr_code_url' => $result['qr_code_url'],
                    'bank_info' => $result['bank_info'] ?? null,
                ],
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'code' => 'VALIDATION_ERROR',
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'code' => 'SERVER_ERROR',
                'message' => 'Có lỗi hệ thống, vui lòng thử lại.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function confirmPayment(Request $request, int $maHD): JsonResponse
    {
        try {
            if (!$this->isManualConfirmAuthorized($request)) {
                return response()->json([
                    'success' => false,
                    'code' => 'MANUAL_CONFIRM_FORBIDDEN',
                    'message' => 'Xác nhận thanh toán thủ công từ ứng dụng khách đã bị tắt. Vui lòng chờ webhook ngân hàng hoặc dùng kênh quản trị.',
                ], Response::HTTP_FORBIDDEN);
            }

            $invoice = Invoice::with('rooms.room.type')->find($maHD);

            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'code' => 'INVOICE_NOT_FOUND',
                    'message' => 'Không tìm thấy hóa đơn.',
                ], Response::HTTP_NOT_FOUND);
            }

            if ($invoice->TrangThai == 1) {
                return response()->json([
                    'success' => true,
                    'code' => 'ALREADY_PAID',
                    'message' => 'Hóa đơn đã được thanh toán trước đó.',
                    'data' => ['invoice' => $this->mapInvoice($invoice)],
                ]);
            }

            $invoice->TrangThai = 1;
            $invoice->save();

            // Đánh dấu ThanhToan=1 cho tất cả chi tiết phòng của hóa đơn này
            RoomBooking::where('MaHD', $maHD)
                ->where('TrangThai', 1)
                ->update(['ThanhToan' => 1]);

            return response()->json([
                'success' => true,
                'code' => 'PAYMENT_CONFIRMED',
                'message' => 'Xác nhận thanh toán thành công.',
                'data' => ['invoice' => $this->mapInvoice($invoice->fresh()->load('rooms.room.type'))],
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'code' => 'SERVER_ERROR',
                'message' => 'Có lỗi hệ thống khi xác nhận thanh toán.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function paymentStatus(Request $request, int $maHD): JsonResponse
    {
        try {
            $invoice = Invoice::with('rooms.room.type')->find($maHD);

            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'code' => 'INVOICE_NOT_FOUND',
                    'message' => 'Không tìm thấy hóa đơn.',
                ], Response::HTTP_NOT_FOUND);
            }

            $isPaid = (int) $invoice->TrangThai === 1;

            return response()->json([
                'success' => true,
                'code' => 'PAYMENT_STATUS',
                'message' => $isPaid ? 'Hóa đơn đã thanh toán.' : 'Hóa đơn chưa thanh toán.',
                'data' => [
                    'ma_hd' => (int) $invoice->MaHD,
                    'is_paid' => $isPaid,
                    'payment_status' => $isPaid ? 'paid' : 'unpaid',
                    'payment_status_label' => $isPaid ? 'Đã thanh toán' : 'Chưa thanh toán',
                    'invoice' => $this->mapInvoice($invoice),
                ],
            ], Response::HTTP_OK);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'code' => 'SERVER_ERROR',
                'message' => 'Có lỗi hệ thống khi kiểm tra trạng thái thanh toán.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function bankTransferWebhook(Request $request): JsonResponse
    {
        try {
            Log::info('bank_transfer_webhook_received', [
                'headers' => [
                    'user-agent' => $request->userAgent(),
                    'x-webhook-secret-present' => $request->header('X-Webhook-Secret') !== null,
                ],
                'payload' => $request->all(),
            ]);

            $secret = (string) env('BANK_WEBHOOK_SECRET', '');
            $headerSecret = (string) $request->header('X-Webhook-Secret', '');
            $bodySecret = (string) $request->input('secret', '');

            if ($secret !== '' && $headerSecret !== $secret && $bodySecret !== $secret) {
                Log::warning('bank_transfer_webhook_rejected', [
                    'reason' => 'invalid_secret',
                ]);

                return response()->json([
                    'success' => false,
                    'code' => 'WEBHOOK_UNAUTHORIZED',
                    'message' => 'Webhook secret không hợp lệ.',
                ], Response::HTTP_UNAUTHORIZED);
            }

            $content = trim((string) (
                $request->input('content')
                ?? $request->input('description')
                ?? $request->input('transfer_content')
                ?? $request->input('data.content')
                ?? $request->input('data.description')
                ?? $request->input('data.transfer_content')
                ?? ''
            ));

            $rawAmount = (
                $request->input('amount')
                ?? $request->input('transfer_amount')
                ?? $request->input('transferAmount')
                ?? $request->input('data.amount')
                ?? $request->input('data.transfer_amount')
                ?? $request->input('data.transferAmount')
                ?? $request->input('amount_in')
                ?? $request->input('amountOut')
                ?? $request->input('data.amount_in')
                ?? null
            );
            $amount = $this->parseTransferAmount($rawAmount);

            if ($content === '') {
                Log::warning('bank_transfer_webhook_rejected', [
                    'reason' => 'missing_content',
                    'amount' => $amount,
                ]);

                return response()->json([
                    'success' => false,
                    'code' => 'INVALID_TRANSFER_CONTENT',
                    'message' => 'Thiếu nội dung chuyển khoản.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $invoiceId = $this->extractInvoiceIdFromTransferContent($content);
            if (!$invoiceId) {
                Log::info('bank_transfer_webhook_ignored', [
                    'reason' => 'invoice_not_detected',
                    'content' => $content,
                    'amount' => $amount,
                ]);

                // Giao dịch không liên quan hóa đơn hệ thống, trả ACK để provider không retry.
                return response()->json([
                    'success' => true,
                    'code' => 'IGNORED_TRANSFER',
                    'message' => 'Không tìm thấy mã hóa đơn trong nội dung chuyển khoản.',
                ], Response::HTTP_OK);
            }

            $invoice = Invoice::with('rooms.room.type')->find($invoiceId);
            if (!$invoice) {
                Log::warning('bank_transfer_webhook_rejected', [
                    'reason' => 'invoice_not_found',
                    'invoice_id' => $invoiceId,
                    'content' => $content,
                    'amount' => $amount,
                ]);

                return response()->json([
                    'success' => false,
                    'code' => 'INVOICE_NOT_FOUND',
                    'message' => 'Không tìm thấy hóa đơn tương ứng nội dung chuyển khoản.',
                ], Response::HTTP_NOT_FOUND);
            }

            if ((int) $invoice->TrangThai === 1) {
                Log::info('bank_transfer_webhook_already_paid', [
                    'invoice_id' => $invoiceId,
                    'amount' => $amount,
                ]);

                return response()->json([
                    'success' => true,
                    'code' => 'ALREADY_PAID',
                    'message' => 'Hóa đơn đã thanh toán trước đó.',
                    'data' => ['invoice' => $this->mapInvoice($invoice)],
                ], Response::HTTP_OK);
            }

            $expectedAmount = (float) $invoice->ThanhTien;
            if ($amount !== null && $amount > 0 && $amount + 0.0001 < $expectedAmount) {
                Log::warning('bank_transfer_webhook_rejected', [
                    'reason' => 'insufficient_amount',
                    'invoice_id' => $invoiceId,
                    'expected_amount' => $expectedAmount,
                    'received_amount' => $amount,
                ]);

                return response()->json([
                    'success' => false,
                    'code' => 'INSUFFICIENT_AMOUNT',
                    'message' => 'Số tiền chuyển khoản chưa đủ để xác nhận hóa đơn.',
                    'data' => [
                        'expected_amount' => $expectedAmount,
                        'received_amount' => $amount,
                    ],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            DB::transaction(function () use ($invoiceId) {
                Invoice::where('MaHD', $invoiceId)->update(['TrangThai' => 1]);

                RoomBooking::where('MaHD', $invoiceId)
                    ->where('TrangThai', 1)
                    ->update(['ThanhToan' => 1]);

                TourBooking::where('MaHD', $invoiceId)
                    ->where('TrangThai', 1)
                    ->update(['ThanhToan' => 1]);
            });

            $freshInvoice = Invoice::with('rooms.room.type')->findOrFail($invoiceId);

            Log::info('bank_transfer_webhook_confirmed', [
                'invoice_id' => $invoiceId,
                'received_amount' => $amount,
                'content' => $content,
            ]);

            return response()->json([
                'success' => true,
                'code' => 'PAYMENT_CONFIRMED_WEBHOOK',
                'message' => 'Đã ghi nhận thanh toán từ webhook ngân hàng.',
                'data' => [
                    'invoice' => $this->mapInvoice($freshInvoice),
                    'received_amount' => $amount,
                    'transfer_content' => $content,
                ],
            ], Response::HTTP_OK);
        } catch (Throwable $e) {
            Log::error('bank_transfer_webhook_error', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'code' => 'SERVER_ERROR',
                'message' => 'Có lỗi hệ thống khi xử lý webhook ngân hàng.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function findMinAvailableRoom(string $checkIn, string $checkOut, ?int $maLoai, ?string $roomType, ?string $roomVariant): ?Room
    {
        $query = Room::query()
            ->with('type')
            ->availableBetween($checkIn, $checkOut)
            ->orderBy('MaPhong');

        if ($maLoai !== null) {
            $query->where('MaLoai', $maLoai);
        } elseif ($roomType !== null && trim($roomType) !== '') {
            $query->whereHas('type', fn($q) => $q->where('TenLoai', trim($roomType)));
        }

        if ($roomVariant === 'view') {
            $query->whereRaw('LOWER(TenPhong) LIKE ?', ['%view%']);
        } elseif ($roomVariant === 'nt') {
            $query->whereRaw('LOWER(TenPhong) LIKE ?', ['%nt%']);
        }

        return $query->first();
    }

    private function buildTransferDescription(int $invoiceId): string
    {
        return 'THANH TOAN HD' . $invoiceId;
    }

    private function extractInvoiceIdFromTransferContent(string $content): ?int
    {
        if (preg_match('/(?:HD|HĐ|MA\s*HD|MAHD|HOA\s*DON|HOA\s*D[OÔ]N)\s*[:#-]?\s*([0-9]{1,10})/iu', $content, $matches) === 1) {
            return (int) ($matches[1] ?? 0) ?: null;
        }

        // Fallback cho provider không giữ đúng prefix, nhưng nội dung có ngữ cảnh chuyển khoản.
        $hasTransferKeyword = preg_match('/THANH\s*TOAN|CHUYEN\s*KHOAN|TRANSFER|PAYMENT/iu', $content) === 1;
        if ($hasTransferKeyword && preg_match_all('/([0-9]{2,10})/u', $content, $allMatches) > 0) {
            $numbers = $allMatches[1] ?? [];
            if (count($numbers) === 1) {
                return (int) $numbers[0] ?: null;
            }
        }

        return null;
    }

    private function parseTransferAmount(mixed $rawAmount): ?float
    {
        if ($rawAmount === null) {
            return null;
        }

        if (is_int($rawAmount) || is_float($rawAmount)) {
            return (float) $rawAmount;
        }

        $amount = trim((string) $rawAmount);
        if ($amount == '') {
            return null;
        }

        $amount = preg_replace('/[^0-9,.-]/u', '', $amount) ?? '';
        if ($amount == '') {
            return null;
        }

        $commaCount = substr_count($amount, ',');
        $dotCount = substr_count($amount, '.');

        if ($commaCount > 0 && $dotCount > 0) {
            $lastCommaPos = strrpos($amount, ',');
            $lastDotPos = strrpos($amount, '.');

            if ($lastCommaPos !== false && $lastDotPos !== false && $lastCommaPos > $lastDotPos) {
                // Ví dụ 1.234,56
                $amount = str_replace('.', '', $amount);
                $amount = str_replace(',', '.', $amount);
            } else {
                // Ví dụ 1,234.56
                $amount = str_replace(',', '', $amount);
            }
        } elseif ($commaCount > 0) {
            $lastCommaPos = strrpos($amount, ',');
            $decimalsLength = $lastCommaPos !== false ? strlen(substr($amount, $lastCommaPos + 1)) : 0;

            if ($commaCount === 1 && $decimalsLength > 0 && $decimalsLength <= 2) {
                $amount = str_replace(',', '.', $amount);
            } else {
                $amount = str_replace(',', '', $amount);
            }
        } elseif ($dotCount > 1) {
            // Ví dụ 1.234.567
            $amount = str_replace('.', '', $amount);
        }

        if (!is_numeric($amount)) {
            return null;
        }

        $parsedAmount = (float) $amount;
        return is_finite($parsedAmount) ? $parsedAmount : null;
    }

    private function isManualConfirmAuthorized(Request $request): bool
    {
        $secret = trim((string) env('MANUAL_PAYMENT_CONFIRM_SECRET', ''));
        if ($secret === '') {
            return false;
        }

        $headerSecret = trim((string) $request->header('X-Manual-Confirm-Secret', ''));
        $bodySecret = trim((string) $request->input('secret', ''));

        return hash_equals($secret, $headerSecret) || hash_equals($secret, $bodySecret);
    }

    private function buildVietQrUrl(float $amount, string $description): string
    {
        $bankId = env('HOTEL_BANK_ID', 'MB');
        $accountNo = env('HOTEL_ACCOUNT_NO', '');
        $accountName = env('HOTEL_ACCOUNT_NAME', 'KHACH SAN');

        if (empty($accountNo)) {
            // Fallback: QR text thuần nếu chưa cấu hình tài khoản
            return 'https://quickchart.io/qr?size=280&text=' . urlencode($description);
        }

        return sprintf(
            'https://img.vietqr.io/image/%s-%s-compact2.png?amount=%s&addInfo=%s&accountName=%s',
            urlencode($bankId),
            urlencode($accountNo),
            number_format($amount, 0, '.', ''),
            urlencode($description),
            urlencode($accountName),
        );
    }

    private function getBankInfo(): array
    {
        return [
            'bank_id' => env('HOTEL_BANK_ID', 'MB'),
            'account_no' => env('HOTEL_ACCOUNT_NO', ''),
            'account_name' => env('HOTEL_ACCOUNT_NAME', 'KHACH SAN'),
        ];
    }

    public function listByCustomer(Request $request, $maKh): JsonResponse
    {
        try {
            $customer = Customer::findOrFail($maKh);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Khách hàng không tồn tại.'], Response::HTTP_NOT_FOUND);
        }

        $invoices = $customer->invoices()
            ->with(['rooms.room.type', 'tourBookings.departureSchedule.tour'])
            ->orderByDesc('MaHD')
            ->get()
            ->map(fn (Invoice $invoice) => $this->mapInvoice($invoice));

        return response()->json($invoices->values());
    }

    public function cancelRoomBooking(Request $request, int $maHD, string $maPhong): JsonResponse
    {
        try {
            $payload = $request->validate([
                'remove_record' => ['nullable', 'boolean'],
            ]);
            $removeRecord = (bool) ($payload['remove_record'] ?? false);

            $roomBooking = RoomBooking::where('MaHD', $maHD)
                ->where('MaPhong', $maPhong)
                ->where('TrangThai', 1)
                ->first();

            if (!$roomBooking) {
                return response()->json([
                    'success' => false,
                    'code' => 'ROOM_BOOKING_NOT_FOUND',
                    'message' => 'Không tìm thấy hóa đơn phòng này.',
                ], Response::HTTP_NOT_FOUND);
            }

            // Nếu phòng đã được thanh toán, không cho phép hủy
            if ($roomBooking->ThanhToan) {
                return response()->json([
                    'success' => false,
                    'code' => 'ROOM_ALREADY_PAID',
                    'message' => 'Không thể hủy phòng đã được thanh toán.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $invoice = Invoice::find($maHD);
            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'code' => 'INVOICE_NOT_FOUND',
                    'message' => 'Không tìm thấy hóa đơn.',
                ], Response::HTTP_NOT_FOUND);
            }

            // Nếu hóa đơn đã thanh toán, không cho phép hủy
            if ($invoice->TrangThai == 1) {
                return response()->json([
                    'success' => false,
                    'code' => 'INVOICE_ALREADY_PAID',
                    'message' => 'Không thể hủy phòng trong hóa đơn đã thanh toán.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $result = DB::transaction(function () use ($roomBooking, $invoice, $maHD, $maPhong, $removeRecord) {
                if ($removeRecord) {
                    $roomBooking->delete();
                } else {
                    $roomBooking->TrangThai = 0;
                    $roomBooking->save();
                }

                $remainingTotal = (float) RoomBooking::where('MaHD', $maHD)
                    ->where('TrangThai', 1)
                    ->sum('TongTien');

                if ($removeRecord && $remainingTotal <= 0) {
                    $invoice->delete();

                    return [
                        'invoice' => null,
                        'booking' => null,
                        'invoice_deleted' => true,
                    ];
                }

                $invoice->update(['ThanhTien' => round($remainingTotal, 2)]);

                return [
                    'invoice' => $invoice->fresh()->load('rooms.room.type'),
                    'booking' => RoomBooking::where('MaHD', $maHD)
                        ->where('MaPhong', $maPhong)
                        ->with('room.type')
                        ->first(),
                    'invoice_deleted' => false,
                ];
            });

            return response()->json([
                'success' => true,
                'code' => 'ROOM_CANCELLED',
                'message' => $removeRecord
                    ? 'Đã hủy giữ chỗ online chưa thanh toán.'
                    : 'Hủy phòng thành công. Phòng này giờ đã có thể được đặt bởi khách hàng khác.',
                'data' => [
                    'invoice' => $result['invoice'] ? $this->mapInvoice($result['invoice']) : null,
                    'booking' => $result['booking'] ? $this->mapRoomBooking($result['booking']) : null,
                    'invoice_deleted' => (bool) ($result['invoice_deleted'] ?? false),
                ],
            ], Response::HTTP_OK);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'code' => 'SERVER_ERROR',
                'message' => 'Có lỗi hệ thống khi hủy phòng.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function mapInvoice(Invoice $invoice): array
    {
        $isPaid = (bool) $invoice->TrangThai;

        return [
            'ma_hd' => (int) $invoice->MaHD,
            'ma_kh' => (int) $invoice->MaKH,
            'ngay_tao' => optional($invoice->NgayTao)->format('Y-m-d') ?? (string) $invoice->NgayTao,
            'thanh_tien' => (float) $invoice->ThanhTien,
            'trang_thai' => $isPaid ? 1 : 0,
            'payment_status' => $isPaid ? 'paid' : 'unpaid',
            'payment_status_label' => $isPaid ? 'Đã thanh toán' : 'Chưa thanh toán',
            'rooms' => $invoice->rooms->map(fn (RoomBooking $roomBooking) => $this->mapRoomBooking($roomBooking))->values(),
            'tours' => $invoice->tourBookings->map(fn ($tb) => $this->mapTourBooking($tb))->values(),
        ];
    }

    private function mapTourBooking($tourBooking): array
    {
        $schedule = $tourBooking->departureSchedule;
        $tour     = $schedule?->tour;

        return [
            'ma_hd'        => (int) $tourBooking->MaHD,
            'ma_lkh'       => (int) $tourBooking->MaLKH,
            'so_nguoi_lon' => (int) $tourBooking->SoNguoiLon,
            'so_tre_em'    => (int) $tourBooking->SoTreEm,
            'tong_tien'    => (float) $tourBooking->TongTien,
            'trang_thai'   => (int) ((bool) $tourBooking->TrangThai),
            'thanh_toan'   => (int) ((bool) $tourBooking->ThanhToan),
            'payment_status_label' => $tourBooking->ThanhToan ? 'Đã thanh toán' : 'Chưa thanh toán',
            'schedule' => $schedule ? [
                'ma_lkh'        => (int) $schedule->MaLKH,
                'ngay_khoi_hanh'=> optional($schedule->NgayKhoiHanh)->format('Y-m-d'),
                'ngay_ket_thuc' => optional($schedule->NgayKetThuc)->format('Y-m-d'),
            ] : null,
            'tour' => $tour ? [
                'ma_tour'           => (string) $tour->MaTour,
                'ten_tour'          => (string) ($tour->TenTour ?? ''),
                'dia_diem_khoi_hanh'=> (string) ($tour->DiaDiemKhoiHanh ?? ''),
            ] : null,
        ];
    }

    private function mapRoomBooking(RoomBooking $roomBooking): array
    {
        $room = $roomBooking->room;
        $roomType = $room?->type;

        return [
            'ma_hd' => (int) $roomBooking->MaHD,
            'ma_phong' => (string) $roomBooking->MaPhong,
            'ngay_nhan_phong' => optional($roomBooking->NgayNhanPhong)->format('Y-m-d') ?? (string) $roomBooking->NgayNhanPhong,
            'ngay_tra_phong' => optional($roomBooking->NgayTraPhong)->format('Y-m-d') ?? (string) $roomBooking->NgayTraPhong,
            'tong_tien' => (float) $roomBooking->TongTien,
            'trang_thai' => (int) ((bool) $roomBooking->TrangThai),
            'booking_status_label' => $roomBooking->TrangThai ? 'Đang giữ chỗ' : 'Đã hủy',
            'thanh_toan' => (int) ((bool) $roomBooking->ThanhToan),
            'payment_status' => $roomBooking->ThanhToan ? 'paid' : 'unpaid',
            'payment_status_label' => $roomBooking->ThanhToan ? 'Đã thanh toán' : 'Chưa thanh toán',
            'room' => $room ? [
                'MaPhong' => (string) $room->MaPhong,
                'TenPhong' => $room->TenPhong ?? '',
                'MaLoai' => (int) ($room->MaLoai ?? 0),
                'GiaPhong' => (float) ($room->GiaPhong ?? 0),
                'HinhAnh' => $room->HinhAnh ?? '',
                'SoLuongNguoi' => (int) ($room->SoLuongNguoi ?? 0),
                'MoTa' => $room->attributes['MoTa'] ?? '',
                'TenLoai' => $roomType?->TenLoai ?? '',
                'type' => [
                    'TenLoai' => $roomType?->TenLoai ?? '',
                ],
            ] : null,
        ];
    }
}
