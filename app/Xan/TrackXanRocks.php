<?php

namespace App\Xan;

use OauthPhirehose;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\BeginRocking;

class TrackXanRocks extends OauthPhirehose implements Trackable
{
	use DispatchesJobs;

	public function enqueueStatus($status) {
		$job = new BeginRocking(json_decode($status, true));

		$this->dispatch($job);
	}

	public function getTrack()
	{
		return ['#XanRocks'];
	}
}