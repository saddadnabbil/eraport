<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TkPoint extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function subtopic()
    {
        return $this->belongsTo(TkSubtopic::class, 'tk_subtopic_id');
    }

    public function topic()
    {
        return $this->belongsTo(TkTopic::class, 'tk_topic_id');
    }

    public function element()
    {
        return $this->belongsTo(tk . element::class, 'tk_element_id');
    }
}
