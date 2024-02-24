<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KenaikanKelas extends Model
{
    use SoftDeletes;
    protected $table = 'kenaikan_kelas';
    protected $fillable = [
        'anggota_kelas_id',
        'keputusan',
        'kelas_tujuan',
    ];

    public function anggota_kelas()
    {
        return $this->belongsTo('App\Models\AnggotaKelas');
    }
}
