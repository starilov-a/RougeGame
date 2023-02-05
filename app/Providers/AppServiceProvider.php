<?php

namespace App\Providers;

use App\Models\GameSession,
    App\Models\GameButtons,
    App\Models\Telegram\Telegram;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Model\GameSession', function($app){
            return new GameSession;
        });
        $this->app->bind('App\Http\Controllers\GameController', function($app){
            return new GameController(new GameSession, new GameButtons);
        });
        $this->app->bind('App\Models\Telegram\Telegram', function($app){
            return new Telegram(new Http(), config('bot.apikey'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
