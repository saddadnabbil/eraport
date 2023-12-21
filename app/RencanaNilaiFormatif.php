<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaNilaiFormatif extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pembelajaran()
    {
        return $this->belongsTo('App\Pembelajaran');
    }

    public function capaian_pembelajaran()
    {
        return $this->belongsTo('App\CapaianPembelajaran');
    }

    public function nilai_formatif()
    {
        return $this->hasMany('App\NilaiFormatif');
    }

    // Check if CapaianPembelajaran is used in RencanaNilaiFormatif
    public function isCapaianPembelajaranUsed()
    {
        return $this->where('capaian_pembelajaran_id', $this->cp->id)->exists();
    }
}
