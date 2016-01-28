<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nticaric\Twitter\TwitterStream;
use TwitterAPIExchange;

class XanRocks extends Command
{
    public static $CONSUMER_KEY = 'mVKYY3mzBrrJSKuCNKx0vkFoC';
    public static $CONSUMER_SECRET = 's37MuYXl5U46kBOG9gXBfvUuTBmIwFZCD4cyPJX0bQtomIt3Gi';
    public static $ACCESS_TOKEN = '4824294895-r6psnfcVAxpJ8YFTaRwctcnfJv5CRBEWGwjeu9I';
    public static $ACCESS_TOKEN_SECRET = 'tvpSMsu3ebnCf1gy9HsCH1Lyx37XBop5DnQ9SrIOCRBec';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xan:rocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xan begins rocking.';

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
        $stream = new TwitterStream(array(
            'consumer_key'    => static::$CONSUMER_KEY,
            'consumer_secret' => static::$CONSUMER_SECRET,
            'token'           => static::$ACCESS_TOKEN,
            'token_secret'    => static::$ACCESS_TOKEN_SECRET
        ));

        try {
            $stream->getStatuses(['track' => '#XanRocks'], function($tweet) {
                // prints to the screen statuses as they come along
                print_r($tweet);

                // respond to the tweet
                // $this->respondToTweet($tweet);
            });
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            dd($e->getResponse()->getBody());
        }

    }

    protected function respondToTweet($tweet)
    {
        // $twitter = new TwitterAPIExchange(array(
        //     'consumer_key'                 => static::$CONSUMER_KEY,
        //     'consumer_secret'              => static::$CONSUMER_SECRET,
        //     'oauth_access_token'           => static::$ACCESS_TOKEN,
        //     'oauth_access_token_secret'    => static::$ACCESS_TOKEN_SECRET
        // ));

        // echo $twitter->buildOauth("https://api.twitter.com/1.1/statuses/update.json", "POST")
        //                  ->setPostFields(array(
        //                     'status' => '@' . $tweet['in_reply_to_screen_name'] . ' @' . $tweet['user']['screen_name'] . ' Hello. Xan here. Remind me after an hour · Remind me tomorrow.',
        //                     'in_reply_to_status_id' => $tweet['id']
        //                  ))
        //                  ->performRequest();
    }
}
