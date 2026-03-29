<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'tbl_Phong';

    protected $primaryKey = 'MaPhong';

    public $timestamps = false;

    // MaPhong is VARCHAR(10)
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'TenPhong',
        'GiaPhong',
        'SoLuongNguoi',
        'HinhAnh',
        'MoTa',
        'MaLoai',
    ];

    protected $casts = [
        'GiaPhong' => 'decimal:2',
        'SoLuongNguoi' => 'integer',
    ];

    public function type()
    {
        return $this->belongsTo(RoomType::class, 'MaLoai');
    }

    // Trả về URL đầy đủ cho HinhAnh thay vì tên file thô
    public function getHinhAnhAttribute(): ?string
    {
        $path = trim((string) ($this->attributes['HinhAnh'] ?? ''));

        if ($path === '') {
            return null;
        }

        // Nếu DB đã lưu URL đầy đủ thì giữ nguyên
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Ưu tiên host/port từ request hiện tại để khớp môi trường mobile/emulator
        $origin = request()?->getSchemeAndHttpHost() ?: rtrim((string) config('app.url'), '/');
        return $origin . '/storage/' . ltrim($path, '/');
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        // Bảo đảm JSON API luôn trả URL ảnh đầy đủ thay vì tên file thô.
        $data['HinhAnh'] = $this->HinhAnh;

        return $data;
    }

    public function bookings()
    {
        return $this->hasMany(RoomBooking::class, 'MaPhong');
    }

    public function scopeAvailableBetween($query, string $from, string $to)
    {
        return $query->whereNotIn('MaPhong', function ($sub) use ($from, $to) {
            $sub->select('MaPhong')
                ->from('tbl_HDPhong')
                ->where('TrangThai', 1)
                ->where(function ($q) use ($from, $to) {
                    $q->whereBetween('NgayNhanPhong', [$from, $to])
                        ->orWhereBetween('NgayTraPhong', [$from, $to])
                        ->orWhere(function ($q2) use ($from, $to) {
                            $q2->where('NgayNhanPhong', '<', $from)
                                ->where('NgayTraPhong', '>', $to);
                        });
                });
        });
    }
}
