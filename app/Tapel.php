<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tapel extends Model
{
    protected $table = 'tapels';
    protected $fillable = [
        'tahun_pelajaran',
        'semester_id',
        'term_id'
    ];

    public function semester()
    {
        return $this->belongsTo('App\Semester');
    }

    public function term()
    {
        return $this->belongsTo('App\Term');
    }

    public function kelas()
    {
        return $this->hasMany('App\Kelas');
    }

    public function mapel()
    {
        return $this->hasMany('App\Mapel');
    }

    public function ekstrakulikuler()
    {
        return $this->hasMany('App\Ekstrakulikuler');
    }

    public function km_tgl_raport()
    {
        return $this->hasOne('App\KmTglRaport');
    }

    // Relasi K13
    public function k13_tgl_raport()
    {
        return $this->hasOne('App\K13TglRaport');
    }

    // Relasi KTSP
    public function ktsp_tgl_raport()
    {
        return $this->hasOne('App\KtspTglRaport');
    }
}
