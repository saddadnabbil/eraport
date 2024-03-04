<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TkPoint extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function subtopic()
    {
        return $this->belongsTo(TkSubtopic::class);
    }
}
