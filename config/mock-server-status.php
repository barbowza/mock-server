<?php

function getResponse(array $context): string
{
    return date('Y-m-d H:i:s') . ' ' . $context['uri'] .' Operational'. ' (script:' . basename(__FILE__) .')';
}
