<?php

declare(strict_types=1);

use MockServer\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function test_route_static_response_correct(): void
    {
        $route = new Route(
            '!^/some-uri$!',
            'VERB',
            'hello world'
        );

        $this->assertIsString($route->getUriRegex());
        $this->assertEquals('VERB', $route->getVerb());

        $this->assertEquals('hello world', $route->getResponseBody('/some-uri'));
    }

    public function test_route_script_response_correct(): void
    {
        $route = new Route(
            '!^/some-uri$!',
            'VERB',
            null,
            dirname(__DIR__) . '/_data/response-script.php'
        );

        $this->assertStringContainsString('response-script', $route->getResponseBody('/some-uri'));
    }
}
