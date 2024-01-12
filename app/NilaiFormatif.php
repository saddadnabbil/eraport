<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiFormatif extends Model
{
    use HasFactory;

    protected $table = 'km_nilai_formatifs';
    protected $guarded = ['id'];

    public function rencana_nilai_formatif()
    {
        return $this->belongsTo('App\RencanaNilaiFormatif');
    }

    public function anggota_kelas()
    {
        return $this->belongsTo('App\AnggotaKelas');
    }
}
