<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Story;

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

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public static function findByTriggerTweetId($triggerTweetId)
    {
        return static::where('trigger_tweet_id', $triggerTweetId)->get();
    }

    public static function closeByTriggerTweetId($triggerTweetId, $closingTweetId)
    {
        return static::open()->where('trigger_tweet_id', $triggerTweetId)
            ->update([
                'closing_tweet_id' => $closingTweetId,
                'closed_at' => Carbon::now()
            ]);
    }

    public function scopeOpen($query)
    {
        return $query->whereNull('closed_at');
    }

    public function close($closingTweetId)
    {
        return static::closeByTriggerTweetId($this->trigger_tweet_id, $closingTweetId);
    }

    public function giveUp()
    {
        $this->gave_up_at = Carbon::now();

        $this->closed_at = $this->gave_up_at;

        $this->save();
    }

    public function justAnnoyed($annoyingChapter)
    {
        $this->last_chapter_sequence = $annoyingChapter->sequence;

        $this->last_chapter_at = Carbon::now();

        // if first chapter, set its timestamp equal to the last chapter's timestamp
        if(is_null($this->first_chapter_at))
        {
            $this->first_chapter_at = $this->last_chapter_at;
        }

        $this->save();
    }
}
