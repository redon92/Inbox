<?php

namespace redon92\Inbox\App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'body',
        'messageable_id',
        'messageable_type',
        'author_type',
        'author_id'
    ];

    public function messageable()
    {
        return $this->morphTo();
    }

    public function thread()
    {
        return $this->morphTo();
    }
}
