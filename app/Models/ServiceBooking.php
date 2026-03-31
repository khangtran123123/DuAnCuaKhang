<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    protected $table = 'tbl_HDDichVu';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'MaHD',
        'MaDV',
        'SoLuong',
        'TongTien',
        'TrangThai',
        'ThanhToan',
    ];

    protected $casts = [
        'SoLuong' => 'integer',
        'TongTien' => 'decimal:2',
        'TrangThai' => 'boolean',
        'ThanhToan' => 'boolean',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'MaHD');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'MaDV');
    }
}
