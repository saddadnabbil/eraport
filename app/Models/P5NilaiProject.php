<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P5NilaiProject extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function anggota_kelas()
    {
        return $this->belongsTo(AnggotaKelas::class, 'anggota_kelas_id');
    }

    public function project()
    {
        return $this->belongsTo(P5Project::class, 'p5_project_id');
    }
}
