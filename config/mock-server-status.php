<?php

/** @global MockServer\RequestContext $context */
/** @global MockServer\Response $response */


$response->addHeader('Mock-Server: ' . $context->getServerVersion());
$response->addHeader('Content-Type: text/plain');

return $response->setBody(
    date('Y-m-d H:i:s') . ' ' . $context->getRequestUri() . ' Operational' . ' (script:' . basename(__FILE__) . ')'
);
