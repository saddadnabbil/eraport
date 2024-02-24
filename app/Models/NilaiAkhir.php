<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NilaiAkhir extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'km_nilai_akhirs';
    protected $guarded = ['id'];

    public function anggota_kelas()
    {
        return $this->belongsTo('App\Models\AnggotaKelas');
    }
}
