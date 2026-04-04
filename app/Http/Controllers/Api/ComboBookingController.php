<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Concerns\HandlesPayment;
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
use Illuminate\Validation\ValidationException;
use Throwable;

class ComboBookingController extends Controller
{
    use HandlesPayment;

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

            $room = Room::with('type.images')->find($data['ma_phong']);
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

                return [
                    'invoice'      => $invoice->fresh(),
                    'room_booking' => $roomBooking->load('room.type.images'),
                    'pricing'      => [
                        'tien_tour'    => $tourTotal,
                        'tien_phong'   => $roomTotal,
                        'so_dem'       => $nights,
                        'tong_combo'   => $comboTotal,
                    ],
                    'payment_method'       => $paymentMethod,
                    'payment_method_label' => $isOnlinePayment ? 'Chuyển khoản' : 'Thanh toán tại quầy',
                    'qr_payload'   => $isOnlinePayment ? $transferDesc : null,
                    'qr_code_url'  => $isOnlinePayment ? $this->buildVietQrUrl($comboTotal, $transferDesc) : null,
                    'bank_info'    => $isOnlinePayment ? $this->getBankInfo() : null,
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

            if ((int) $invoice->ThanhToan === 1) {
                return response()->json([
                    'success' => false,
                    'code'    => 'INVOICE_ALREADY_PAID',
                    'message' => 'Không thể hủy hóa đơn đã thanh toán.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            DB::transaction(function () use ($maHD, $invoice) {
                RoomBooking::where('MaHD', $maHD)->delete();
                TourBooking::where('MaHD', $maHD)->delete();
                // Không xóa hóa đơn để giữ nguyên chuỗi tăng tự động,
                // chỉ đặt trạng thái = 0 (chưa thanh toán / đã hủy).
                $invoice->ThanhTien = null;
                $invoice->TrangThai = 0;
                $invoice->save();
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
            'room'            => $rb->relationLoaded('room') && $rb->room ? $rb->room->toArray() : null,
        ];
    }
}
