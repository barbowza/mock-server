<?php

/** @global MockServer\RequestContext $context */
/** @global MockServer\Response $response */

$response->addHeader('Content-Type: text/plain');

return $response->setBody(
     date('Y-m-d H:i:s') . ' dynamic response ' . $context->getUri() . ' ' . basename(__FILE__)
);
