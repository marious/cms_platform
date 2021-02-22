<?php
return [
    'admin_dir' => env('ADMIN_DIR', 'admin'),
    'base_name' => env('APP_NAME', 'Marious Shop'),
    'setting_driver' => env('SETTING_DRIVER', 'database'),
    'logo'                      => '/vendor/core/base/images/logo_white.png',
    'favicon'                   => '/vendor/core/base/images/favicon.png',
    'cache' => [
        'enabled' => env('SETTING_STORE_CACHE', false),
    ],
    'editor'                    => [
        'ckeditor' => [
            'js' => [
                '/vendor/core/base/libraries/ckeditor/ckeditor.js',
            ],
        ],
        'tinymce'  => [
            'js' => [
                '/vendor/core/base/libraries/tinymce/tinymce.min.js',
            ],
        ],
        'primary'  => env('PRIMARY_EDITOR', 'ckeditor'),
    ],
    'date_format'               => [
        'date'      => 'Y-m-d',
        'date_time' => 'Y-m-d H:i:s',
        'js'        => [
            'date'      => 'yyyy-mm-dd',
            'date_time' => 'yyyy-mm-dd H:i:s',
        ],
    ],
    'cache_site_map'            => env('ENABLE_CACHE_SITE_MAP', false),
    'public_single_ending_url'  => env('PUBLIC_SINGLE_ENDING_URL', null),
    'send_mail_using_job_queue' => env('SEND_MAIL_USING_JOB_QUEUE', false),
    'locale'                    => env('APP_LOCALE', 'en'),
    'can_execute_command'       => env('CAN_EXECUTE_COMMAND', true),
];
