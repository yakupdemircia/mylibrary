<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'cloudwatch'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver'   => 'stack',
            'channels' => ['single'],
        ],

        'single' => [
            'driver' => 'single',
            'path'   => storage_path('logs/laravel.log'),
            'level'  => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path'   => storage_path('logs/laravel.log'),
            'level'  => 'debug',
            'days'   => 7,
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level'  => 'debug',
        ],

        'errorlog'   => [
            'driver' => 'errorlog',
            'level'  => 'debug',
        ],
        'cloudwatch' => [
            'driver'      => 'custom',
            'via'         => \App\Logging\CloudWatchLoggerFactory::class,
            'sdk'         => [
                'region'      => 'eu-west-1',
                'version'     => 'latest',
                'credentials' => [
                    'key'    => env('AWS_CLOUDWATCH_KEY'),
                    'secret' => env('AWS_CLOUDWATCH_SECRET')
                ]
            ],
            'retention'   => 30,
            'level'       => env('APP_LOG_LEVEL', 'debug'),
            'group_name'  => env('AWS_CLOUDWATCH_GROUP', 'BinnazAblaV4'),
            'stream_name' => env('AWS_CLOUDWATCH_STREAM', 'web-local'),
        ],

    ],

];