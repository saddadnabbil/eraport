<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KmMappingMapel extends Model
{
    use HasFactory;

    protected $table = 'km_mapping_mapels';
    protected $fillable = [
        'mapel_id',
        'kelompok',
        'nomor_urut',
    ];

    public function mapel()
    {
        return $this->belongsTo('App\Mapel');
    }
}
