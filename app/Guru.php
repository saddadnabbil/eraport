<?php

namespace App;

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
        return $this->belongsTo('App\Karyawan')->withTrashed();
    }

    public function kelas()
    {
        return $this->hasMany('App\Kelas');
    }

    public function pembelajaran()
    {
        return $this->hasMany('App\Pembelajaran');
    }

    public function ekstrakulikuler()
    {
        return $this->hasMany('App\Ekstrakulikuler');
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
