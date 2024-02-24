<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tapel extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    
    protected $table = 'tapels';
    protected $fillable = [
        'tahun_pelajaran',
        'semester_id',
        'term_id',
        'status'
    ];

    public function semester()
    {
        return $this->belongsTo('App\Models\Semester');
    }

    public function term()
    {
        return $this->belongsTo('App\Models\Term');
    }

    public function kelas()
    {
        return $this->hasMany('App\Models\Kelas');
    }

    public function mapel()
    {
        return $this->hasMany('App\Models\Mapel');
    }

    public function ekstrakulikuler()
    {
        return $this->hasMany('App\Models\Ekstrakulikuler');
    }

    public function km_tgl_raport()
    {
        return $this->hasOne('App\Models\KmTglRaport');
    }

}
