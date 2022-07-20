<?php

/** @global MockServer\RequestContext $context */
/** @global MockServer\Response $response */


$response->addHeader('Mock-Server: ' . $context->getVersion());
$response->addHeader('Content-Type: text/plain');

return $response->setBody(
    date('Y-m-d H:i:s') . ' ' . $context->getUri() . ' Operational' . ' (script:' . basename(__FILE__) . ')'
);
