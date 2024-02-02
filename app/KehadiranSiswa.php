<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KehadiranSiswa extends Model
{
    use SoftDeletes;
    
    protected $table = 'kehadiran_siswa';
    protected $fillable = [
        'anggota_kelas_id',
        'sakit',
        'izin',
        'tanpa_keterangan'
    ];

    public function anggota_kelas()
    {
        return $this->belongsTo('App\AnggotaKelas');
    }
}
