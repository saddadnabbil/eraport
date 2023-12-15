<?php

namespace App;

use App\Kelas;
use App\Siswa;
use App\K13KdMapel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tingkatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tingkatan',
    ];

    public function Kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function Siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function K13KdMapel()
    {
        return $this->hasMany(K13KdMapel::class);
    }
}
