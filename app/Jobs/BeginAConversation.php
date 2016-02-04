<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Twitter\Twitter;
use TwitterAPIExchange;

class BeginAConversation extends Job
{
    protected $tweet;

    protected $twitter;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tweet)
    {
        $this->twitter = app(Twitter::class);
        $this->tweet = $tweet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tweet = $this->twitter->postTweet(array(
            'status' => $this->makeTweet(),
            'in_reply_to_status_id' => $this->tweet['id']
        ));
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
