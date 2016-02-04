<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Foundation\Bus\DispatchesJobs;
use TwitterAPIExchange;

class ProcessTweet extends Job
{
    use DispatchesJobs;

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
            $this->dispatch(new CloseTheConversation($this->tweet));
        } else if($this->isAStarter()) {
            $this->dispatch(new BeginAConversation($this->tweet));
        } else {
            // ignore any other cases
        }
    }

    protected function isAStarter()
    {
        $hashtags = array_pluck($this->tweet['entities']['hashtags'], 'text');

        return in_array(Xan::$STARTER_HASHTAG, $hashtags);
    }

    protected function isAReply()
    {
        return $this->tweet['in_reply_to_screen_name'] === Xan::$XAN_HANDLE;
    }
}
