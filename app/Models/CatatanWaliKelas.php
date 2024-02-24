<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatatanWaliKelas extends Model
{
    use SoftDeletes;
    protected $table = 'catatan_wali_kelas';
    protected $fillable = [
        'anggota_kelas_id',
        'catatan',
    ];

    public function anggota_kelas()
    {
        return $this->belongsTo('App\Models\AnggotaKelas');
    }
}
