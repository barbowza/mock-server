<?php

return [
    'mock-server-config' => '1.0.0',

    'description' => 'mock-server default configuration',

    'routes' => [
        [
            'uri'      => '!^/mock-server$!i',
            'verb'     => '*',
            'response' => [
                'static-data' => date('Y-m-d H:i:s') . ' /mock-server Operational',
                'headers' => [
                    'Content-Type: application/json'
                ]
            ],
        ], [
            'uri'      => '!^/mock-server/status$!i',
            'verb'     => 'GET',
            'response' => [
                'script-file' => 'mock-server-status.php',
            ],
        ], [
            'uri'      => '!^/mock-server/reflect$!i',
            'verb'     => '*',
            'response' => [
                'script-file' => 'mock-server-reflect.php',
            ],
        ],
    ]
];
