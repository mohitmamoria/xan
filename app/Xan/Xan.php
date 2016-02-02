<?php

namespace App\Xan;

class Xan
{
	public static $STARTER_HASHTAG = 'XanRocks';

	public static $XAN_HANDLE = 'XanHere';

	public static function getStarterHashtag()
	{
		return '#'.static::$STARTER_HASHTAG;
	}

	public static function getXanHandle()
	{
		return '@'.static::$XAN_HANDLE;
	}
}