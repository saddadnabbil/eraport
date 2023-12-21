<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapaianPembelajaran extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function mapel()
    {
        return $this->belongsTo('App\Mapel');
    }

    public function rencana_nilai_sumatif()
    {
        return $this->hasMany('App\RencanaNilaiSumatif', 'capaian_pembelajaran_id');
    }

    public function rencana_nilai_formatif()
    {
        return $this->hasMany('App\RencanaNilaiFormatif', 'capaian_pembelajaran_id');
    }

    public function tingkatan()
    {
        return $this->belongsTo(Tingkatan::class);
    }
}
