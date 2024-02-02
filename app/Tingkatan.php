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
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'nama_tingkatan',
        'term_id',
        'semester_id'
    ];

    public function Kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function Siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function K13KdMapel()
    {
        return $this->hasMany(K13KdMapel::class);
    }

    public function capaian_pembelajaran()
    {
        return $this->hasMany(CapaianPembelajaran::class);
    }
}
