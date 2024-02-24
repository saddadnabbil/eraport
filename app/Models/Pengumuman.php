<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    
    protected $table = 'pengumuman';
    protected $fillable = [
        'user_id',
        'judul',
        'isi'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
