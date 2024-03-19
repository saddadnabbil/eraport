<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TkSubtopic extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function topic()
    {
        return $this->belongsTo(TkTopic::class, 'tk_topic_id');
    }

    public function element()
    {
        return $this->topic->element();
    }
}
