<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;
    
    protected $table = 'admin';
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'email',
        'nomor_hp',
        'avatar',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
