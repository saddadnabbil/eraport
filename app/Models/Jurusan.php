<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurusan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama_jurusan',
    ];

    public function Kelas()
    {
        return $this->hasMany(Kelas::class);
    }
}
