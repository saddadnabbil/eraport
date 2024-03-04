<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TkAchivementGrade extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function anggota_kelas()
    {
        return $this->belongsTo(AnggotaKelas::class);
    }

    public function point()
    {
        return $this->belongsTo(TkPoint::class);
    }
}
