<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalMengajar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jadwal_mengajars';
    protected $guarded = ['id'];


    public function tapel(): BelongsTo
    {
        return $this->belongsTo(Tapel::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function timeSlots(): HasMany
    {
        return $this->hasMany(JadwalMengajarSlot::class, 'jadwal_mengajar_id');
    }
}
