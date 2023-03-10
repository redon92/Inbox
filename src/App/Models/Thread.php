<?php

namespace redon92\Inbox\App\Models;

use Illuminate\Database\Eloquent\Model;
use redon92\inbox\App\Models\Participant;
use redon92\inbox\App\Models\Message;

class Thread extends Model
{
    protected $fillable = [
        'subject',
        'creator_type',
        'creator_id'
    ];

    public function threadable()
    {
        return $this->morphTo();
    }

    public function creator(){
        return $this->morphTo('creator');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'thread_id');
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    public function users()
    {
        return $this->morphToMany('App\Models\User', 'participant', 'participants')->withTimestamps();
    }

    public function getLatestMessage(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->messages()->orderByDesc('id');
    }

    public function scopeGetAllLatest($query){
        return $this->orderByDesc('updated_at');
    }

    public function scopeForModel($query, $user)
    {
        return $query->whereHas('participants', function ($query) use ($user) {
            $query->where('participant_id', $user->id)
                ->where('participant_type', get_class($user));
        });
    }

    public function scopeForModelWithNewMessages($query, $user)
    {
        return $query->with('messages')->whereHas('participants', function ($query) use ($user) {
            $query->where('participant_id', $user->id)
                ->where('participant_type', get_class($user));
        });
    }
}
