<?php

// config for Habib/LaravelWasl
return [
    'wasl_env' => env('WASL_ENV', 'live'),
    'live' => [
        'base_url' => env('LIVE_WASL_BASE_URL', 'https://wasl.api.elm.sa/api/dispatching/v2'),

        'client_id' => env('LIVE_WASL_CLIENT_ID'),

        'app_id' => env('LIVE_WASL_APP_ID'),

        'app_key' => env('LIVE_WASL_APP_KEY'),

        'timeout' => env('LIVE_WASL_TIMEOUT', 30),
    ],
    'dev' => [
        'base_url' => env('DEV_WASL_BASE_URL', 'https://wasl.api.elm.sa/api/dispatching/v2'),

        'client_id' => env('DEV_WASL_CLIENT_ID'),

        'app_id' => env('DEV_WASL_APP_ID'),

        'app_key' => env('DEV_WASL_APP_KEY'),

        'timeout' => env('DEV_WASL_TIMEOUT', 30),
    ],
];
