<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourGuide extends Model
{
    protected $table = 'tbl_HuongDanVien';
    protected $primaryKey = 'MaHDV';
    public $timestamps = false;

    protected $fillable = [
        'TenHDV',
        'NgaySinh',
        'DiaChi',
        'SDT',
        'TrangThai',
    ];

    protected $casts = [
        'NgaySinh' => 'date',
        'TrangThai' => 'boolean',
    ];

    public function departureSchedules()
    {
        return $this->hasMany(DepartureSchedule::class, 'MaHDV');
    }
}
