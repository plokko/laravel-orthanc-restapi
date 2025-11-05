<?php

/**
 * Laravel-DCMTK settings
 */
return [

    /// Define the default server name to use (see servers section below)
    'default-server' => env('ORTHANCAPI_DEFAULT_SERVER', 'default'),

    'timeout' => 60,

    'cache_timeout' => 30,

    'debug' => env('ORTHANCAPI_DEBUG', false),

    'upload_timeout' => 300, /// Upload request timeout in seconds
    /// List of servers
    'servers' => [
        'default' => [
            'address' => env('ORTHANCAPI_HOST', 'http://orthanc:8042'),
        ],
    ],
];
