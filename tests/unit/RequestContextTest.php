<?php

declare(strict_types=1);

use MockServer\Request;
use MockServer\RequestContext;
use PHPUnit\Framework\TestCase;

class RequestContextTest extends TestCase
{
    public function test_context_instance(): void
    {
        $context = new RequestContext(self::getRequest());

        $this->assertInstanceOf(RequestContext::class, $context);
    }

    public function test_context_uri(): void
    {
        $context = new RequestContext(self::getRequest());

        $this->assertEquals('/some-path', $context->getUri());
    }

    public function test_context_body(): void
    {
        $context = new RequestContext(self::getRequest());

        $this->assertEquals('some-body', $context->getBody());
    }

    protected static function getRequest(): Request
    {
        return new Request(
            '/some-path',
            ["Accept" => "*/*"],
            'some-body'
        );
    }

}
