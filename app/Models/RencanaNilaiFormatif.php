<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaNilaiFormatif extends Model
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

    public function nilai_formatif()
    {
        return $this->hasMany('App\Models\NilaiFormatif');
    }

    public function anggota_kelas()
    {
        return $this->hasMany('App\Models\AnggotaKelas');
    }
    public function isCapaianPembelajaranUsed()
    {
        return $this->where('capaian_pembelajaran_id', $this->cp->id)->exists();
    }
}
