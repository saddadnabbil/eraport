<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSumatif extends Model
{
    use HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'km_nilai_sumatifs';
    protected $guarded = ['id'];

    public function rencana_nilai_sumatif()
    {
        return $this->belongsTo('App\Models\RencanaNilaiSumatif');
    }

    public function anggota_kelas()
    {
        return $this->belongsTo('App\Models\AnggotaKelas');
    }
}
