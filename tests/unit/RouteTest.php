<?php

declare(strict_types=1);

use MockServer\Request;
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

        $this->assertEquals('hello world', $route->getResponse(new Request('/some-uri')));
    }

    public function test_route_script_response_correct(): void
    {
        $route = new Route(
            '!^/some-uri$!',
            'VERB',
            null,
            dirname(__DIR__) . '/_data/config-default/response-script.php'
        );

        $this->assertStringContainsString('response-script', $route->getResponse(new Request('some-uri')));
    }
}
