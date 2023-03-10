<?php

namespace redon92\Inbox\App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use redon92\Inbox\App\Models\Thread;

interface ThreadServiceContract
{
    public function addMessage(Thread $thread, array $messageData, $creator): void;
    public function addMessages(Thread $thread, array $messagesData, $creator): void;
    public function addParticipant(Thread $thread, $participant): void;
    public function addParticipants(Thread $thread, array $participants): void;
    public function markAsRead(Thread $thread, $participant): void;
    public function getLatestMessage(Thread $thread): mixed;
    public function hasParticipant(Thread $thread, $participant): bool;
    public function isUnread(Thread $thread, $participant): bool;
}
