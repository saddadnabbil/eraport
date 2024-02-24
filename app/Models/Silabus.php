<?php

namespace App\Models;

use App\Models\Pembelajaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Silabus extends Model
{
    use HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'silabuses';
    protected $fillable = ['pembelajaran_id', 'kelas_id', 'mapel_id', 'k_tigabelas', 'cambridge', 'edexcel', 'book_indo_siswa', 'book_english_siswa', 'book_indo_guru', 'book_english_guru'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class)->withDefault();
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class)->withDefault();
    }

    public function pembelajaran()
    {
        return $this->belongsTo(Pembelajaran::class)->withDefault();
    }
}
