<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P5Element extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function dimensi()
    {
        return $this->belongsTo(P5Dimensi::class, 'p5_dimensi_id', 'id');
    }
}
