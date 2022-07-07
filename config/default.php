<?php

return [
    "routes" => [
        [
            'path'     => '!^/!i',
            'verb'     => '*',
            'response' => [
                'staticData' => "default response",
            ],
        ]
    ]
];
