<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'tbl_KhachHang';
    protected $primaryKey = 'MaKH';
    public $timestamps = false;

    protected $fillable = [
        'TenKH',
        'GioiTinh',
        'SDT',
        'MatKhau',
        'TrangThai',
        'Email',
    ];

    protected $hidden = [
        'MatKhau',
    ];

    protected $casts = [
        'GioiTinh' => 'boolean',
        'TrangThai' => 'boolean',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'MaKH');
    }
}
