<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KmNilaiAkhirRaport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'km_nilai_akhir_raports';
    protected $fillable = [
        'pembelajaran_id',
        'anggota_kelas_id',
        'semester_id',
        'term_id',
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
        return $this->belongsTo('App\Models\Pembelajaran');
    }

    public function anggota_kelas()
    {
        return $this->belongsTo('App\Models\AnggotaKelas');
    }

    public function km_deskripsi_nilai_siswa()
    {
        return $this->hasOne('App\Models\KmDeskripsiNilaiSiswa');
    }
}
