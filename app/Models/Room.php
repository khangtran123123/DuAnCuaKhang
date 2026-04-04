<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'tbl_Phong';

    protected $primaryKey = 'MaPhong';

    public $timestamps = false;

    protected $fillable = [
        'TenPhong',
        'MaLoai',
    ];

    protected $casts = [
        'MaLoai' => 'integer',
    ];

    public function type()
    {
        return $this->belongsTo(RoomType::class, 'MaLoai', 'MaLoai');
    }

    public function getGiaPhongAttribute(): ?float
    {
        $price = $this->type?->GiaPhong;

        return is_null($price) ? null : (float) $price;
    }

    public function getSoLuongNguoiAttribute(): ?int
    {
        $capacity = $this->type?->SoLuongNguoi;

        return is_null($capacity) ? null : (int) $capacity;
    }

    public function getMoTaAttribute(): ?string
    {
        return $this->type?->MoTa;
    }

    public function getTenLoaiAttribute(): ?string
    {
        return $this->type?->TenLoai;
    }

    public function getHinhAnhAttribute(): ?string
    {
        return $this->type?->HinhAnh;
    }

    public function getDanhSachAnhAttribute(): array
    {
        return $this->type?->DanhSachAnh ?? [];
    }

    public function getVariantAttribute(): string
    {
        return self::inferVariantFromName($this->TenLoai);
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $gallery = $this->DanhSachAnh;

        $data['GiaPhong'] = $this->GiaPhong;
        $data['SoLuongNguoi'] = $this->SoLuongNguoi;
        $data['MoTa'] = $this->MoTa;
        $data['TenLoai'] = $this->TenLoai;
        $data['HinhAnh'] = $this->HinhAnh;
        $data['DanhSachAnh'] = $gallery;
        $data['images'] = $gallery;
        $data['variant'] = $this->Variant;

        return $data;
    }

    public function bookings()
    {
        return $this->hasMany(RoomBooking::class, 'MaPhong');
    }

    public function scopeOfVariant(Builder $query, ?string $variant)
    {
        $normalized = strtolower(trim((string) $variant));

        if ($normalized === 'view') {
            return $query->whereHas('type', function ($typeQuery) {
                $typeQuery->whereRaw('LOWER(TenLoai) LIKE ?', ['%view%']);
            });
        }

        if ($normalized === 'nt') {
            return $query->whereHas('type', function ($typeQuery) {
                $typeQuery->whereRaw('LOWER(TenLoai) NOT LIKE ?', ['%view%']);
            });
        }

        return $query;
    }

    public function scopeAvailableBetween($query, string $from, string $to)
    {
        return $query->whereNotIn('MaPhong', function ($sub) use ($from, $to) {
            $sub->select('MaPhong')
                ->from('tbl_HDPhong')
                ->where('TrangThai', 1)
                ->where(function ($q) use ($from, $to) {
                    $q->whereBetween('NgayNhanPhong', [$from, $to])
                        ->orWhereBetween('NgayTraPhong', [$from, $to])
                        ->orWhere(function ($q2) use ($from, $to) {
                            $q2->where('NgayNhanPhong', '<', $from)
                                ->where('NgayTraPhong', '>', $to);
                        });
                });
        });
    }

    public static function inferVariantFromName(?string $name): string
    {
        $normalized = mb_strtolower(trim((string) $name));

        if ($normalized === '') {
            return 'other';
        }

        return str_contains($normalized, 'view') ? 'view' : 'nt';
    }
}
