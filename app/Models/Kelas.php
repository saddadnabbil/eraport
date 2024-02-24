<?php

namespace App\Models;

use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kelas';
    protected $fillable = [
        'tapel_id',
        'guru_id',
        'tingkatan_id',
        'jurusan_id',
        'nama_kelas',
    ];

    public function tapel()
    {
        return $this->belongsTo('App\Models\Tapel');
    }

    public function guru()
    {
        return $this->belongsTo('App\Models\Guru')->withTrashed();
    }

    public function siswa()
    {
        return $this->hasMany('App\Models\Siswa');
    }

    public function anggota_kelas()
    {
        return $this->hasMany('App\Models\AnggotaKelas');
    }

    public function pembelajaran()
    {
        return $this->hasMany('App\Models\Pembelajaran');
    }

    // Relasi Tingkatan
    public function tingkatan()
    {
        return $this->belongsTo(Tingkatan::class);
    }

    // Relasi Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
