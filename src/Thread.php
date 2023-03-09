<?php

namespace redon92\Inbox;

class Thread {
    private $result;

    public function __construct() {
        $this->result = 0;
    }

    public function create(array $items){
        dd($items);
    }

    public function addMessage(int $user) {
        $this->result += $user;

        return $this;
    }

    public function addMessages(int $user) {
        $this->result += $user;

        return $this;
    }

    public function addParticipant(int $user) {
        $this->result -= $user;

        return $this;
    }


    public function addParticipants(int $user) {
        $this->result -= $user;

        return $this;
    }

    public function markAsRead(int $user) {
        $this->result -= $user;

        return $this;
    }

    public function getLatestMessage() {

        return $this;
    }

    public function isUnread(int $user) {
        $this->result -= $user;

        return $this;
    }

    public function hasParticipant(int $user) {
        $this->result -= $user;

        return $this;
    }

    public function clear() {
        $this->result = 0;

        return $this;
    }

    public function getResult() {
        return $this->result;
    }
}
