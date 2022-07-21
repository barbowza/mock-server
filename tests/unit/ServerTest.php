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

    public function test_server_handleRequest_returns_404_on_path_not_matched(): void
    {
        /** @var Router $mockRouter */
        $mockRouter = $this->createStub(Router::class);

        $server = new Server($mockRouter);

        $request = new Request('/some/path/not/matched');

        $this->assertStringContainsString('404', (string)$server->handleRequest($request));
    }

    public function test_server_getResponse(): void
    {
        $_SERVER['REQUEST_URI'] = '/some/path?a=1';

        $request = Server::getRequest();

        $this->assertEquals('/some/path', $request->getUri());
        $this->assertEquals(['a' => 1], $request->getQuery());
    }

    public function test_server_error_response(): void
    {
        $mockRouter = $this->createStub(Router::class);
        $mockRouter->method('execute')
            ->willThrowException(new RuntimeException());

        /** @var Router $mockRouter */
        $server =  new Server($mockRouter);

        $this->assertStringContainsString('500', (string)$server->handleRequest(new Request('/')));
    }
}
