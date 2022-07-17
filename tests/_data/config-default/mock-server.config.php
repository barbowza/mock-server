<?php

return [
    'mock-server-config' => '1.0.0',
    "routes" => [[
        'uri' => '!^/hello$!i',
        'verb' => 'GET',
        'response' => [
            'static-data' => "string from staticData",
        ],
    ], [
        'uri' => '!^/param/([^/]+)/?$!i',
        'verb' => 'GET',
        'response' => [
            'static-data' => "param \$1 (param expansion todo)",
        ],
    ], [
        'uri' => '!^/dynamic/php?$!i',
        'verb' => 'GET',
        'response' => [
            'script-file' => "response-script.php",
        ],
    ]],
];
