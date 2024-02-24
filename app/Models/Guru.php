<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guru';
    protected $fillable = [
        'karyawan_id'
    ];

    public function karyawan()
    {
        return $this->belongsTo('App\Models\Karyawan')->withTrashed();
    }

    public function kelas()
    {
        return $this->hasMany('App\Models\Kelas');
    }

    public function pembelajaran()
    {
        return $this->hasMany('App\Models\Pembelajaran');
    }

    public function ekstrakulikuler()
    {
        return $this->hasMany('App\Models\Ekstrakulikuler');
    }

    /**
     * Trash the Guru record.
     */
    public function trash()
    {
        $this->delete();
    }
    public function restoreGuru()
    {
        $this->karyawan()->withTrashed()->restore();
        $this->restore();

        $this->karyawan->update([
            'status' => 1
        ]);
    }
}
