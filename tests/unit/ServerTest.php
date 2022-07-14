<?php

declare(strict_types=1);

use MockServer\Request;
use MockServer\Router;
use MockServer\Server;
use PHPUnit\Framework\TestCase;

class ServerTest extends TestCase
{
    public function test_server_instance(): void
    {
        /** @var Router $mockRouter */
        $mockRouter = $this->createStub(Router::class);

        $server =  new Server($mockRouter);

        $this->assertInstanceOf(Server::class, $server);
    }

    public function test_server_handleRequest(): void
    {
        /** @var Router $mockRouter */
        $mockRouter = $this->createStub(Router::class);

        $server = new Server($mockRouter);

        $request = new Request('/some/path');
        $this->assertNull($server->handleRequest($request));
    }
}
