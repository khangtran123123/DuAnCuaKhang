<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DepartureSchedule;

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

    // Trả về URL đầy đủ cho HinhAnh để FE hiển thị được Image.network.
    public function getHinhAnhAttribute(): ?string
    {
        $path = trim((string) ($this->attributes['HinhAnh'] ?? ''));

        if ($path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $origin = request()?->getSchemeAndHttpHost() ?: rtrim((string) config('app.url'), '/');
        return $origin . '/storage/' . ltrim($path, '/');
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['HinhAnh'] = $this->HinhAnh;
        return $data;
    }

}
