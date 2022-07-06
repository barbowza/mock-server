<?php
return [
    "routes" => [[
        'path' => '!^/hello$!i',
        'verb' => 'GET',
        'response' => [
            'staticData' => "world from staticData",
        ],
    ], [
        'path' => '!^/param/([^/]+)/?$!i',
        'verb' => 'GET',
        'response' => [
            'staticData' => "param \$1 (param expansion todo)",
        ],
    ], [
        'path' => '!^/response/php?$!i',
        'verb' => 'GET',
        'response' => [
            'scriptFile' => "script.php",
        ],
    ]],
];
