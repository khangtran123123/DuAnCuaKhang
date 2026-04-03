<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Concerns\HandlesPayment;
use App\Models\Invoice;
use App\Models\RoomBooking;
use App\Models\TourBooking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Xử lý toàn bộ nghiệp vụ thanh toán: kiểm tra trạng thái, xác nhận thủ công
 * và nhận webhook chuyển khoản ngân hàng.
 * Dùng chung cho cả đặt phòng đơn lẫn đặt combo.
 */
class PaymentController extends Controller
{
    use HandlesPayment;

    public function checkTransfer(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'transfer_content' => ['required', 'string', 'min:3', 'max:255'],
                'expected_amount'  => ['required', 'numeric', 'min:1'],
            ]);

            $result = $this->verifyIncomingTransfer(
                (string) $data['transfer_content'],
                (float) $data['expected_amount'],
            );

            if (!$result['matched']) {
                return response()->json([
                    'success' => false,
                    'code'    => 'TRANSFER_NOT_FOUND',
                    'message' => 'Chua ghi nhan bien dong so du phu hop.',
                    'data'    => [
                        'matched' => false,
                        'reason'  => $result['reason'],
                    ],
                ], Response::HTTP_OK);
            }

            return response()->json([
                'success' => true,
                'code'    => 'TRANSFER_MATCHED',
                'message' => 'Da ghi nhan bien dong so du.',
                'data'    => [
                    'matched'     => true,
                    'transaction' => $result['transaction'],
                ],
            ], Response::HTTP_OK);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'code'    => 'SERVER_ERROR',
                'message' => 'Co loi he thong khi kiem tra bien dong so du.',
                'error'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // ── Kiểm tra trạng thái thanh toán hóa đơn ────────────────────────────

    public function paymentStatus(Request $request, int $maHD): JsonResponse
    {
        try {
            $invoice = Invoice::with(['rooms.room.type', 'tourBookings.departureSchedule.tour'])->find($maHD);

            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'code'    => 'INVOICE_NOT_FOUND',
                    'message' => 'Không tìm thấy hóa đơn.',
                ], Response::HTTP_NOT_FOUND);
            }

            $isPaid = (int) $invoice->ThanhToan === 1;

            return response()->json([
                'success' => true,
                'code'    => 'PAYMENT_STATUS',
                'message' => $isPaid ? 'Hóa đơn đã thanh toán.' : 'Hóa đơn chưa thanh toán.',
                'data'    => [
                    'ma_hd'                => (int) $invoice->MaHD,
                    'is_paid'              => $isPaid,
                    'payment_status'       => $isPaid ? 'paid' : 'unpaid',
                    'payment_status_label' => $isPaid ? 'Đã thanh toán' : 'Chưa thanh toán',
                    'invoice'              => $this->mapInvoice($invoice),
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

    // ── Xác nhận thanh toán thủ công (cần header bí mật) ──────────────────

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

            $invoice = Invoice::with(['rooms.room.type', 'tourBookings.departureSchedule.tour'])->find($maHD);

            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'code'    => 'INVOICE_NOT_FOUND',
                    'message' => 'Không tìm thấy hóa đơn.',
                ], Response::HTTP_NOT_FOUND);
            }

            if ((int) $invoice->ThanhToan === 1) {
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
                'message' => 'Xác nhận thanh toán thành công.',
                'data'    => [
                    'invoice' => $this->mapInvoice(
                        $invoice->fresh()->load(['rooms.room.type', 'tourBookings.departureSchedule.tour'])
                    ),
                ],
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

    // ── Webhook chuyển khoản ngân hàng ────────────────────────────────────

    public function bankTransferWebhook(Request $request): JsonResponse
    {
        try {
            $authorizationHeader = (string) $request->header('Authorization', '');

            Log::info('bank_transfer_webhook_received', [
                'headers' => [
                    'user-agent'                   => $request->userAgent(),
                    'authorization-present'        => $authorizationHeader !== '',
                    'x-webhook-secret-present'     => $request->header('X-Webhook-Secret') !== null,
                ],
                'payload' => $request->all(),
            ]);

            // Xác thực webhook: ưu tiên API key kiểu SePay, fallback header/body secret cũ.
            $secret       = trim((string) env('SEPAY_WEBHOOK_API_KEY', env('BANK_WEBHOOK_SECRET', '')));
            $headerSecret = trim((string) $request->header('X-Webhook-Secret', ''));
            $bodySecret   = trim((string) $request->input('secret', ''));
            $bodyApiKey   = trim((string) $request->input('api_key', ''));
            $authToken    = $this->normalizeAuthToken($authorizationHeader);

            if (
                $secret !== ''
                && !hash_equals($secret, $authToken)
                && !hash_equals($secret, $headerSecret)
                && !hash_equals($secret, $bodySecret)
                && !hash_equals($secret, $bodyApiKey)
            ) {
                Log::warning('bank_transfer_webhook_rejected', ['reason' => 'invalid_secret']);

                return response()->json([
                    'success' => false,
                    'code'    => 'WEBHOOK_UNAUTHORIZED',
                    'message' => 'Webhook secret/API key không hợp lệ.',
                ], Response::HTTP_UNAUTHORIZED);
            }

            // Lấy nội dung chuyển khoản
            $content = trim((string) (
                $request->input('content')
                ?? $request->input('description')
                ?? $request->input('transfer_content')
                ?? $request->input('data.content')
                ?? $request->input('data.description')
                ?? $request->input('data.transfer_content')
                ?? ''
            ));

            // Lấy và parse số tiền
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
                Log::warning('bank_transfer_webhook_rejected', ['reason' => 'missing_content', 'amount' => $amount]);

                return response()->json([
                    'success' => false,
                    'code'    => 'INVALID_TRANSFER_CONTENT',
                    'message' => 'Thiếu nội dung chuyển khoản.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $invoiceId = $this->extractInvoiceIdFromTransferContent($content);
            if (!$invoiceId) {
                Log::info('bank_transfer_webhook_ignored', [
                    'reason'  => 'invoice_not_detected',
                    'content' => $content,
                    'amount'  => $amount,
                ]);

                return response()->json([
                    'success' => true,
                    'code'    => 'IGNORED_TRANSFER',
                    'message' => 'Không tìm thấy mã hóa đơn trong nội dung chuyển khoản.',
                ], Response::HTTP_OK);
            }

            $invoice = Invoice::with(['rooms.room.type', 'tourBookings.departureSchedule.tour'])->find($invoiceId);
            if (!$invoice) {
                Log::warning('bank_transfer_webhook_rejected', [
                    'reason'     => 'invoice_not_found',
                    'invoice_id' => $invoiceId,
                    'content'    => $content,
                    'amount'     => $amount,
                ]);

                return response()->json([
                    'success' => false,
                    'code'    => 'INVOICE_NOT_FOUND',
                    'message' => 'Không tìm thấy hóa đơn tương ứng nội dung chuyển khoản.',
                ], Response::HTTP_NOT_FOUND);
            }

            if ((int) $invoice->ThanhToan === 1) {
                Log::info('bank_transfer_webhook_already_paid', ['invoice_id' => $invoiceId, 'amount' => $amount]);

                return response()->json([
                    'success' => true,
                    'code'    => 'ALREADY_PAID',
                    'message' => 'Hóa đơn đã thanh toán trước đó.',
                    'data'    => ['invoice' => $this->mapInvoice($invoice)],
                ], Response::HTTP_OK);
            }

            $expectedAmount = (float) $invoice->ThanhTien;
            if ($amount !== null && $amount > 0 && $amount + 0.0001 < $expectedAmount) {
                Log::warning('bank_transfer_webhook_rejected', [
                    'reason'          => 'insufficient_amount',
                    'invoice_id'      => $invoiceId,
                    'expected_amount' => $expectedAmount,
                    'received_amount' => $amount,
                ]);

                return response()->json([
                    'success' => false,
                    'code'    => 'INSUFFICIENT_AMOUNT',
                    'message' => 'Số tiền chuyển khoản chưa đủ để xác nhận hóa đơn.',
                    'data'    => [
                        'expected_amount' => $expectedAmount,
                        'received_amount' => $amount,
                    ],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $this->confirmInvoicePayment($invoiceId);

            $freshInvoice = Invoice::with(['rooms.room.type', 'tourBookings.departureSchedule.tour'])
                ->findOrFail($invoiceId);

            Log::info('bank_transfer_webhook_confirmed', [
                'invoice_id'      => $invoiceId,
                'received_amount' => $amount,
                'content'         => $content,
            ]);

            return response()->json([
                'success' => true,
                'code'    => 'PAYMENT_CONFIRMED_WEBHOOK',
                'message' => 'Đã ghi nhận thanh toán từ webhook ngân hàng.',
                'data'    => [
                    'invoice'          => $this->mapInvoice($freshInvoice),
                    'received_amount'  => $amount,
                    'transfer_content' => $content,
                ],
            ], Response::HTTP_OK);
        } catch (Throwable $e) {
            Log::error('bank_transfer_webhook_error', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'code'    => 'SERVER_ERROR',
                'message' => 'Có lỗi hệ thống khi xử lý webhook ngân hàng.',
                'error'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function normalizeAuthToken(string $authorizationHeader): string
    {
        $authorizationHeader = trim($authorizationHeader);
        if ($authorizationHeader === '') {
            return '';
        }

        if (preg_match('/^apikey\s+(.+)$/i', $authorizationHeader, $matches) === 1) {
            return trim((string) ($matches[1] ?? ''));
        }

        if (preg_match('/^bearer\s+(.+)$/i', $authorizationHeader, $matches) === 1) {
            return trim((string) ($matches[1] ?? ''));
        }

        return $authorizationHeader;
    }

    // ── Mapping helpers (dùng nội bộ) ─────────────────────────────────────

    private function mapInvoice(Invoice $invoice): array
    {
        $isPaid = (bool) $invoice->ThanhToan;

        return [
            'ma_hd'                => (int) $invoice->MaHD,
            'ma_kh'                => (int) $invoice->MaKH,
            'ngay_tao'             => optional($invoice->NgayTao)->format('Y-m-d') ?? (string) $invoice->NgayTao,
            'thanh_tien'           => (float) $invoice->ThanhTien,
            'trang_thai'           => (int) ((bool) $invoice->TrangThai),
            'thanh_toan'           => $isPaid ? 1 : 0,
            'payment_status'       => $isPaid ? 'paid' : 'unpaid',
            'payment_status_label' => $isPaid ? 'Đã thanh toán' : 'Chưa thanh toán',
            'rooms'                => $invoice->rooms->map(fn (RoomBooking $rb) => $this->mapRoomBooking($rb))->values(),
            'tours'                => $invoice->tourBookings->map(fn ($tb) => $this->mapTourBooking($tb))->values(),
        ];
    }

    private function mapRoomBooking(RoomBooking $roomBooking): array
    {
        $room     = $roomBooking->room;
        $roomType = $room?->type;

        return [
            'ma_hd'               => (int) $roomBooking->MaHD,
            'ma_phong'            => (string) $roomBooking->MaPhong,
            'ngay_nhan_phong'     => optional($roomBooking->NgayNhanPhong)->format('Y-m-d') ?? (string) $roomBooking->NgayNhanPhong,
            'ngay_tra_phong'      => optional($roomBooking->NgayTraPhong)->format('Y-m-d') ?? (string) $roomBooking->NgayTraPhong,
            'tong_tien'           => (float) $roomBooking->TongTien,
            'trang_thai'          => (int) ((bool) $roomBooking->TrangThai),
            'booking_status_label'=> $roomBooking->TrangThai ? 'Đang giữ chỗ' : 'Đã hủy',
            'thanh_toan'          => (int) ((bool) $roomBooking->ThanhToan),
            'payment_status'      => $roomBooking->ThanhToan ? 'paid' : 'unpaid',
            'payment_status_label'=> $roomBooking->ThanhToan ? 'Đã thanh toán' : 'Chưa thanh toán',
            'room' => $room ? [
                'MaPhong'      => (string) $room->MaPhong,
                'TenPhong'     => $room->TenPhong ?? '',
                'MaLoai'       => (int) ($room->MaLoai ?? 0),
                'GiaPhong'     => (float) ($room->GiaPhong ?? 0),
                'HinhAnh'      => $room->HinhAnh ?? '',
                'SoLuongNguoi' => (int) ($room->SoLuongNguoi ?? 0),
                'MoTa'         => $room->attributes['MoTa'] ?? '',
                'TenLoai'      => $roomType?->TenLoai ?? '',
                'type'         => ['TenLoai' => $roomType?->TenLoai ?? ''],
            ] : null,
        ];
    }

    private function mapTourBooking($tourBooking): array
    {
        $schedule = $tourBooking->departureSchedule;
        $tour     = $schedule?->tour;

        return [
            'ma_hd'                => (int) $tourBooking->MaHD,
            'ma_lkh'               => (int) $tourBooking->MaLKH,
            'so_nguoi_lon'         => (int) $tourBooking->SoNguoiLon,
            'so_tre_em'            => (int) $tourBooking->SoTreEm,
            'tong_tien'            => (float) $tourBooking->TongTien,
            'trang_thai'           => (int) ((bool) $tourBooking->TrangThai),
            'thanh_toan'           => (int) ((bool) $tourBooking->ThanhToan),
            'payment_status_label' => $tourBooking->ThanhToan ? 'Đã thanh toán' : 'Chưa thanh toán',
            'schedule' => $schedule ? [
                'ma_lkh'         => (int) $schedule->MaLKH,
                'ngay_khoi_hanh' => optional($schedule->NgayKhoiHanh)->format('Y-m-d'),
                'ngay_ket_thuc'  => optional($schedule->NgayKetThuc)->format('Y-m-d'),
            ] : null,
            'tour' => $tour ? [
                'ma_tour'            => (string) $tour->MaTour,
                'ten_tour'           => (string) ($tour->TenTour ?? ''),
                'dia_diem_khoi_hanh' => (string) ($tour->DiaDiemKhoiHanh ?? ''),
            ] : null,
        ];
    }
}
