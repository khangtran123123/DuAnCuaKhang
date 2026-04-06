<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class RoomController extends Controller
{
    public function homeRooms(Request $request): JsonResponse
    {
        $data = $request->validate([
            'per_type' => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);

        $perType = $data['per_type'] ?? 1;

        $rooms = Room::query()
            ->with('type.images')
            ->orderBy('MaLoai')
            ->orderBy('MaPhong')
            ->get()
            ->groupBy('MaLoai')
            ->flatMap(function ($group) use ($perType) {
                return collect([$this->pickRepresentativeRoom($group)])
                    ->filter()
                    ->take($perType)
                    ->values();
            })
            ->values();

        return $this->roomListResponse($rooms, message: 'Lay danh sach phong trang chu thanh cong.');
    }

    private function extractRoomVariant(Room $room): string
    {
        return $room->Variant;
    }

    private function pickRepresentativeRoom(Collection $rooms): ?Room
    {
        if ($rooms->isEmpty()) {
            return null;
        }

        $variantGroups = $rooms->groupBy(fn(Room $room) => $this->extractRoomVariant($room));

        foreach (['nt', 'view', 'other'] as $variant) {
            $room = $variantGroups->get($variant)?->first();
            if ($room) {
                return $room;
            }
        }

        return $rooms->first();
    }

    public function searchAvailable(Request $request): JsonResponse
    {
        $data = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],

            // FE can send room type by id or by name.
            'ma_loai' => ['nullable', 'integer', 'exists:tbl_LoaiPhong,MaLoai'],
            'room_type' => ['nullable', 'string'],
        ]);

        $availableRooms = $this->buildRoomSearchQuery(
            filters: $data,
            startDate: $data['start_date'],
            endDate: $data['end_date'],
        )->orderBy('MaPhong')->get();

        $hasTypeFilter = isset($data['ma_loai']) || (isset($data['room_type']) && trim($data['room_type']) !== '');

        if ($hasTypeFilter) {
            // Lọc theo loại: trả 1 phòng đại diện cho loại đó, kèm tổng số phòng trống cùng loại.
            $rooms = collect();
            $room = $this->pickRepresentativeRoom($availableRooms);
            if ($room) {
                $room->SoPhongTrong = $availableRooms->count();
                $rooms->push($room);
            }
        } else {
            // Không lọc loại: trả 1 phòng đại diện cho MỖI loại phòng, kèm SoPhongTrong của từng nhóm.
            $rooms = $availableRooms
                ->groupBy('MaLoai')
                ->flatMap(function ($typeGroup) {
                    $room = $this->pickRepresentativeRoom($typeGroup);
                    if ($room) {
                        $room->SoPhongTrong = $typeGroup->count();
                        return collect([$room]);
                    }

                    return collect();
                })
                ->values();
        }

        return $this->roomListResponse(
            $rooms,
            filters: [
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'room_type' => $data['room_type'] ?? null,
                'ma_loai' => $data['ma_loai'] ?? null,
            ],
            message: $rooms->isNotEmpty() ? 'Tìm thấy phòng trống.' : 'Không có phòng trống trong khoảng thời gian này.'
        );
    }

    private function buildRoomSearchQuery(
        array $filters,
        ?string $startDate = null,
        ?string $endDate = null,
    )
    {
        $query = Room::query()->with('type.images');

        if ($startDate && $endDate) {
            $query->availableBetween($startDate, $endDate);
        }

        return $this->applyRoomTypeFilters($query, $filters);
    }

    private function applyRoomTypeFilters($query, array $filters)
    {
        if (isset($filters['ma_loai'])) {
            $query->where('MaLoai', $filters['ma_loai']);
        }

        if (isset($filters['room_type']) && trim($filters['room_type']) !== '') {
            $roomType = trim($filters['room_type']);

            $query->whereHas('type', function ($typeQuery) use ($roomType) {
                $typeQuery->where('TenLoai', $roomType);
            });
        }

        return $query;
    }

    private function roomListResponse($rooms, array $filters = [], string $message = 'Lay danh sach phong thanh cong.'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $rooms,
            'meta' => [
                'total' => $rooms->count(),
                'filters' => array_filter($filters, function ($value) {
                    return !is_null($value) && $value !== '';
                }),
            ],
        ]);
    }

    public function roomTypes(): JsonResponse
    {
        $types = RoomType::query()
            ->orderBy('TenLoai')
            ->pluck('TenLoai')
            ->map(function ($name) {
                return trim((string) $name);
            })
            ->filter()
            ->unique()
            ->values();

        return response()->json($types);
    }


}
