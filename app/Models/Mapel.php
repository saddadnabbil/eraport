<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mapel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mapel';
    protected $fillable = [
        'tapel_id',
        'nama_mapel',
        'nama_mapel_indonesian',
        'ringkasan_mapel',
        'color'
    ];

    public function tapel()
    {
        return $this->belongsTo('App\Models\Tapel');
    }

    public function pembelajaran()
    {
        return $this->hasMany('App\Models\Pembelajaran');
    }

    public function km_mapping_mapel()
    {
        return $this->hasOne('App\Models\KmMappingMapel');
    }

    // Relasi Kurikulum Merdeka
    // Relasi CapaianPembelajaran
    public function capaian_pembelajaran()
    {
        return $this->hasMany('App\Models\CapaianPembelajaran');
    }
    // End Relasi Kurikulum Merdeka
}
