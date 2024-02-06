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

    public function guru()
    {
        return $this->belongsTo('App\Guru')->withTrashed();
    }


    /**
     * Trash the Karyawan record.
     */
    public function trash()
    {
        $this->delete();
    }

    public function restoreKaryawan()
    {
        $this->user()->withTrashed()->restore();

        $this->restore();

        $this->update([
            'status' => 1
        ]);

        $this->user->update([
            'status' => 1
        ]);
    }
}
