<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TkJadwalPelajaranRecord extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function jadwalPelajaranSlot(): BelongsTo
    {
        return $this->belongsTo(TkJadwalPelajaranSlot::class);
    }

    public function pembelajaran(): BelongsTo
    {
        return $this->belongsTo(Pembelajaran::class);
    }

    public function timeSlots(): HasMany
    {
        return $this->hasMany(TkJadwalPelajaranSlot::class, 'tk_jadwal_pelajaran_record_id');
    }
}
