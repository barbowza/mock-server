<?php

/** @var MockServer\RequestContext $context */

return date('Y-m-d H:i:s') . ' ' . $context->getUri() . ' Operational' . ' (script:' . basename(__FILE__) . ')';
