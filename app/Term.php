<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'terms';
    protected $fillable = [
        'term'
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

    public function km_tgl_raport()
    {
        return $this->hasOne('App\KmTglRaport');
    }
}
