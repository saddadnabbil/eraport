<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalPelajaranSlot extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function jadwalPelajaran(): BelongsTo
    {
        return $this->belongsTo(JadwalPelajaran::class);
    }
}
