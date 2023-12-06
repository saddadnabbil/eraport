<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Silabus extends Model
{
    use HasFactory;

    protected $table = 'silabuses';
    protected $fillable = ['kelas_id', 'mapel_id', 'k_tigabelas', 'cambridge', 'edexcel', 'book_indo_siswa', 'book_english_siswa', 'book_indo_guru', 'book_english_guru'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class)->withDefault();
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class)->withDefault();
    }
}
