<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiFormatif extends Model
{
    use HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'km_nilai_formatifs';
    protected $guarded = ['id'];

    public function rencana_nilai_formatif()
    {
        return $this->belongsTo('App\Models\RencanaNilaiFormatif');
    }

    public function anggota_kelas()
    {
        return $this->belongsTo('App\Models\AnggotaKelas');
    }
}
