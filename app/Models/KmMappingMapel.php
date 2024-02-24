<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KmMappingMapel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'km_mapping_mapels';
    protected $fillable = [
        'mapel_id',
        'kelompok',
        'nomor_urut',
    ];

    public function mapel()
    {
        return $this->belongsTo('App\Models\Mapel');
    }
}
