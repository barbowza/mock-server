<?php

return [
    "routes" => [
        [
            'uri'     => '!^/!i',
            'verb'     => '*',
            'response' => [
                'static-data' => "default response",
            ],
        ]
    ]
];
