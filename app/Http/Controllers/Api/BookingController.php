<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Concerns\HandlesPayment;
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
use Illuminate\Validation\ValidationException;
use Throwable;

class BookingController extends Controller
{
    use HandlesPayment;

    public function book(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'ma_kh' => ['required', 'integer', 'exists:tbl_KhachHang,MaKH'],
                // ma_phong cÃ³ thá»ƒ khÃ´ng truyá»n â€“ há»‡ thá»‘ng sáº½ tá»± tÃ¬m phÃ²ng nhá» nháº¥t trá»‘ng
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

            // Náº¿u FE khÃ´ng gá»­i ma_phong, tá»± Ä‘á»™ng chá»n phÃ²ng cÃ³ MaPhong nhá» nháº¥t Ä‘ang trá»‘ng
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
                ->where('TrangThai', 1)
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
                    'TrangThai' => 1,
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

    public function listByCustomer(Request $request, $maKh): JsonResponse
    {
        try {
            $customer = Customer::findOrFail($maKh);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Khách hàng không tồn tại.'], Response::HTTP_NOT_FOUND);
        }

        $invoices = $customer->invoices()
            ->with(['rooms.room.type', 'tourBookings.departureSchedule.tour'])
            ->where(function ($q) {
                // Chỉ lấy hóa đơn đã thanh toán hoặc còn phòng/tour đang hoạt động.
                // Loại bỏ hóa đơn TrangThai=0 không còn booking (đã bị hủy).
                $q->where('TrangThai', 1)
                  ->orWhereHas('rooms', fn ($r) => $r->where('TrangThai', 1))
                  ->orWhereHas('tourBookings');
            })
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

            if ($invoice->ThanhToan == 1) {
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

                if ($remainingTotal <= 0) {
                    // Không xóa hóa đơn để giữ nguyên chuỗi tăng tự động,
                    // chỉ đặt trạng thái = 0 (đã hủy) bất kể remove_record.
                    $invoice->ThanhTien = 0;
                    $invoice->TrangThai = 0;
                    $invoice->save();

                    return [
                        'invoice' => null,
                        'booking' => null,
                        'invoice_deleted' => false,
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
        $isPaid = (bool) $invoice->ThanhToan;

        return [
            'ma_hd' => (int) $invoice->MaHD,
            'ma_kh' => (int) $invoice->MaKH,
            'ngay_tao' => optional($invoice->NgayTao)->format('Y-m-d') ?? (string) $invoice->NgayTao,
            'thanh_tien' => (float) $invoice->ThanhTien,
            'trang_thai' => (int) ((bool) $invoice->TrangThai),
            'thanh_toan' => $isPaid ? 1 : 0,
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