<?php


return [
    'routes' => [
        [
            'uri'     => '!^/mock-server/$!i',
            'verb'     => '*',
            'response' => [
                'static-data' => date('Y-m-d H:i:s') . ' default response from mock-server',
            ],
        ],
        [
            'uri'     => '!^/mock-server/status$!i',
            'verb'     => 'GET',
            'response' => [
                'script-file' => 'mock-server-status.php',
            ],
        ],
    ]
];
