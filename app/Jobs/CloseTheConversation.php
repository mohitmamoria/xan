<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Twitter\Twitter;
use App\Conversation;

class CloseTheConversation extends Job
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
        // If not a reply, do nothing.
        if(is_null($this->tweet['in_reply_to_status_id'])) return;
        
        // Find the Trigger Tweet's ID
        $triggerTweetId = $this->twitter->find($this->tweet['in_reply_to_status_id'])['in_reply_to_status_id'];
        
        // If no trigger tweet found, do nothing.
        if(is_null($triggerTweetId)) return;

        // Close the conversation
        echo 'Closing conversation with Trigger Tweet ID: ' . $triggerTweetId;
        Conversation::closeByTriggerTweetId($triggerTweetId, $this->tweet['id']);
    }
}
