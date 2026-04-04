<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    protected $table = 'tbl_AnhPhong';
    protected $primaryKey = 'MaAP';
    public $timestamps = false;

    protected $fillable = [
        'MaLoai',
        'HinhAnh',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'MaLoai', 'MaLoai');
    }

    public function getHinhAnhAttribute(): ?string
    {
        return MediaUrl::roomImage($this->attributes['HinhAnh'] ?? null);
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['HinhAnh'] = $this->HinhAnh;

        return $data;
    }
}