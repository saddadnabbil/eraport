<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrestasiSiswa extends Model
{
    protected $table = 'prestasi_siswa';
    protected $fillable = [
        'anggota_kelas_id',
        'nama_prestasi',
        'jenis_prestasi',
        'tingkat_prestasi',
        'deskripsi'
    ];

    public function anggota_kelas()
    {
        return $this->belongsTo('App\AnggotaKelas');
    }
}
