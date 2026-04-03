<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    public function homeRooms(Request $request): JsonResponse
    {
        $data = $request->validate([
            'per_type' => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);

        $perType = $data['per_type'] ?? 2;

        $rooms = Room::query()
            ->with('type')
            ->orderBy('MaLoai')
            ->orderBy('MaPhong')
            ->get()
            ->groupBy('MaLoai')
            ->flatMap(function ($group) use ($perType) {
                $variantGroups = $group->groupBy(fn(Room $room) => $this->extractRoomVariant($room));

                $selected = collect();

                foreach (['nt', 'view'] as $variant) {
                    if ($selected->count() >= $perType) break;
                    $room = $variantGroups->get($variant)?->first();
                    if ($room) $selected->push($room);
                }

                if ($selected->count() < $perType) {
                    $remaining = $group
                        ->reject(fn(Room $room) => $selected->contains('MaPhong', $room->MaPhong))
                        ->take($perType - $selected->count());
                    $selected = $selected->merge($remaining);
                }

                return $selected;
            })
            ->values();

        return $this->roomListResponse($rooms, message: 'Lay danh sach phong trang chu thanh cong.');
    }

    private function extractRoomVariant(Room $room): string
    {
        $name = mb_strtolower(trim((string) $room->TenPhong));

        if (str_contains($name, 'view')) {
            return 'view';
        }

        if (str_contains($name, 'nt')) {
            return 'nt';
        }

        return 'other';
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
            // Lọc theo loại: trả 1 NT + 1 View cho loại đó, kèm SoPhongTrong.
            $rooms = collect();
            $variantGroups = $availableRooms->groupBy(fn(Room $room) => $this->extractRoomVariant($room));
            foreach (['nt', 'view'] as $variant) {
                $group = $variantGroups->get($variant);
                $room  = $group?->first();
                if ($room) {
                    $room->SoPhongTrong = $group->count();
                    $rooms->push($room);
                }
            }
        } else {
            // Không lọc loại: trả 1 NT + 1 View cho MỖI loại phòng, kèm SoPhongTrong của từng nhóm.
            $rooms = $availableRooms
                ->groupBy('MaLoai')
                ->flatMap(function ($typeGroup) {
                    $variantGroups = $typeGroup->groupBy(fn(Room $room) => $this->extractRoomVariant($room));
                    $selected = collect();
                    foreach (['nt', 'view'] as $variant) {
                        $group = $variantGroups->get($variant);
                        $room  = $group?->first();
                        if ($room) {
                            $room->SoPhongTrong = $group->count();
                            $selected->push($room);
                        }
                    }
                    return $selected;
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
        $query = Room::query()->with('type');

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
