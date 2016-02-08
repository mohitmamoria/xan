<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
        Commands\XanRocks::class,
        Commands\ExploreTweet::class,
        Commands\SearchTwitter::class,
        Commands\SendNextChapter::class,
        Commands\SeedStories::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('xan:send-next-chapter')
            ->everyTenMinutes()
            ->appendOutputTo('/var/log/xan/send-next-chapter.log');
    }
}
