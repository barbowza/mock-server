<?php

function getResponse(array $context): string
{
    return date('Y-m-d H:i:s') . ' dynamic response ' . $context['uri'] . ' ' . basename(__FILE__);
}
