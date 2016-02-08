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
    public function __construct($conversation)
    {
        $this->twitter = app(Twitter::class);

        $this->conversation = $conversation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // is it the RIGHT TIME to annoy the target?
        if( ! $this->conversation->isItTimeToSendNextChapter()) return;
        
        $nextChapter = $this->conversation->story->nextChapter($this->conversation->last_chapter_sequence);

        if(is_null($nextChapter)) {
            $this->giveUp();
        } else {
            $this->annoy($nextChapter);
        }
    }

    private function giveUp()
    {
        $tweet = $this->twitter->postTweet(array(
            'status' => $this->makeGiveUpTweet(),
            'in_reply_to_status_id' => $this->conversation->trigger_tweet_id
        ));

        $this->conversation->giveUp();
    }

    private function annoy($annoyingChapter)
    {
        $tweet = $this->twitter->postTweet(array(
            'status' => $this->makeTweet($annoyingChapter),
            'in_reply_to_status_id' => $this->conversation->trigger_tweet_id
        ));

        $this->conversation->justAnnoyed($annoyingChapter);
    }

    private function makeGiveUpTweet()
    {
        return str_replace(
            [':target', ':sniper'],
            ['@'.$this->conversation->target_user_screen_name, '@'.$this->conversation->sniper_user_screen_name],
            ':target I GIVE UP ON YOU. You are beyond pathetic when even a ROBOT gives up on you. Just saying. (Sorry :sniper, I tried.)'
        );
    }

    private function makeTweet($chapterToTweet)
    {
        return str_replace(
            [':target', ':sniper'],
            ['@'.$this->conversation->target_user_screen_name, '@'.$this->conversation->sniper_user_screen_name],
            $chapterToTweet->body
        );
    }

    private function addEmojis($tweet)
    {
        // return str_replace(
        //     [':emoji_bell', ':emoji_angel', ':emoji_army', ':emoji_cross', ':emoji_heart_eye', ':emoji_angry', ':emoji_dragon', ':emoji_heart', ':emoji_robot', ':emoji_broken_heart'],
        //     [🔔, 👼, 💂, ❌, 😍, 😤, 🐲, 💖, 👾, 💔],
        //     $tweet
        // );
    }
}