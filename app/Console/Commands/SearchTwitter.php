<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Twitter\Twitter;

class SearchTwitter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xan:search-twitter {from_handle} {to_handle} {--since_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Searches Twitter for tweets.';

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
        $tweets = $this->twitter->search($this->makeQueryString());

        print_r($tweets);
    }

    protected function makeQueryString()
    {
        $sinceId = $this->option('since_id');

        $query = sprintf('?q=%s&result=%s&count=%d', $this->makeSearchQuery(), 'recent', 100);

        if($sinceId)
        {
            $query .= sprintf('&since_id=%d', $sinceId);
        }

        $this->info('Search Query: ' . $query);

        return $query;
    }

    protected function makeSearchQuery()
    {
        $fromHandle = $this->argument('from_handle');
        $toHandle = $this->argument('to_handle');

        return sprintf(
            'from:%s to:%s',
            $fromHandle,
            $toHandle,
            $toHandle
        );
    }
}
