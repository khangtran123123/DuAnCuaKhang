<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TourGuide;

class DepartureSchedule extends Model
{
    protected $table = 'tbl_LichKhoiHanh';
    protected $primaryKey = 'MaLKH';
    public $timestamps = false;

    protected $fillable = [
        'MaTour',
        'NgayKhoiHanh',
        'NgayKetThuc',
        'SoChoConLai',
        'MaHDV',
        'TaiXe',
        'PhuongTien',
    ];

    protected $casts = [
        'NgayKhoiHanh' => 'date',
        'NgayKetThuc' => 'date',
        'SoChoConLai' => 'integer',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'MaTour', 'MaTour');
    }

    public function guide()
    {
        return $this->belongsTo(TourGuide::class, 'MaHDV');
    }

    public function tourBookings()
    {
        return $this->hasMany(TourBooking::class, 'MaLKH');
    }
}
