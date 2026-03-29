<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DepartureSchedule;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\Tour;
use App\Models\TourBooking;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class ComboBookingController extends Controller
{
    // ── Public endpoints ───────────────────────────────────────────────────

    public function bookCombo(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'ma_kh'         => ['required', 'integer', 'exists:tbl_KhachHang,MaKH'],
                'ma_phong'      => ['required', 'string', 'exists:tbl_Phong,MaPhong'],
                'ma_lkh'        => ['required', 'integer', 'exists:tbl_LichKhoiHanh,MaLKH'],
                'so_nguoi_lon'  => ['required', 'integer', 'min:1'],
                'so_tre_em'     => ['required', 'integer', 'min:0'],
                'payment_method'=> ['nullable', 'string', 'in:counter,online'],
            ]);

            $paymentMethod   = $data['payment_method'] ?? 'counter';
            $isOnlinePayment = $paymentMethod === 'online';

            // Lấy lịch khởi hành kèm tour (để lấy giá)
            $schedule = DepartureSchedule::with('tour')->find($data['ma_lkh']);
            if (!$schedule) {
                return response()->json([
                    'success' => false,
                    'code'    => 'SCHEDULE_NOT_FOUND',
                    'message' => 'Không tìm thấy lịch khởi hành.',
                ], Response::HTTP_NOT_FOUND);
            }

            $tour = $schedule->tour;
            if (!$tour) {
                return response()->json([
                    'success' => false,
                    'code'    => 'TOUR_NOT_FOUND',
                    'message' => 'Không tìm thấy thông tin tour.',
                ], Response::HTTP_NOT_FOUND);
            }

            $room = Room::with('type')->find($data['ma_phong']);
            if (!$room || is_null($room->GiaPhong)) {
                return response()->json([
                    'success' => false,
                    'code'    => 'ROOM_NOT_FOUND',
                    'message' => 'Không tìm thấy thông tin phòng hoặc giá phòng.',
                ], Response::HTTP_NOT_FOUND);
            }

            $checkIn  = Carbon::parse($schedule->NgayKhoiHanh)->startOfDay();
            $checkOut = Carbon::parse($schedule->NgayKetThuc)->startOfDay();
            $nights   = max(1, $checkIn->diffInDays($checkOut));

            // Kiểm tra xung đột phòng
            $conflict = RoomBooking::where('MaPhong', $data['ma_phong'])
                ->where('TrangThai', 1)
                ->where(function ($q) use ($checkIn, $checkOut) {
                    $checkInStr  = $checkIn->toDateString();
                    $checkOutStr = $checkOut->toDateString();
                    $q->whereBetween('NgayNhanPhong', [$checkInStr, $checkOutStr])
                      ->orWhereBetween('NgayTraPhong', [$checkInStr, $checkOutStr])
                      ->orWhere(function ($sub) use ($checkInStr, $checkOutStr) {
                          $sub->where('NgayNhanPhong', '<', $checkInStr)
                              ->where('NgayTraPhong', '>', $checkOutStr);
                      });
                })
                ->exists();

            if ($conflict) {
                return response()->json([
                    'success' => false,
                    'code'    => 'ROOM_CONFLICT',
                    'message' => 'Phòng đã được đặt trong khoảng thời gian lịch khởi hành.',
                ], Response::HTTP_CONFLICT);
            }

            // Tính tiền
            $giaNguoiLon = (float) $tour->GiaTourNguoiLon;
            $giaTreEm    = (float) $tour->GiaTourTreEm;
            $tourTotal   = round(($giaNguoiLon * $data['so_nguoi_lon']) + ($giaTreEm * $data['so_tre_em']), 2);
            $roomTotal   = round((float) $room->GiaPhong * $nights, 2);
            $comboTotal  = round($tourTotal + $roomTotal, 2);

            $result = DB::transaction(function () use (
                $data, $checkIn, $checkOut, $nights,
                $tourTotal, $roomTotal, $comboTotal,
                $paymentMethod, $isOnlinePayment
            ) {
                // Tạo hóa đơn
                $invoice = Invoice::create([
                    'MaKH'     => $data['ma_kh'],
                    'NgayTao'  => now()->toDateString(),
                    'ThanhTien'=> $comboTotal,
                    'TrangThai'=> 0,
                ]);

                // Tạo chi tiết phòng
                $roomBooking = RoomBooking::create([
                    'MaHD'          => $invoice->MaHD,
                    'MaPhong'       => $data['ma_phong'],
                    'NgayNhanPhong' => $checkIn->toDateString(),
                    'NgayTraPhong'  => $checkOut->toDateString(),
                    'TongTien'      => $roomTotal,
                    'TrangThai'     => 1,
                    'ThanhToan'     => 0,
                ]);

                // Tạo chi tiết tour
                TourBooking::create([
                    'MaHD'       => $invoice->MaHD,
                    'MaLKH'      => $data['ma_lkh'],
                    'SoNguoiLon' => $data['so_nguoi_lon'],
                    'SoTreEm'    => $data['so_tre_em'],
                    'TongTien'   => $tourTotal,
                    'TrangThai'  => 1,
                    'ThanhToan'  => 0,
                ]);

                $transferDesc = $this->buildTransferDescription((int) $invoice->MaHD);
                $onlinePaymentData = $isOnlinePayment
                    ? $this->buildOnlinePaymentData($comboTotal, (int) $invoice->MaHD, $transferDesc)
                    : null;

                return [
                    'invoice'      => $invoice->fresh(),
                    'room_booking' => $roomBooking->load('room.type'),
                    'pricing'      => [
                        'tien_tour'    => $tourTotal,
                        'tien_phong'   => $roomTotal,
                        'so_dem'       => $nights,
                        'tong_combo'   => $comboTotal,
                    ],
                    'payment_method'       => $paymentMethod,
                    'payment_method_label' => $isOnlinePayment ? 'Chuyển khoản' : 'Thanh toán tại quầy',
                    'payment_provider' => $onlinePaymentData['payment_provider'] ?? null,
                    'payment_meta' => $onlinePaymentData['payment_meta'] ?? null,
                    'qr_payload'   => $onlinePaymentData['qr_payload'] ?? null,
                    'qr_code_url'  => $onlinePaymentData['qr_code_url'] ?? null,
                    'bank_info'    => $onlinePaymentData['bank_info'] ?? null,
                ];
            });

            return response()->json([
                'success' => true,
                'code'    => 'COMBO_BOOKING_CREATED',
                'message' => 'Đặt combo thành công.',
                'data'    => [
                    'invoice'      => $this->mapInvoice($result['invoice']->fresh()),
                    'booking'      => $this->mapRoomBooking($result['room_booking']),
                    'pricing'      => $result['pricing'],
                    'payment_method'       => $result['payment_method'],
                    'payment_method_label' => $result['payment_method_label'],
                    'payment_provider' => $result['payment_provider'] ?? null,
                    'payment_meta' => $result['payment_meta'] ?? null,
                    'qr_payload'   => $result['qr_payload'],
                    'qr_code_url'  => $result['qr_code_url'],
                    'bank_info'    => $result['bank_info'],
                ],
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'code'    => 'VALIDATION_ERROR',
                'message' => 'Dữ liệu không hợp lệ.',
                'errors'  => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'code'    => 'SERVER_ERROR',
                'message' => 'Có lỗi hệ thống, vui lòng thử lại.',
                'error'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function paymentStatus(Request $request, int $maHD): JsonResponse
    {
        try {
            $invoice = Invoice::find($maHD);

            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'code'    => 'INVOICE_NOT_FOUND',
                    'message' => 'Không tìm thấy hóa đơn.',
                ], Response::HTTP_NOT_FOUND);
            }

            $isPaid = (int) $invoice->TrangThai === 1;

            return response()->json([
                'success' => true,
                'code'    => 'PAYMENT_STATUS',
                'message' => $isPaid ? 'Hóa đơn đã thanh toán.' : 'Hóa đơn chưa thanh toán.',
                'data'    => [
                    'ma_hd'                => (int) $invoice->MaHD,
                    'is_paid'              => $isPaid,
                    'payment_status'       => $isPaid ? 'paid' : 'unpaid',
                    'payment_status_label' => $isPaid ? 'Đã thanh toán' : 'Chưa thanh toán',
                ],
            ], Response::HTTP_OK);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'code'    => 'SERVER_ERROR',
                'message' => 'Có lỗi hệ thống khi kiểm tra trạng thái thanh toán.',
                'error'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function confirmPayment(Request $request, int $maHD): JsonResponse
    {
        try {
            if (!$this->isManualConfirmAuthorized($request)) {
                return response()->json([
                    'success' => false,
                    'code'    => 'MANUAL_CONFIRM_FORBIDDEN',
                    'message' => 'Xác nhận thanh toán thủ công từ ứng dụng khách đã bị tắt. Vui lòng chờ webhook ngân hàng hoặc dùng kênh quản trị.',
                ], Response::HTTP_FORBIDDEN);
            }

            $invoice = Invoice::find($maHD);

            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'code'    => 'INVOICE_NOT_FOUND',
                    'message' => 'Không tìm thấy hóa đơn.',
                ], Response::HTTP_NOT_FOUND);
            }

            if ((int) $invoice->TrangThai === 1) {
                return response()->json([
                    'success' => true,
                    'code'    => 'ALREADY_PAID',
                    'message' => 'Hóa đơn đã được thanh toán trước đó.',
                    'data'    => ['invoice' => $this->mapInvoice($invoice)],
                ]);
            }

            $this->confirmInvoicePayment($maHD);

            return response()->json([
                'success' => true,
                'code'    => 'PAYMENT_CONFIRMED',
                'message' => 'Xác nhận thanh toán combo thành công.',
                'data'    => ['invoice' => $this->mapInvoice($invoice->fresh())],
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'code'    => 'SERVER_ERROR',
                'message' => 'Có lỗi hệ thống khi xác nhận thanh toán.',
                'error'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // ── Cancellation endpoint (khi user đóng QR mà chưa trả) ─────────────

    public function cancelComboBooking(Request $request, int $maHD): JsonResponse
    {
        try {
            $invoice = Invoice::find($maHD);

            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'code'    => 'INVOICE_NOT_FOUND',
                    'message' => 'Không tìm thấy hóa đơn.',
                ], Response::HTTP_NOT_FOUND);
            }

            if ((int) $invoice->TrangThai === 1) {
                return response()->json([
                    'success' => false,
                    'code'    => 'INVOICE_ALREADY_PAID',
                    'message' => 'Không thể hủy hóa đơn đã thanh toán.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            DB::transaction(function () use ($maHD, $invoice) {
                RoomBooking::where('MaHD', $maHD)->delete();
                TourBooking::where('MaHD', $maHD)->delete();
                $invoice->delete();
            });

            return response()->json([
                'success' => true,
                'code'    => 'COMBO_CANCELLED',
                'message' => 'Đã hủy combo chưa thanh toán.',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'code'    => 'SERVER_ERROR',
                'message' => 'Có lỗi hệ thống khi hủy combo.',
                'error'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // ── Private helpers ────────────────────────────────────────────────────

    private function confirmInvoicePayment(int $maHD): void
    {
        DB::transaction(function () use ($maHD) {
            Invoice::where('MaHD', $maHD)->update(['TrangThai' => 1]);
            RoomBooking::where('MaHD', $maHD)->where('TrangThai', 1)->update(['ThanhToan' => 1]);
            TourBooking::where('MaHD', $maHD)->where('TrangThai', 1)->update(['ThanhToan' => 1]);
        });
    }

    private function buildTransferDescription(int $invoiceId): string
    {
        return 'THANH TOAN HD' . $invoiceId;
    }

    private function buildVietQrUrl(float $amount, string $description): string
    {
        $bankId      = env('HOTEL_BANK_ID', 'MB');
        $accountNo   = env('HOTEL_ACCOUNT_NO', '');
        $accountName = env('HOTEL_ACCOUNT_NAME', 'KHACH SAN');

        if (empty($accountNo)) {
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
            'bank_id'      => env('HOTEL_BANK_ID', 'MB'),
            'account_no'   => env('HOTEL_ACCOUNT_NO', ''),
            'account_name' => env('HOTEL_ACCOUNT_NAME', 'KHACH SAN'),
        ];
    }

    private function buildOnlinePaymentData(float $amount, int $invoiceId, string $transferDesc): array
    {
        try {
            $zaloData = $this->createZaloPayOrder($amount, $invoiceId);
            if ($zaloData !== null) {
                return $zaloData;
            }
        } catch (Throwable $e) {
            Log::warning('zalopay_create_order_failed_combo', [
                'invoice_id' => $invoiceId,
                'message' => $e->getMessage(),
            ]);
        }

        return [
            'payment_provider' => 'vietqr',
            'payment_meta' => null,
            'qr_payload' => $transferDesc,
            'qr_code_url' => $this->buildVietQrUrl($amount, $transferDesc),
            'bank_info' => $this->getBankInfo(),
        ];
    }

    private function createZaloPayOrder(float $amount, int $invoiceId): ?array
    {
        $enabled = filter_var(config('services.zalopay.enabled', false), FILTER_VALIDATE_BOOL);
        $appId = trim((string) config('services.zalopay.app_id', ''));
        $key1 = trim((string) config('services.zalopay.key1', ''));
        $createEndpoint = trim((string) config('services.zalopay.create_endpoint', ''));

        if (!$enabled || $appId === '' || $key1 === '' || $createEndpoint === '') {
            return null;
        }

        $amountInt = (int) round($amount, 0);
        if ($amountInt <= 0) {
            return null;
        }

        $appTransId = now()->format('ymd') . '_' . $invoiceId . '_' . random_int(100000, 999999);
        $appTime = (int) round(microtime(true) * 1000);
        $callbackUrl = trim((string) config('services.zalopay.callback_url', ''));
        if ($callbackUrl === '') {
            $callbackUrl = rtrim((string) config('app.url'), '/') . '/api/webhooks/zalopay';
        }

        $embedData = json_encode([
            'invoice_id' => $invoiceId,
            'redirect_url' => trim((string) config('services.zalopay.redirect_url', '')),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $item = '[]';

        $orderData = [
            'app_id' => $appId,
            'app_user' => 'invoice_' . $invoiceId,
            'app_time' => $appTime,
            'amount' => $amountInt,
            'app_trans_id' => $appTransId,
            'embed_data' => $embedData,
            'item' => $item,
            'description' => 'Thanh toan hoa don ' . $invoiceId,
            'bank_code' => trim((string) config('services.zalopay.bank_code', '')),
            'callback_url' => $callbackUrl,
        ];

        $dataToSign = implode('|', [
            $orderData['app_id'],
            $orderData['app_trans_id'],
            $orderData['app_user'],
            $orderData['amount'],
            $orderData['app_time'],
            $orderData['embed_data'],
            $orderData['item'],
        ]);
        $orderData['mac'] = hash_hmac('sha256', $dataToSign, $key1);

        $response = Http::asForm()->timeout(20)->post($createEndpoint, $orderData);
        if (!$response->successful()) {
            throw new \RuntimeException('ZaloPay HTTP ' . $response->status());
        }

        $payload = $response->json();
        if (!is_array($payload)) {
            throw new \RuntimeException('Invalid ZaloPay response payload');
        }

        if ((int) ($payload['return_code'] ?? -1) !== 1) {
            throw new \RuntimeException((string) ($payload['return_message'] ?? 'ZaloPay create order failed'));
        }

        $paymentUrl = (string) ($payload['order_url'] ?? $payload['orderurl'] ?? '');
        $zpToken = (string) ($payload['zp_trans_token'] ?? '');
        if ($paymentUrl === '' && $zpToken !== '') {
            $paymentUrl = 'https://sbgateway.zalopay.vn/openinapp?order=' . urlencode($zpToken);
        }
        if ($paymentUrl === '') {
            throw new \RuntimeException('Missing order_url from ZaloPay response');
        }

        return [
            'payment_provider' => 'zalopay',
            'payment_meta' => [
                'app_trans_id' => $appTransId,
                'zp_trans_token' => $zpToken,
                'order_url' => $paymentUrl,
            ],
            'qr_payload' => $paymentUrl,
            'qr_code_url' => 'https://quickchart.io/qr?size=280&text=' . urlencode($paymentUrl),
            'bank_info' => null,
        ];
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

    private function mapInvoice(Invoice $invoice): array
    {
        return [
            'ma_hd'      => (int) $invoice->MaHD,
            'ma_kh'      => (int) $invoice->MaKH,
            'ngay_tao'   => optional($invoice->NgayTao)->toDateString(),
            'thanh_tien' => (float) $invoice->ThanhTien,
            'trang_thai' => (int) $invoice->TrangThai,
        ];
    }

    private function mapRoomBooking(RoomBooking $rb): array
    {
        return [
            'ma_hd'           => (int) $rb->MaHD,
            'ma_phong'        => (string) $rb->MaPhong,
            'ngay_nhan_phong' => optional($rb->NgayNhanPhong)->toDateString(),
            'ngay_tra_phong'  => optional($rb->NgayTraPhong)->toDateString(),
            'tong_tien'       => (float) $rb->TongTien,
            'trang_thai'      => (int) $rb->TrangThai,
            'thanh_toan'      => (int) $rb->ThanhToan,
        ];
    }
}
