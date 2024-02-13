<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalPelajaranRecord extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function jadwalPembelajaranSlot(): BelongsTo
    {
        return $this->belongsTo(JadwalPelajaranSlot::class);
    }

    public function pembelajaran(): BelongsTo
    {
        return $this->belongsTo(Pembelajaran::class);
    }

    public function timeSlots(): HasMany
    {
        return $this->hasMany(JadwalPelajaranSlot::class, 'jadwal_pelajaran_record_id');
    }
}
