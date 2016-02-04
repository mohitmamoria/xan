<?php

namespace App\Twitter;

use TwitterAPIExchange;

class Twitter
{
	protected static $BASE_URL = 'https://api.twitter.com/1.1';

	protected $consumerKey;
	protected $consumerSecret;
	protected $accessToken;
	protected $accessTokenSecret;

	public function __construct($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret)
	{
		$this->consumerKey = $consumerKey;
		$this->consumerSecret = $consumerSecret;
		$this->accessToken = $accessToken;
		$this->accessTokenSecret = $accessTokenSecret;
	}

	public function find($tweetId)
	{
		$tweet = $this->newExchange()
			->setGetField('?id='.$tweetId)
            ->buildOauth(static::$BASE_URL.'/statuses/show.json', 'GET')
            ->performRequest();

        return json_decode($tweet, true);
	}

	public function search($queryString)
	{
		$tweets = $this->newExchange()
			->setGetField($queryString)
			->buildOauth(static::$BASE_URL.'/search/tweets.json', 'GET')
			->performRequest();

		return json_decode($tweets, true);
	}

	public function postTweet($parameters)
	{
		$tweet = $this->newExchange()
			->buildOauth(static::$BASE_URL.'/statuses/update.json', 'POST')
			->setPostFields($parameters)
			->performRequest();

		return json_decode($tweet, true);
	}

	protected function newExchange()
	{
		return new TwitterAPIExchange(array(
		    'consumer_key'                 => $this->consumerKey,
		    'consumer_secret'              => $this->consumerSecret,
		    'oauth_access_token'           => $this->accessToken,
		    'oauth_access_token_secret'    => $this->accessTokenSecret
		));
	}
}