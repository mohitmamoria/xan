<?php

namespace App\Xan;

use OauthPhirehose;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\ProcessTweet;
use App\Xan\Xan;

class StreamTwitter extends OauthPhirehose implements Trackable
{
	use DispatchesJobs;

	public function enqueueStatus($status) {
		$tweet = json_decode($status, true);

		print_r($tweet);

		$job = new ProcessTweet($tweet);

		$this->dispatch($job);
	}

	public function getTrack()
	{
		return [Xan::getTriggerHashtag(), Xan::getXanHandle()];
	}
}