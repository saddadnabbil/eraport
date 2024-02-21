<?php

namespace App;

use App\JadwalMengajarSlot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalMengajarRecord extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function jadwalMengajarSlot(): BelongsTo
    {
        return $this->belongsTo(JadwalMengajarSlot::class);
    }

    public function pembelajaran(): BelongsTo
    {
        return $this->belongsTo(Pembelajaran::class);
    }

    public function timeSlots(): HasMany
    {
        return $this->hasMany(JadwalMengajarSlot::class, 'jadwal_mengajar_record_id');
    }
}
