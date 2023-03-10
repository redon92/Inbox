<?php declare(strict_types=1);

namespace redon92\Inbox\Providers;

use Illuminate\Support\ServiceProvider;
use redon92\Inbox\Facades\Thread;

final class InboxServiceProvider extends ServiceProvider
{/**
      * Register application services.
      *
      * @return void
      */
     public function register()
     {
         //
//         $this->app->bind('thread', function ($app) {
//             return new Thread();
//         });
     }

     /**
      * Bootstrap application services.
      *
      * @return void
      */
     public function boot()
     {
         //
         if ($this->app->runningInConsole()) {
             // publish config file
             // register artisan command

             $this->publishes([
                 __DIR__ . '\../../database/migrations/create_threads_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_threads_table.php'),
                 __DIR__ . '\../../database/migrations/create_messages_table.php' => database_path('migrations/' . date('Y_m_d_His', time()+1*60) . '_create_messages_table.php'),
                 __DIR__ . '\../../database/migrations/create_participants_table.php' => database_path('migrations/' . date('Y_m_d_His', time()+2*60) . '_create_participants_table.php'),
             ], ['migrations', 'inbox']);
         }
     }
}
