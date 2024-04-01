<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TkEvent extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function tapel()
    {
        return $this->belongsTo(Tapel::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
