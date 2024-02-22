<?php

namespace App;

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
        return $this->belongsTo('App\Siswa');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Kelas');
    }

    public function anggota_ekstrakulikuler()
    {
        return $this->hasMany('App\AnggotaEkstrakulikuler');
    }

    public function kehadiran_siswa()
    {
        return $this->hasOne('App\KehadiranSiswa');
    }

    public function prestasi_siswa()
    {
        return $this->hasMany('App\PrestasiSiswa');
    }

    public function catatan_wali_kelas()
    {
        return $this->hasOne('App\CatatanWaliKelas');
    }

    public function kenaikan_kelas()
    {
        return $this->hasOne('App\KenaikanKelas');
    }

    // Relasi Kurikulum Medeka 
    public function nilai_formatif()
    {
        return $this->hasOne('App\NilaiFormatif');
    }

    public function nilai_sumatif()
    {
        return $this->hasOne('App\NilaiSumatif');
    }

    public function anggota_kelas()
    {
        return $this->hasOne('App\AnggotaKelas');
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
