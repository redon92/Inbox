<?php

namespace redon92\Inbox\App\Services;

use redon92\inbox\App\Contracts\ThreadServiceContract;
use redon92\inbox\App\Models\Thread;
use Illuminate\Support\Arr;

class ThreadService implements ThreadServiceContract
{
    public function addMessage(Thread $thread, array $messageData, $creator): void
    {
        $messageData = Arr::add($messageData, 'author_type', get_class($creator));
        $messageData = Arr::add($messageData, 'author_id', $creator->id);

        $thread->messages()->create($messageData);
    }

    public function addMessages(Thread $thread, array $messagesData, $creator): void
    {
        foreach ($messagesData as $messageData) {
            $this->addMessage($thread, $messageData, $creator);
        }
    }

    public function addParticipant(Thread $thread, $participant): void
    {
        $thread->participants()->create([
            'participant_type' => get_class($participant),
            'participant_id' => $participant->id,
        ]);
    }

    public function addParticipants(Thread $thread, array $participants):void
    {
        foreach ($participants as $participant) {
            $this->addParticipant($thread, $participant);
        }
    }

    public function markAsRead(Thread $thread, $participant):void
    {
        if($this->hasParticipant($thread, $participant)){
            $latestMessage = $thread->messages()->orderByDesc('id')->get()->first();
            $participant->latest_read_message = $latestMessage->id;
            $participant->save();
        }
    }

    public function getLatestMessage(Thread $thread): mixed
    {
        return $thread->getLatestMessage()->get()->first();
    }

    public function hasParticipant(Thread $thread, $participant): bool
    {
        if ($participant->thread_id === $thread->id){
            return true;
        }
        return false;
    }

    public function isUnread(Thread $thread, $user): bool
    {
        $latestMessage = $thread->getLatestMessage()->first();

        // Check if the latest message exists and the user is a participant in the thread
        if (!$latestMessage || !$this->hasParticipant($thread, $user)) {
            return false;
        }

        // Check if the user's latest read message ID is less than the ID of the latest message
        $participant = $thread->participants()->where([
            'participant_id' => $user->id,
            'participant_type' => get_class($user)
        ])->first();

        if ($participant && $participant->latest_read_message < $latestMessage->id) {
            return true;
        }

        return false;
    }
}
