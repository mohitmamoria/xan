<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nticaric\Twitter\TwitterStream;
use TwitterAPIExchange;
use App\Xan\TrackXanRocks;
use App\Xan\Trackable;
use Phirehose;

class XanRocks extends Command
{
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
        $stream = new TrackXanRocks(
            config('xan.twitter.access_token'),
            config('xan.twitter.access_token_secret'),
            Phirehose::METHOD_FILTER
        );

        $stream->consumerKey = config('xan.twitter.consumer_key');
        $stream->consumerSecret = config('xan.twitter.consumer_secret');

        if($stream instanceof Trackable)
        {
            $stream->setTrack($stream->getTrack());
        }

        $stream->consume();
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
