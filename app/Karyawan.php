<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function statusKaryawan()
    {
        return $this->belongsTo(StatusKaryawan::class);
    }

    public function unitKaryawan()
    {
        return $this->belongsTo(UnitKaryawan::class);
    }

    public function positionKaryawan()
    {
        return $this->belongsTo(PositionKaryawan::class);
    }

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
}
