<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusKaryawan extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class);
    }
}
