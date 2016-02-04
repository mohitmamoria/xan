<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TwitterAPIExchange;

class SearchTwitter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xan:search-twitter {from_handle} {to_handle} {--since_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Searches Twitter for tweets.';

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
        $twitter = new TwitterAPIExchange(array(
            'consumer_key'                 => config('xan.twitter_api.consumer_key'),
            'consumer_secret'              => config('xan.twitter_api.consumer_secret'),
            'oauth_access_token'           => config('xan.twitter_api.access_token'),
            'oauth_access_token_secret'    => config('xan.twitter_api.access_token_secret')
        ));

        $tweet = json_decode($twitter->setGetField($this->makeGetField())
                        ->buildOauth("https://api.twitter.com/1.1/search/tweets.json", "GET")
                        ->performRequest(), true);

        print_r($tweet);
    }

    protected function makeGetField()
    {
        $sinceId = $this->option('since_id');

        $query = sprintf('?q=%s&result=%s&count=%d', $this->makeSearchQuery(), 'recent', 100);

        if($sinceId)
        {
            $query .= sprintf('&since_id=%d', $sinceId);
        }

        $this->info('Search Query: ' . $query);

        return $query;
    }

    protected function makeSearchQuery()
    {
        $fromHandle = $this->argument('from_handle');
        $toHandle = $this->argument('to_handle');

        return sprintf(
            'from:%s to:%s',
            $fromHandle,
            $toHandle,
            $toHandle
        );
    }
}
