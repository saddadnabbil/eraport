<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TkPembelajaran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function topic()
    {
        return $this->belongsTo(TkTopic::class, 'tk_topic_id');
    }

    public function guru()
    {
        return $this->belongsTo('App\Models\Guru')->withTrashed();
    }

    public function tingkatan()
    {
        return $this->belongsTo('App\Models\Tingkatan');
    }
}
