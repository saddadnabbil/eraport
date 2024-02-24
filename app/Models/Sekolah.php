<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    
    protected $table = 'sekolah';
    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'nss',
        'kode_pos',
        'nomor_telpon',
        'alamat',
        'website',
        'email',
        'logo',
        'kepala_sekolah',
        'nip_kepala_sekolah',
        'tapel_id',
    ];

    public function tapel()
    {
        return $this->belongsTo(Tapel::class, 'tapel_id');
    }

    // public function semester()
    // {
    //     return $this->belongsTo(Semester::class, 'semester_id');
    // }

    // public function term()
    // {
    //     return $this->belongsTo(Term::class, 'term_id');
    // }

    // Contoh metode untuk mendapatkan tapel_id
    public function getTapelIdAttribute()
    {
        return $this->attributes['tapel_id'];
    }
}
