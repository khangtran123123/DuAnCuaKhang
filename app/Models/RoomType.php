<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = 'tbl_LoaiPhong';
    protected $primaryKey = 'MaLoai';
    public $timestamps = false;

    protected $fillable = [
        'TenLoai',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'MaLoai', 'MaLoai');
    }
}
