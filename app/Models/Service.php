<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $table = 'tbl_DichVu';

    protected $primaryKey = 'MaDV';

    public $timestamps = false;
    
    protected $fillable = [
        'TenDV',
        'GiaDV',
        'TrangThai',

    ];

    protected $casts = [
        'GiaDV' => 'decimal:2',
        'TrangThai' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(ServiceBooking::class, 'MaDV');
    }

}
