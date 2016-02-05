<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Conversation extends Model
{
    protected $fillable = [
    	'trigger_tweet_id',
    	'sniper_user_id',
    	'sniper_user_screen_name',
    	'sniper_user_utc_offset',
    	'target_user_id',
    	'target_user_screen_name',
        'story_id'
    ];

    protected $dates = [
    	'created_at',
    	'updated_at',
    	'deleted_at',
    	'closed_at',
    	'first_reminder_at',
    	'last_reminder_at'
    ];

    public static function findByTriggerTweetId($triggerTweetId)
    {
        return static::where('trigger_tweet_id', $triggerTweetId)->get();
    }

    public static function closeByTriggerTweetId($triggerTweetId, $closingTweetId)
    {
        return static::where('trigger_tweet_id', $triggerTweetId)
            ->whereNull('closed_at')
            ->update([
                'closing_tweet_id' => $closingTweetId,
                'closed_at' => Carbon::now()
            ]);
    }
}
