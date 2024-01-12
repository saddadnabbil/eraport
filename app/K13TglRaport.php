<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class K13TglRaport extends Model
{
    protected $table = 'k13_tgl_raport';
    protected $fillable = [
        'tapel_id',
        'semester_id',
        'tempat_penerbitan',
        'tanggal_pembagian',
    ];
    protected $dates = ['tanggal_pembagian'];

    public function tapel()
    {
        return $this->belongsTo('App\Tapel');
    }

    public function semester()
    {
        return $this->belongsTo('App\Semester');
    }
}
