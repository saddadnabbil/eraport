<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaNilaiSumatif extends Model
{
    use HasFactory;

    protected $guarded = 'id';

    public function pembelajaran()
    {
        return $this->belongsTo('App\Pembelajaran');
    }

    public function capaian_pembelajaran()
    {
        return $this->belongsTo('App\CapaianPembelajaran');
    }

    public function nilai_sumatif()
    {
        return $this->hasMany('App\NilaiSumatif', 'capaian_pembelajaran_id');
    }

    // Check if CapaianPembelajaran is used in RencanaNilaiSumatif
    public function isCapaianPembelajaranUsed()
    {
        return $this->nilai_sumatif()->exists();
    }
}
