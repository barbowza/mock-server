<?php

/** @global MockServer\RequestContext $context */
/** @global MockServer\Response $response */

try {
    $body = json_encode([
        'timestamp' => date('Y-m-d H:i:s'),
        'context'   => $context ? $context->toArray() : [],
        '$_SERVER'  => $_SERVER,
        '$_GET'     => $_GET,
        '$_POST'    => $_POST,
        '$_COOKIE'  => $_COOKIE,
    ], JSON_THROW_ON_ERROR);

    $response->setBody($body);
    $response->addHeader('Content-Type: application/json');

} catch (JsonException $e) {
    $response->setBody('JSON encoding error');
    $response->setCode(MockServer\Response::HTTP_INTERNAL_SERVER_ERROR);
    $response->addHeader('Content-Type: text/plain');
}

return $response;
