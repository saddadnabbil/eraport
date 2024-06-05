<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sekolah extends Model
{
    use SoftDeletes;

    protected $table = 'sekolah';
    protected $guarded = ['id'];

    public function tapel()
    {
        return $this->belongsTo(Tapel::class, 'tapel_id');
    }

    public function tingkatans()
    {
        return $this->hasMany(Tingkatan::class);
    }

    public function getTapelIdAttribute()
    {
        return $this->attributes['tapel_id'];
    }
}
