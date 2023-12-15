<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    
    protected $table = 'siswa';

    protected $guarded = ['id'];

    protected $dates = ['tanggal_lahir'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Kelas');
    }

    public function tingakatan()
    {
        return $this->belongsTo('App\Tingkat');
    }

    public function anggota_kelas()
    {
        return $this->hasMany('App\AnggotaKelas');
    }

    public function siswa_keluar()
    {
        return $this->hasOne('App\SiswaKeluar');
    }
}
