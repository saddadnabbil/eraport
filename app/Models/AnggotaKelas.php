<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnggotaKelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'anggota_kelas';
    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'pendaftaran',
    ];

    public function siswa()
    {
        return $this->belongsTo('App\Models\Siswa');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas');
    }

    public function anggota_ekstrakulikuler()
    {
        return $this->hasMany('App\Models\AnggotaEkstrakulikuler');
    }

    public function kehadiran_siswa()
    {
        return $this->hasOne('App\Models\KehadiranSiswa');
    }

    public function prestasi_siswa()
    {
        return $this->hasMany('App\Models\PrestasiSiswa');
    }

    public function catatan_wali_kelas()
    {
        return $this->hasOne('App\Models\CatatanWaliKelas');
    }

    public function kenaikan_kelas()
    {
        return $this->hasOne('App\Models\KenaikanKelas');
    }

    // Relasi Kurikulum Medeka 
    public function nilai_formatif()
    {
        return $this->hasOne('App\Models\NilaiFormatif');
    }

    public function nilai_sumatif()
    {
        return $this->hasOne('App\Models\NilaiSumatif');
    }

    public function anggota_kelas()
    {
        return $this->hasOne('App\Models\AnggotaKelas');
    }

    public function trash()
    {
        $this->delete();
    }
    public function restoreAnggotaKelas()
    {
        $this->restore();

        $this->siswa->update([
            'kelas_id' => $this->kelas_id,
            'tingkatan_id' => $this->kelas->tingkatan_id,
            'jurusan_id' => $this->kelas->jurusan_id,
        ]);
    }
}
