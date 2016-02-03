<?php

return [
    'twitter_stream' => [
        'consumer_key' => env('TWITTER_STREAM_CONSUMER_KEY'),
        'consumer_secret' => env('TWITTER_STREAM_CONSUMER_SECRET'),
        'access_token' => env('TWITTER_STREAM_ACCESS_TOKEN'),
        'access_token_secret' => env('TWITTER_STREAM_ACCESS_TOKEN_SECRET'),
    ],
    'twitter_api' => [
        'consumer_key' => env('TWITTER_API_CONSUMER_KEY'),
        'consumer_secret' => env('TWITTER_API_CONSUMER_SECRET'),
        'access_token' => env('TWITTER_API_ACCESS_TOKEN'),
        'access_token_secret' => env('TWITTER_API_ACCESS_TOKEN_SECRET'),
    ],
];
