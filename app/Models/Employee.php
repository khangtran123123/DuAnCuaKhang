<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Position;

class Employee extends Model
{
    protected $table = 'tbl_NhanVien';
    protected $primaryKey = 'MaNV';
    public $timestamps = false;

    protected $fillable = [
        'TenNV',
        'GioiTinh',
        'NgaySinh',
        'DiaChi',
        'SDT',
        'TenTK',
        'MatKhau',
        'Email',
        'TrangThai',
        'MaCV',
    ];

    protected $hidden = [
        'MatKhau',
    ];

    protected $casts = [
        'GioiTinh' => 'boolean',
        'NgaySinh' => 'date',
        'TrangThai' => 'boolean',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'MaCV');
    }
}
