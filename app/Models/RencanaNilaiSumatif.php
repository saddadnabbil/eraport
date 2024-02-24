<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaNilaiSumatif extends Model
{
    use HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $guarded = ['id'];

    public function pembelajaran()
    {
        return $this->belongsTo('App\Models\Pembelajaran');
    }

    public function capaian_pembelajaran()
    {
        return $this->belongsTo('App\Models\CapaianPembelajaran');
    }

    public function nilai_sumatif()
    {
        return $this->hasMany('App\Models\NilaiSumatif');
    }

    public function anggota_kelas()
    {
        return $this->hasMany('App\Models\AnggotaKelas');
    }

    public function isCapaianPembelajaranUsed()
    {
        return $this->nilai_sumatif()->exists();
    }
}
