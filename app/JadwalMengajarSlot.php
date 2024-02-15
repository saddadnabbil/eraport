<?php

namespace App;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalMengajarSlot extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function timetable(): BelongsTo
    {
        return $this->belongsTo(JadwalMengajar::class);
    }
}
