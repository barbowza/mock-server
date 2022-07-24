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
            'METHOD',
            'hello world'
        );

        $this->assertIsString($route->getUriRegex());
        $this->assertEquals('METHOD', $route->getMethods());

        $this->assertStringContainsString('hello world', (string)$route->getResponse($this->getRequestContext()));
    }

    public function test_route_script_response_correct(): void
    {
        $route = new Route(
            '!^/some-uri$!',
            null,
            null,
            dirname(__DIR__) . '/_data/config-default/response-script.php'
        );

        $this->assertStringContainsString('response-script', (string)$route->getResponse($this->getRequestContext()));
    }

    public function test_route_accepts_headers(): void
    {
        $route = new Route(
            '!^/some-uri$!',
            null,
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
        return Server::createContext(
            new Request('/some-uri'),
            new Route('')
        );
    }

    public function test_route_methods_contains_method(): void
    {
        $route = new Route(
            '!^/some-uri$!',
            'GET, PUT, OPTIONS'
        );

        $this->assertStringContainsString('OPTIONS', $route->getMethods());
    }

    public function test_route_methods_permitted(): void
    {
        $route = new Route(
            '!^/some-uri$!',
            'GET, POST',
        );

        $this->assertTrue($route->isPermittedMethod('GET'));
        $this->assertTrue($route->isPermittedMethod('POST'));

        $this->assertFalse($route->isPermittedMethod('DELETE'));
    }

    public function test_route_all_methods_permitted(): void
    {
        $route = new Route(
            '!^/some-uri$!',
            '*',
        );

        $this->assertTrue($route->isPermittedMethod('GET'));
        $this->assertTrue($route->isPermittedMethod('POST'));
        $this->assertTrue($route->isPermittedMethod('DELETE'));
    }
}
