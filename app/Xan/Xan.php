<?php

namespace App\Xan;

class Xan
{
	public static $TRIGGER_HASHTAG = 'XanRocks';

	public static $XAN_HANDLE = 'XanHere';

	public static function getTriggerHashtag()
	{
		return '#'.static::$TRIGGER_HASHTAG;
	}

	public static function getXanHandle()
	{
		return '@'.static::$XAN_HANDLE;
	}
}