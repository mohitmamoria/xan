<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Conversation;
use App\Twitter\Twitter;
use Carbon\Carbon;

class AnnoyTheTarget extends Job
{
    protected $conversation;

    protected $tweet;

    protected $twitter;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($conversation, $tweet)
    {
        $this->twitter = app(Twitter::class);
        $this->tweet = $tweet;
        $this->conversation = $conversation;
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

        $this->updateConversation();
    }

    private function updateConversation()
    {
        $this->conversation->reminders_count++;
        $this->conversation->last_reminder_at = Carbon::now();
        if(is_null($this->conversation->first_reminder_at))
        {
            // if first reminder, set the timestamp equal to the last reminder's timestamp
            $this->conversation->first_reminder_at = $this->conversation->last_reminder_at;
        }
        $this->conversation->save();
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
