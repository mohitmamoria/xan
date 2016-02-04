<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nticaric\Twitter\TwitterStream;
use TwitterAPIExchange;
use App\Xan\StreamTwitter;
use App\Xan\Trackable;
use Phirehose;

class XanRocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xan:rock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xan begins rocking.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $stream = new StreamTwitter(
            config('xan.twitter_stream.access_token'),
            config('xan.twitter_stream.access_token_secret'),
            Phirehose::METHOD_FILTER
        );

        $stream->consumerKey = config('xan.twitter_stream.consumer_key');
        $stream->consumerSecret = config('xan.twitter_stream.consumer_secret');

        if($stream instanceof Trackable)
        {
            $stream->setTrack($stream->getTrack());
        }

        $stream->consume();
    }
}
