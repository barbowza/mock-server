<?php

declare(strict_types=1);

use MockServer\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function test_request_instance(): void
    {
        $request = new Request(
            '/some-path',
        );
        $this->assertInstanceOf(Request::class, $request);
    }

    public function test_request_uri(): void
    {
        $request = new Request(
            '/some-path',
            ["Accept" => "*/*"],
            'some-body'
        );
        $this->assertInstanceOf(Request::class, $request);

        $this->assertEquals('/some-path', $request->getUri());
    }

}
