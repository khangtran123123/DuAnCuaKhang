<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'tbl_ChucVu';
    protected $primaryKey = 'MaCV';
    public $timestamps = false;

    protected $fillable = [
        'TenCV',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'MaCV');
    }
}
