<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KmDeskripsiNilaiSiswa extends Model
{
    use SoftDeletes;

    protected $table = 'km_deskripsi_nilai_siswas';
    protected $fillable = [
        'pembelajaran_id',
        'term_id',
        'k13_nilai_akhir_raport_id',
        'deskripsi_raport',
    ];

    public function pembelajaran()
    {
        return $this->belongsTo('App\Pembelajaran');
    }

    public function km_nilai_akhir_raport()
    {
        return $this->belongsTo('App\KmNilaiAkhirRaport');
    }
}
