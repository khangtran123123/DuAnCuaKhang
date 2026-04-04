<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = 'tbl_LoaiPhong';
    protected $primaryKey = 'MaLoai';
    public $timestamps = false;

    protected $fillable = [
        'TenLoai',
        'GiaPhong',
        'SoLuongNguoi',
        'HinhAnh',
        'MoTa',
    ];

    protected $casts = [
        'GiaPhong' => 'decimal:2',
        'SoLuongNguoi' => 'integer',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'MaLoai', 'MaLoai');
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class, 'MaLoai', 'MaLoai');
    }

    public function getHinhAnhAttribute(): ?string
    {
        return $this->rawImageUrl() ?? ($this->DanhSachAnh[0] ?? null);
    }

    public function getDanhSachAnhAttribute(): array
    {
        return $this->imageUrls();
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $gallery = $this->DanhSachAnh;

        $data['GiaPhong'] = is_null($this->GiaPhong) ? null : (float) $this->GiaPhong;
        $data['SoLuongNguoi'] = is_null($this->SoLuongNguoi) ? null : (int) $this->SoLuongNguoi;
        $data['HinhAnh'] = $this->HinhAnh;
        $data['DanhSachAnh'] = $gallery;
        $data['images'] = $gallery;

        return $data;
    }

    private function rawImageUrl(): ?string
    {
        return MediaUrl::roomImage($this->attributes['HinhAnh'] ?? null);
    }

    private function imageUrls(): array
    {
        $urls = [];
        $mainImage = $this->rawImageUrl();

        if ($mainImage !== null) {
            $urls[] = $mainImage;
        }

        $images = $this->relationLoaded('images') ? $this->images : $this->images()->get();

        foreach ($images as $image) {
            if ($image->HinhAnh !== null) {
                $urls[] = $image->HinhAnh;
            }
        }

        return array_values(array_unique(array_filter($urls)));
    }
}
