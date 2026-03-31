<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    protected $table = 'tbl_HDPhong';
    protected $primaryKey = ['MaHD', 'MaPhong'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'MaHD',
        'MaPhong',
        'NgayNhanPhong',
        'NgayTraPhong',
        'TongTien',
        'TrangThai',
        'ThanhToan',
    ];

    protected $casts = [
        'NgayNhanPhong' => 'date',
        'NgayTraPhong' => 'date',
        'TongTien' => 'decimal:2',
        'TrangThai' => 'boolean',
        'ThanhToan' => 'boolean',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'MaHD');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'MaPhong');
    }

    public function getKeyName(): array
    {
        return $this->primaryKey;
    }

    protected function setKeysForSaveQuery($query): Builder
    {
        foreach ($this->getKeyName() as $keyName) {
            $query->where($keyName, '=', $this->getAttribute($keyName));
        }

        return $query;
    }
}
