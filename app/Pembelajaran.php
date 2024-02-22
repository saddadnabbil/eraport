<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelajaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pembelajaran';
    protected $fillable = [
        'kelas_id',
        'mapel_id',
        'guru_id',
        'status'
    ];

    public function kelas()
    {
        return $this->belongsTo('App\Kelas');
    }

    public function mapel()
    {
        return $this->belongsTo('App\Mapel');
    }

    public function guru()
    {
        return $this->belongsTo('App\Guru')->withTrashed();
    }

    public function tingkatan()
    {
        return $this->belongsTo('App\Tingkatan');
    }

    // Relasi Kurikulum Merdeka
    public function capaian_pembelajaran()
    {
        return $this->hasMany('App\CapaianPembelajaran');
    }

    public function rencana_nilai_formatif()
    {
        return $this->hasMany('App\RencanaNilaiFormatif');
    }

    public function rencana_nilai_sumatif()
    {
        return $this->hasMany('App\RencanaNilaiSumatif');
    }

    public function silabus()
    {
        return $this->hasMany('App\Silabus');
    }
}
