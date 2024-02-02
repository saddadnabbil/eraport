<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mapel extends Model
{
    use SoftDeletes;

    protected $table = 'mapel';
    protected $fillable = [
        'tapel_id',
        'nama_mapel',
        'nama_mapel_indonesian',
        'ringkasan_mapel'
    ];

    public function tapel()
    {
        return $this->belongsTo('App\Tapel');
    }

    public function pembelajaran()
    {
        return $this->hasMany('App\Pembelajaran');
    }

    public function km_mapping_mapel()
    {
        return $this->hasOne('App\KmMappingMapel');
    }

    // Relasi K13 
    public function k13_mapping_mapel()
    {
        return $this->hasOne('App\K13MappingMapel');
    }

    public function k13_kkm_mapel()
    {
        return $this->hasOne('App\KmKkmMapel');
    }

    public function k13_kd_mapel()
    {
        return $this->hasMany('App\K13KdMapel');
    }


    // Relasi KTSP
    public function ktsp_mapping_mapel()
    {
        return $this->hasOne('App\KtspMappingMapel');
    }
    public function ktsp_kkm_mapel()
    {
        return $this->hasOne('App\KtspKkmMapel');
    }

    // Relasi Kurikulum Merdeka
    // Relasi CapaianPembelajaran
    public function capaian_pembelajaran()
    {
        return $this->hasMany('App\CapaianPembelajaran');
    }
    // End Relasi Kurikulum Merdeka
}
