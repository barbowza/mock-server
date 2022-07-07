<?php

declare(strict_types=1);

use MockServer\Request;
use MockServer\Route;
use MockServer\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function test_router_matches_route(): void
    {
        $router = new Router();
        $router->addRoute(new Route(
            '!^/some-path$!',
            '*',
            'some-response'
        ));

        $this->assertNull($router->execute(new Request('no-match')));

        $this->assertEquals('some-response', $router->execute(new Request('/some-path')));
    }


    public function test_router_passes_url_params(): void
    {
        $router = new Router();
        $router->addRoute(new Route(
            '!^/path/with/params/(\d+)/(\w+)$!',
            '*',
            'some-response {{\1}} {{\2}}'
        ));
        # TODO test params appear in response
        $this->assertStringContainsString('some-response', $router->execute(new Request('/path/with/params/123/four')));
    }
}
