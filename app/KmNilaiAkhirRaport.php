<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KmNilaiAkhirRaport extends Model
{
    use HasFactory;

    protected $table = 'km_nilai_akhir_raports';
    protected $fillable = [
        'pembelajaran_id',
        'anggota_kelas_id',
        'kkm',
        'nilai_sumatif',
        'predikat_sumatif',
        'nilai_formatif',
        'predikat_formatif',
        'nilai_akhir_raport',
        'predikat_akhir_raport',
    ];

    public function pembelajaran()
    {
        return $this->belongsTo('App\Pembelajaran');
    }

    public function anggota_kelas()
    {
        return $this->belongsTo('App\AnggotaKelas');
    }

    public function k13_deskripsi_nilai_siswa()
    {
        return $this->hasOne('App\K13DeskripsiNilaiSiswa');
    }
}
