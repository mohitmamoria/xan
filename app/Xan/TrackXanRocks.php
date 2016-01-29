<?php

namespace App\Xan;

use OauthPhirehose;

class TrackXanRocks extends OauthPhirehose implements Trackable
{
	public function enqueueStatus($status) {
		print_r($status);
	}

	public function getTrack()
	{
		return ['#XanRocks'];
	}
}