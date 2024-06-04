<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Siswa;
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

    public function capaian_pembelajaran()
    {
        return $this->hasMany(CapaianPembelajaran::class);
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
