<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnggotaEkstrakulikuler extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = 'anggota_ekstrakulikuler';
    protected $fillable = [
        'anggota_kelas_id',
        'ekstrakulikuler_id',
    ];

    public function anggota_kelas()
    {
        return $this->belongsTo('App\Models\AnggotaKelas');
    }

    public function ekstrakulikuler()
    {
        return $this->belongsTo('App\Models\Ekstrakulikuler');
    }

    public function nilai_ekstrakulikuler()
    {
        return $this->hasOne('App\Models\NilaiEkstrakulikuler');
    }
}
