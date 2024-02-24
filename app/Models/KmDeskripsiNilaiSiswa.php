<?php

namespace App\Models;

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
        'km_nilai_akhir_raport_id',
        'deskripsi_raport',
    ];

    public function pembelajaran()
    {
        return $this->belongsTo('App\Models\Pembelajaran');
    }

    public function km_nilai_akhir_raport()
    {
        return $this->belongsTo('App\Models\KmNilaiAkhirRaport');
    }
}
