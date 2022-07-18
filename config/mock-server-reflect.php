<?php

/** @var MockServer\RequestContext $context */

try {
    $response = json_encode([
        'timestamp' => date('Y-m-d H:i:s'),
        'context'   => $context ? $context->toArray() : [],
        '$_SERVER'  => $_SERVER,
        '$_GET'     => $_GET,
        '$_POST'    => $_POST,
        '$_COOKIE'  => $_COOKIE,
    ], JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    $response = '500 JSON encoding error';
}

return $response;
