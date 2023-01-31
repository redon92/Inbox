<?php

namespace redon92\Inbox\Facades;

use Illuminate\Support\Facades\Facade;

class Thread extends Facade {
    protected static function getFacadeAccessor(): string
    {
        return 'thread';
    }
}
