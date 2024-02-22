<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'semesters';
    protected $fillable = [
        'semester'
    ];

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

    public function tapel()
    {
        return $this->belongsTo('App\Tapel');
    }

    public function km_tgl_raport()
    {
        return $this->hasOne('App\KmTglRaport');
    }
}
