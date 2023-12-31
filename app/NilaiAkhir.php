<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiAkhir extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function anggota_kelas()
    {
        return $this->belongsTo('App\AnggotaKelas');
    }
}
