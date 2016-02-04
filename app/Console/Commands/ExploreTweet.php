<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TwitterAPIExchange;

class ExploreTweet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xan:explore-tweet {tweet_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Explores a tweet.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tweetId = $this->argument('tweet_id');

        $twitter = new TwitterAPIExchange(array(
            'consumer_key'                 => config('xan.twitter_api.consumer_key'),
            'consumer_secret'              => config('xan.twitter_api.consumer_secret'),
            'oauth_access_token'           => config('xan.twitter_api.access_token'),
            'oauth_access_token_secret'    => config('xan.twitter_api.access_token_secret')
        ));

        $tweet = json_decode($twitter->setGetField('?id='.$tweetId)
                        ->buildOauth("https://api.twitter.com/1.1/statuses/show.json", "GET")
                        ->performRequest(), true);

        print_r($tweet);
    }
}
