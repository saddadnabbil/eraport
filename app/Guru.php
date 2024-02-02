<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use SoftDeletes;

    protected $table = 'guru';
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'gelar',
        'nip',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'nuptk',
        'alamat',
        'avatar',
    ];

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
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
        $this->user()->withTrashed()->restore();
        $this->restore();

        $this->update([
            'status' => 1
        ]);

        $this->user->update([
            'status' => 1
        ]);
    }
}
