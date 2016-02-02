<?php

namespace App\Jobs;

use App\Jobs\Job;
use TwitterAPIExchange;

class BeginRocking extends Job
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
        if($this->isAReply()) {
            $this->closeTheConversation();
        } else if($this->isAStarter()) {
            $this->beginConversation();
        }
    }

    protected function isAStarter()
    {
        $hashtags = array_pluck($this->tweet['entities']['hashtags'], 'text');

        return in_array(Xan::$STARTER_HASHTAG, $hashtags);
    }

    protected function isAReply()
    {
        $mentions = array_pluck($this->tweet['entities']['user_mentions'], 'screen_name');

        return in_array(Xan::$XAN_HANDLE, $mentions);
    }

    protected function closeAConversation()
    {
        // close the conversation
    }

    protected function beginConversation()
    {
        $twitter = new TwitterAPIExchange(array(
            'consumer_key'                 => config('xan.twitter.consumer_key'),
            'consumer_secret'              => config('xan.twitter.consumer_secret'),
            'oauth_access_token'           => config('xan.twitter.access_token'),
            'oauth_access_token_secret'    => config('xan.twitter.access_token_secret')
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
