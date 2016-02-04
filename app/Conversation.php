<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
    	'trigger_tweet_id',
    	'sniper_user_id',
    	'sniper_user_screen_name',
    	'sniper_user_utc_offset',
    	'target_user_id',
    	'target_user_screen_name'
    ];

    protected $dates = [
    	'created_at',
    	'updated_at',
    	'deleted_at',
    	'closed_at',
    	'first_reminder_at',
    	'last_reminder_at'
    ];
}
