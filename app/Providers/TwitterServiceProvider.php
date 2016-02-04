<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Twitter\Twitter;

class TwitterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Twitter::class, function($app) {
            return new Twitter(
                config('xan.twitter_api.consumer_key'),
                config('xan.twitter_api.consumer_secret'),
                config('xan.twitter_api.access_token'),
                config('xan.twitter_api.access_token_secret')
            );
        });
    }
}
