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

             $this->loadMigrationsFrom(__DIR__ . '/../migrations');
         }
     }
}
