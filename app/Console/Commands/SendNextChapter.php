<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Conversation;
use App\Twitter\Twitter;
use App\Jobs\AnnoyTheTarget;

class SendNextChapter extends Command
{
    use DispatchesJobs;

    protected $twitter;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xan:send-next-chapter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends Next Chapter To The Conversations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Twitter $twitter)
    {
        parent::__construct();
        $this->twitter = $twitter;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $conversations = Conversation::open()->get();

        foreach($conversations as $conversation)
        {
            $closingTweet = $this->findClosingTweet($conversation);

            if(is_null($closingTweet))
            {
                $this->dispatch(new AnnoyTheTarget($conversation));
            } else {
                $conversation->close($closingTweet['id']);
            }
        }
    }

    protected function findClosingTweet($conversation, $maxTweetId = null)
    {
        $result = $this->twitter->search($this->makeQueryString($conversation, $maxTweetId));

        // if not tweets found, return null
        if(count($result['statuses']) == 0) return;
        
        // loop through the found tweets
        foreach($result['statuses'] as $tweet)
        {
            // if the tweet was a response to the trigger tweet
            if($tweet['in_reply_to_status_id_str'] === $conversation->trigger_tweet_id)
            {
                // return the closing tweet
                return $tweet;
            }
        }

        // no closing tweet found in this set, fetch next set of tweets
        // NOTE: passing maxTweetId as 1 less than the minimum ID that
        // that we got in the current set. Otherwise, it will keep returning
        // results containing the one tweet represented by this ID and the
        // base condition i.e. count($result['statuses']) == 0 will never be TRUE.
        return $this->findClosingTweet($conversation, $tweet['id'] - 1);
    }

    protected function makeQueryString(Conversation $conversation, $maxTweetId = null)
    {
        // query to search if there's a tweet from 'target'
        // to the 'sniper' since 'sniper' triggered Xan
        $query = sprintf(
            '?q=from:%s to:%s&since_id=%s&result=recent&count=100',
            $conversation->target_user_screen_name,
            $conversation->sniper_user_screen_name,
            $conversation->trigger_tweet_id
        );

        // for pagination
        if( ! is_null($maxTweetId))
        {
            $query .= '&max_id='.$maxTweetId;
        }

        return $query;
    }
}
