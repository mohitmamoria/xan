<?php

namespace App\Jobs;

use App\Jobs\Job;

class CloseTheConversation extends Job
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
        // 1. Find the Trigger Tweet's ID

        // 2. Close the conversation
    }
}
