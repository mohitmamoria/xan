<?php

namespace App\Jobs;

use App\Jobs\Job;
use TwitterAPIExchange;

class BeginAConversation extends Job
{
    protected $tweet;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tweet)
    {
        $this->tweet = $tweet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $this->twitter->postTweet(array(
        //     'status' => $this->makeTweet(),
        //     'in_reply_to_status_id' => $this->tweet['id']
        // ));

        $twitter = new TwitterAPIExchange(array(
            'consumer_key'                 => config('xan.twitter_api.consumer_key'),
            'consumer_secret'              => config('xan.twitter_api.consumer_secret'),
            'oauth_access_token'           => config('xan.twitter_api.access_token'),
            'oauth_access_token_secret'    => config('xan.twitter_api.access_token_secret')
        ));

        echo $twitter->buildOauth("https://api.twitter.com/1.1/statuses/update.json", "POST")
                         ->setPostFields(array(
                            'status' => $this->makeTweet(),
                            'in_reply_to_status_id' => $this->tweet['id']
                         ))
                         ->performRequest();
    }

    private function makeTweet()
    {
        return sprintf(
            '@%s Hello. I am Xan - @%s\'s annoying bot that will bug you until you respond to this tweet. 🔔 ;)',
            $this->tweet['in_reply_to_screen_name'],
            $this->tweet['user']['screen_name']
        );
    }
}
