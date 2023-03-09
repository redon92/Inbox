<?php

namespace redon92\Inbox\App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
//        'body',
        'participant_type',
        'participant_id',
        'latest_read_message',
//        'author_type',
//        'author_id'
    ];

    public function participant()
    {
        return $this->morphTo();
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }
}
