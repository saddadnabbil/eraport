<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CapaianPembelajaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function mapel()
    {
        return $this->belongsTo('App\Models\Mapel');
    }

    public function rencana_nilai_sumatif()
    {
        return $this->hasMany('App\Models\RencanaNilaiSumatif', 'capaian_pembelajaran_id');
    }

    public function rencana_nilai_formatif()
    {
        return $this->hasMany('App\Models\RencanaNilaiFormatif', 'capaian_pembelajaran_id');
    }

    public function tingkatan()
    {
        return $this->belongsTo(Tingkatan::class);
    }
}
