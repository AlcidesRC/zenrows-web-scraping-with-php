<?php

declare(strict_types=1);

return [
    'output' => './output/scrapeme-live-shop.csv',

    'concurrency' => 12,

    'guzzle_client' => [
        'allow_redirects' => true,
        'connect_timeout' => 2,
        'timeout'         => 5,
        'base_uri'        => 'https://scrapeme.live/shop/',
    ],
];
