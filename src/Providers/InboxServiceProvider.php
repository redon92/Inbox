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
         $this->app->bind('thread', function ($app) {
             return new Thread();
         });
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

               if (! class_exists('CreateInboxTables')) {
                 $this->publishes([
                   __DIR__ . '/../database/migrations/create_inbox_tables.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_inbox_tables.php'),
                   // you can add any number of migrations here
                 ], 'migrations');
               }
             }
     }
}
