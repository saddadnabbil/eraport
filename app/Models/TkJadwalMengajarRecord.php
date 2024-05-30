<?php

namespace App\Models;

use App\Models\TkJadwalMengajarSlot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TkJadwalMengajarRecord extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function jadwalMengajarSlot(): BelongsTo
    {
        return $this->belongsTo(TkJadwalMengajarSlot::class);
    }

    public function pembelajaran(): BelongsTo
    {
        return $this->belongsTo(TkPembelajaran::class);
    }

    public function timeSlots(): HasMany
    {
        return $this->hasMany(TkJadwalMengajarSlot::class, 'tk_jadwal_pelajaran_record_id');
    }
}
