<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P5Subelement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function element()
    {
        return $this->belongsTo(P5Element::class, 'p5_element_id', 'id');
    }

    public function dimensi()
    {
        return $this->belongsTo(P5Element::class, 'p5_dimensi_id', 'id');
    }
}
