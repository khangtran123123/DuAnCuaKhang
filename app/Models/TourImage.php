<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Model;

class TourImage extends Model
{
    protected $table = 'tbl_AnhTour';
    protected $primaryKey = 'MaAT';
    public $timestamps = false;

    protected $fillable = [
        'MaTour',
        'HinhAnh',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'MaTour', 'MaTour');
    }

    public function getHinhAnhAttribute(): ?string
    {
        return MediaUrl::tourImage($this->attributes['HinhAnh'] ?? null);
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['HinhAnh'] = $this->HinhAnh;

        return $data;
    }
}