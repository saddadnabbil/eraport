<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user';
    protected $fillable = [
        'username', 'password', 'role', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sekolah()
    {
        return $this->hasOne('App\Sekolah');
    }

    // Relasi 
    public function admin()
    {
        return $this->hasOne('App\Admin');
    }

    public function guru()
    {
        return $this->hasOne('App\Guru');
    }

    public function siswa()
    {
        return $this->hasOne('App\Siswa');
    }

    public function siswaKeluar()
    {
        return $this->hasOne('App\SiswaKeluar');
    }

    public function karyawan()
    {
        return $this->hasOne('App\Karyawan');
    }

    public function pengumuman()
    {
        return $this->hasMany('App\Pengumuman');
    }


    protected static function boot()
    {
        parent::boot();

        // Listen for the 'restoring' event
        static::restoring(function ($user) {
            // Restore related records
            $user->admin?->restore();
            $user->guru?->restore();
            $user->siswa?->restore();
        });
    }


    /**
     * Trash the User record.
     */
    public function trash()
    {
        $this->delete();
    }

    public function restoreUser()
    {
        $this->restore();

        $this->update([
            'status' => 1
        ]);

        switch ($this->role) {
            case 1:
                $this->admin()->withTrashed()->restore();
                break;
            case 2:
                $this->guru()->withTrashed()->restore();
                break;
            case 3:
                $this->siswa()->withTrashed()->restore();
                $this->siswa()->update([
                    'status' => 1
                ]);
                break;
        }
    }
}
