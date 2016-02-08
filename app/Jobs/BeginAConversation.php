<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Conversation;
use App\Story;
use App\Twitter\Twitter;
use Illuminate\Foundation\Bus\DispatchesJobs;

class BeginAConversation extends Job
{
    use DispatchesJobs;

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
        // Someone triggered the conversation without mentioning the target user
        if(is_null($this->tweet['in_reply_to_user_id'])) return;

        $conversation = Conversation::create([
            'trigger_tweet_id' => $this->tweet['id_str'],
            'sniper_user_id' => $this->tweet['user']['id_str'],
            'sniper_user_screen_name' => $this->tweet['user']['screen_name'],
            'sniper_user_utc_offset' => $this->tweet['user']['utc_offset'],
            'target_user_id' => $this->tweet['in_reply_to_user_id_str'],
            'target_user_screen_name' => $this->tweet['in_reply_to_screen_name'],
            'story_id' => Story::random()->id
        ]);

        $this->dispatch(new AnnoyTheTarget($conversation));
    }
}
