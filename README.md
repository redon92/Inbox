## Inbox package for Laravel

In order to run the package, you need to add to composer.json:
under require: 
"redon92/inbox" : "dev-main"

and repositories need to be inside like:
"repositories": [
    {
        "url": "https://github.com/redon92/Inbox",
        "type": "git"
    }
],

In order to publish the migrations, you need to run:
php artisan vendor:publish --tag=inbox

You can run the migrations with:
php artisan migrate

After that you can use the methods of the models and also ThreadServices methods in your controller methods, such as for example:

    public function checkThread(){

        $user = Auth::user();

        //        Creating a new thread
        $thread = Thread::create([
            'subject' => Str::random(10),
            'creator_type' => get_class($user),
            'creator_id' => ($user->id),
        ]);
        
        
        //        Creating a new message
        $messageData = [
            'body' => Str::random(10),
            'thread_id' =>  $thread->id,
            'author_type' => get_class($user),
            'author_id' => ($user->id),
        ];
        
        
        //        invoke the ThreadService
        $threadService = new ThreadService();
        
        
        //        add a new message to the thread
        $threadService->addMessage($thread, $messageData, $user);
        
        
        //        get thread creator
        $thread->creator->toArray();
        
        
        //        gets the threads of a model
        $getThreadsOfUser = Thread::forModel($user)->latest('updated_at')->get();
        
        
        //        get all threads ordered by update
        $allLatestThreads = Thread::getAllLatest()->get();
        
        
        //        Creating multiple messages
        $messagesData = [
            [
                'data' => ['body' => Str::random(10)],
                'creator' => $user,
                'body' => 'Lets check it'
            ],
            [
                'data' => ['body' => Str::random(10)],
                'creator' => $user,
                'body' => 'Second message',
            ],
        ];
        
        //        add the new messages to the thread
        $threadService->addMessages($thread, $messagesData, $user);
        
        
        // Adding a participant to a thread
        $threadService->addParticipant($thread, $user);
        
        
        //        Adding multiple participants to a thread
        $participants = [
            $user,
        ];
        $threadService->addParticipants($thread, $participants);
        
        
        //        Marking a thread as read for a participant
        $participants = $user->participant();
        $threadParticipant = $participants->where("thread_id", $thread->id)->first();
        $threadService->markAsRead($thread, $threadParticipant);
        
        
        //        Getting the latest message for a thread
        $latestMessage = $threadService->getLatestMessage($thread);
        
        //        get threads with messages
        $userThreadsWithMessages = Thread::forModelWithNewMessages($user)->latest('updated_at')->get();
        
        //        Checking if a thread is unread for a participant
        $isUnread = $threadService->isUnread($thread, $user);
        
        
        //        Checking if a participant is part of a thread
        $hasParticipant = $threadService->hasParticipant($thread, $threadParticipant);
    }
