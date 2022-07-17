<?php

return json_encode(
    [
        'timestamp' => date('Y-m-d H:i:s'),
        'context' => $context,
        '$_SERVER' => $_SERVER,
        '$_GET' => $_GET,
        '$_POST' => $_POST,
        '$_COOKIE' => $_COOKIE,
    ]
);
