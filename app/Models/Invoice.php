<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'tbl_HoaDon';
    protected $primaryKey = 'MaHD';
    public $timestamps = false;

    protected $fillable = [
        'MaKH',
        'NgayTao',
        'ThanhTien',
        'TrangThai',
        'ThanhToan',
    ];

    protected $casts = [
        'NgayTao' => 'date',
        'ThanhTien' => 'decimal:2',
        'TrangThai' => 'boolean',
        'ThanhToan' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'MaKH');
    }

    public function rooms()
    {
        return $this->hasMany(RoomBooking::class, 'MaHD');
    }

    public function roomBookings()
    {
        return $this->hasMany(RoomBooking::class, 'MaHD');
    }

    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class, 'MaHD');
    }

    public function tourBookings()
    {
        return $this->hasMany(TourBooking::class, 'MaHD');
    }
}
