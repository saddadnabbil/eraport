<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KmKkmMapel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'km_kkm_mapels';
    protected $fillable = [
        'mapel_id',
        'kelas_id',
        'kkm',
    ];

    public function mapel()
    {
        return $this->belongsTo('App\Models\Mapel', 'mapel_id');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas');
    }
}
