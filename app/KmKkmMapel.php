<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KmKkmMapel extends Model
{
    use HasFactory;

    protected $table = 'km_kkm_mapels';
    protected $fillable = [
        'mapel_id',
        'kelas_id',
        'kkm',
    ];

    public function mapel()
    {
        return $this->belongsTo('App\Mapel');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Kelas');
    }
}
