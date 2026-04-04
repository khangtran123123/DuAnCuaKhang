<?php

namespace App\Models;

use App\Models\DepartureSchedule;
use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $table = 'tbl_TOUR';

    protected $primaryKey = 'MaTour';
    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = false;
    
    protected $fillable = [
        'MaTour',
        'TenTour',
        'GiaTourNguoiLon',
        'GiaTourTreEm',
        'ThoiLuong',
        'DiaDiemKhoiHanh',
        'SoLuongKhachToiDa',
        'HinhAnh',
        'MoTa',
        'LichTrinh',
        'TrangThai',

    ];

    protected $casts = [
        'GiaTourNguoiLon' => 'decimal:2',
        'GiaTourTreEm' => 'decimal:2',
        'ThoiLuong' => 'integer',
        'SoLuongKhachToiDa' => 'integer',
        'TrangThai' => 'boolean',
    ];

    public function departureSchedules()
    {
        return $this->hasMany(DepartureSchedule::class, 'MaTour', 'MaTour');
    }

    public function images()
    {
        return $this->hasMany(TourImage::class, 'MaTour', 'MaTour');
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

        $data['HinhAnh'] = $this->HinhAnh;
        $data['DanhSachAnh'] = $gallery;
        $data['images'] = $gallery;

        return $data;
    }

    private function rawImageUrl(): ?string
    {
        return MediaUrl::tourImage($this->attributes['HinhAnh'] ?? null);
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
