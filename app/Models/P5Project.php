<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P5Project extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function p5_tema()
    {
        return $this->belongsTo(P5Tema::class, 'p5_tema_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function nilai_projects()
    {
        return $this->hasMany(P5NilaiProject::class, 'p5_project_id');
    }
}
