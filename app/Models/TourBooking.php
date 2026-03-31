<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DepartureSchedule;

class TourBooking extends Model
{
    protected $table = 'tbl_HDTOUR';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'MaHD',
        'MaLKH',
        'SoNguoiLon',
        'SoTreEm',
        'TongTien',
        'TrangThai',
        'ThanhToan',
    ];

    protected $casts = [
        'SoNguoiLon' => 'integer',
        'SoTreEm' => 'integer',
        'TongTien' => 'decimal:2',
        'TrangThai' => 'boolean',
        'ThanhToan' => 'boolean',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'MaHD');
    }

    public function departureSchedule()
    {
        return $this->belongsTo(DepartureSchedule::class, 'MaLKH');
    }
}
