<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Story;
use App\Chapter;

class SeedStories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xan:seed-stories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds the first batch of stories.';

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
        $story = Story::create(['name' => 'Default']);

        $chapters = [
            1 => ":target Hello. I am Xan - :sniper's annoying bot that will bug you until you respond to this tweet. :emoji_bell",
            2 => ":target Yo! Haven't responded to :sniper's tweet yet? Consider this as a gentle reminder. :emoji_angel",
            3 => ":target Come on, what could be taking you sooooo long? :sniper is waiting. Hit reply and let me take rest. :emoji_army",
            4 => ":target Testing my patience? Or :sniper's? I'll give you a tip: DON'T :emoji_cross. Reply now. Now. NOW.",
            5 => ":target I'll try to be polite. Ever considered how important your one tweet can be to :sniper? :emoji_heart_eye",
            6 => ":target What if I keep tweeting to you until you beg for mercy? Want that? Then reply to :sniper. Come on!",
            7 => ":target Fact #1: No one has made me request so much ever before. Fact #2: :sniper is NOT liking it. :emoji_angry",
            8 => ":target You are a tough nut :emoji_dragon. I am tougher. Expect endless stream of tweets from :sniper in next few hours.",
            9 => ":target OH GOD! Even my warnings are fruitless on you. Do you even have a heart? :emoji_heart :sniper's eyes are teary.",
            10 => ":target I think I'll let :sniper know how stone-hearted you are. I am a robot :emoji_robot and still have more heart.",
            11 => ":target Before I pass on bad news to :sniper, I'd like to give you one last chance. LAST. Mind replying? :emoji_angel",
            12 => ":target The time has come, I guess. If you don't reply to this last reminder, I'll go and break :sniper's heart. :emoji_broken_heart"
        ];

        $chaptersWithoutEmojis = [
            1 => ":target Hello. I am Xan - :sniper's annoying bot that will bug you until you respond to this tweet.",
            2 => ":target Yo! Haven't responded to :sniper's tweet yet? Consider this as a gentle reminder.",
            3 => ":target Come on, what could be taking you sooooo long? :sniper is waiting. Hit reply and let me take rest.",
            4 => ":target Testing my patience? Or :sniper's? I'll give you a tip: DON'T. Reply now. Now. NOW.",
            5 => ":target I'll try to be polite. Ever considered how important your one tweet can be to :sniper?",
            6 => ":target What if I keep tweeting to you until you beg for mercy? Want that? Then reply to :sniper. Come on!",
            7 => ":target Fact #1: No one has made me request so much ever before. Fact #2: :sniper is NOT liking it.",
            8 => ":target You are a tough nut. I am tougher. Expect endless stream of tweets from :sniper in next few hours.",
            9 => ":target OH GOD! Even my warnings are fruitless on you. Do you even have a heart? :sniper's eyes are teary.",
            10 => ":target I think I'll let :sniper know how stone-hearted you are. I am a robot and still have more heart.",
            11 => ":target Before I pass on bad news to :sniper, I'd like to give you one last chance. LAST. Mind replying?",
            12 => ":target The time has come, I guess. If you don't reply to this last reminder, I'll go and break :sniper's heart."
        ];

        foreach($chaptersWithoutEmojis as $sequence => $body)
        {
            Chapter::create([
                'story_id' => $story->id,
                'sequence' => $sequence,
                'body' => $body
            ]);
        }
    }
}
