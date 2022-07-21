<?php

return [
    'mock-server-config' => '1.0.0',

    'description' => 'Test configuration',

    'routes' => [
        [
            'uri'      => '!^/hello$!i',
            'verb'     => 'GET',
            'response' => [
                'static-data' => 'string from staticData',
                'headers' => [
                    'Content-Type: text/plain'
                ]
            ],
        ], [
            'uri'      => '!^/param/([^/]+)/?$!i',
            'verb'     => 'GET',
            'response' => [
                'static-data' => "param \$1 (param expansion todo)",
            ],
        ], [
            'uri'      => '!^/dynamic/php?$!i',
            'verb'     => 'GET',
            'response' => [
                'script-file' => 'response-script.php',
            ],
        ], [
            'description' => 'Return a server exception',
            'uri'      => '!^/exception$!i',
            'verb'     => '*',
            'response' => [
                'script-file' => 'mock-server-exception.php',
            ],
        ],
    ],
];
