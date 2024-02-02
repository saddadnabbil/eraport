<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ekstrakulikuler extends Model
{
    use SoftDeletes;
    protected $table = 'ekstrakulikuler';
    protected $fillable = [
        'tapel_id',
        'pembina_id',
        'nama_ekstrakulikuler'
    ];

    public function tapel()
    {
        return $this->belongsTo('App\Tapel');
    }

    public function pembina()
    {
        return $this->belongsTo('App\Guru');
    }

    public function anggota_ekstrakulikuler()
    {
        return $this->hasMany('App\AnggotaEkstrakulikuler');
    }

    public function nilai_ekstrakulikuler()
    {
        return $this->hasMany('App\NilaiEkstrakulikuler');
    }
}
