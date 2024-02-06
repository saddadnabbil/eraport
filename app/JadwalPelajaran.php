<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalPelajaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jadwal_pelajarans';
    protected $guarded = ['id'];
}
