<?php

namespace App\Models;

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

    public function tapel()
    {
        return $this->belongsTo('App\Models\Tapel');
    }

    public function km_tgl_raport()
    {
        return $this->hasOne('App\Models\KmTglRaport');
    }
}
