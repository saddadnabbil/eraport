<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KmTglRaport extends Model
{
    use HasFactory;

    protected $table = 'km_tgl_raports';
    protected $fillable = [
        'tapel_id',
        'tempat_penerbitan',
        'tanggal_pembagian',
    ];
    protected $dates = ['tanggal_pembagian'];

    public function tapel()
    {
        return $this->belongsTo('App\Tapel');
    }
}
