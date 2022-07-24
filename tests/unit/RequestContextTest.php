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

        $this->assertStringContainsString('MyVariableTwo', $context->getBody());
    }

    public function test_context_array(): void
    {
        $context = new RequestContext(self::getRequest());

        $this->assertContains('/some-path', $context->toArray());
        $this->assertArrayHasKey('request.method', $context->toArray());
        $this->assertArrayHasKey('server.version', $context->toArray());
    }

    protected static function getRequest(): Request
    {
        return new Request(
            '/some-path',
            'GET',
            ["Content-Type" => "application/x-www-form-urlencoded"],
            'MyVariableOne=ValueOne&MyVariableTwo=ValueTwo',
            [
                'p1' => 'foo',
                'p2' => 'bar'
            ]

        );
    }
}
