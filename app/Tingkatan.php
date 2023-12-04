<?php

namespace App;

use App\Kelas;
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
}
