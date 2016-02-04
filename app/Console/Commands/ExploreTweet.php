<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Twitter\Twitter;

class ExploreTweet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xan:explore-tweet {tweet_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Explores a tweet.';

    protected $twitter;

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
        $tweetId = $this->argument('tweet_id');

        $tweet = $this->twitter->find($tweetId);

        print_r($tweet);
    }
}
