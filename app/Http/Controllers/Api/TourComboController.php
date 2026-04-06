<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Tour;
use App\Models\DepartureSchedule;
use App\Models\Room;
use Carbon\Carbon;

class TourComboController extends BaseController
{
    /**
     * Lấy danh sách tour (hiển thị ở trang chủ)
     */
    public function index()
    {
        try {
            $tours = Tour::with('images')->where('TrangThai', 1)->get();
            return response()->json([
                'success' => true,
                'data' => $tours
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách tour: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy chi tiết tour + lịch khởi hành + phòng trống
     * GET /api/tours/{maTour}/details?departureDate={date}
     * departureDate format: YYYY-MM-DD
     */
    public function getTourWithRooms($maTour)
    {
        try {
            $today = Carbon::today()->toDateString();

            // Tìm tour
            $tour = Tour::where('MaTour', $maTour)
                ->with('images')
                ->where('TrangThai', 1)
                ->firstOrFail();

            // Lấy tất cả lịch khởi hành của tour này
            $departureSchedules = DepartureSchedule::where('MaTour', $maTour)
                ->whereDate('NgayKhoiHanh', '>=', $today)
                ->where('SoChoConLai', '>', 0)
                ->orderBy('NgayKhoiHanh', 'asc')
                ->get();

            // Nếu còn chọn ngày khởi hành, lấy phòng trống cho ngày đó
            $availableRooms = [];
            $selectedSchedule = null;

            if (request()->has('departureScheduleId')) {
                $scheduleId = request()->input('departureScheduleId');
                $selectedSchedule = DepartureSchedule::whereKey($scheduleId)
                    ->whereDate('NgayKhoiHanh', '>=', $today)
                    ->where('SoChoConLai', '>', 0)
                    ->first();

                if ($selectedSchedule) {
                    $startDate = Carbon::parse((string) $selectedSchedule->NgayKhoiHanh)->format('Y-m-d');
                    $endDate = Carbon::parse((string) $selectedSchedule->NgayKetThuc)->format('Y-m-d');

                    // Lấy phòng trống trong khoảng thời gian này
                    $availableRooms = Room::availableBetween($startDate, $endDate)
                        ->with('type.images')
                        ->get();
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'tour' => $tour,
                    'departureSchedules' => $departureSchedules,
                    'selectedSchedule' => $selectedSchedule,
                    'availableRooms' => $availableRooms
                ]
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tour không tìm thấy'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy phòng trống cho một lịch khởi hành cụ thể
     * GET /api/tours/departure/{departureScheduleId}/available-rooms
     */
    public function getAvailableRoomsForSchedule($departureScheduleId)
    {
        try {
            $schedule = DepartureSchedule::whereKey($departureScheduleId)
                ->whereDate('NgayKhoiHanh', '>=', Carbon::today()->toDateString())
                ->where('SoChoConLai', '>', 0)
                ->firstOrFail();

            $startDate = Carbon::parse((string) $schedule->NgayKhoiHanh)->format('Y-m-d');
            $endDate = Carbon::parse((string) $schedule->NgayKetThuc)->format('Y-m-d');

            // Lấy phòng trống trong khoảng thời gian này
            $availableRooms = Room::availableBetween($startDate, $endDate)
                ->with('type.images')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'checkInDate' => $startDate,
                    'checkOutDate' => $endDate,
                    'rooms' => $availableRooms
                ]
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lịch khởi hành không tìm thấy'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}
