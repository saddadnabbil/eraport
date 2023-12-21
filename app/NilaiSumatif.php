<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSumatif extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rencana_nilai_sumatif()
    {
        return $this->belongsTo('App\K13RencanaNilaiPengetahuan');
    }

    public function anggota_kelas()
    {
        return $this->belongsTo('App\AnggotaKelas');
    }
}
