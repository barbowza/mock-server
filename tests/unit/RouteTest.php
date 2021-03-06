<?php

declare(strict_types=1);

use MockServer\Request;
use MockServer\RequestContext;
use MockServer\Route;
use MockServer\Server;
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

        $this->assertStringContainsString('hello world', (string)$route->getResponse($this->getRequestContext()));
    }

    public function test_route_script_response_correct(): void
    {
        $route = new Route(
            '!^/some-uri$!',
            'VERB',
            null,
            dirname(__DIR__) . '/_data/config-default/response-script.php'
        );

        $this->assertStringContainsString('response-script', (string)$route->getResponse($this->getRequestContext()));
    }

    public function test_route_accepts_headers(): void
    {
        $route = new Route(
            '!^/some-uri$!',
            'VERB',
            'some static response',
            null,
            ['X-Some: custom-header']
        );

        $this->assertStringContainsString(
            'custom-header',
            $route->getHeaders()[0]);
    }

    protected function getRequestContext(): RequestContext
    {
        return Server::createContext(new Request('/some-uri'));
    }
}
