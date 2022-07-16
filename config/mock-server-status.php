<?php

function getResponse(array $context): string
{
    return date('Y-m-d H:i:s') . ' mock-server operational. uri:' . $context['uri'] . ' script:' . basename(__FILE__);
}
