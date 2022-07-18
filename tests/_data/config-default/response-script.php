<?php

/** @var MockServer\RequestContext $context */

return date('Y-m-d H:i:s') . ' dynamic response ' . $context->getUri() . ' ' . basename(__FILE__);
