<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'siswa';
    protected $guarded = ['id'];
    protected $dates = ['tanggal_lahir'];

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function kelas()
    {
        return $this->belongsTo('App\Kelas');
    }

    public function tingkatan()
    {
        return $this->belongsTo('App\Tingkat');
    }

    public function anggota_kelas()
    {
        return $this->hasMany('App\AnggotaKelas')->withTrashed();
    }

    public function siswa_keluar()
    {
        return $this->hasOne('App\SiswaKeluar');
    }

    protected static function boot()
    {
        parent::boot();

        static::restoring(function ($siswa) {
            $siswa->anggota_kelas()->withTrashed()->restore();
        });
    }

    public function trash()
    {
        $this->delete();
    }

    public function restoreSiswa()
    {
        $this->user()->withTrashed()->restore();
        $this->restore();
        $this->anggota_kelas()->withTrashed()->restore();

        $this->update([
            'status' => 1
        ]);

        $this->user->update([
            'status' => 1
        ]);
    }
}
