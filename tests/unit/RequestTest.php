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
            '/some-path'
        );

        $this->assertEquals('/some-path', $request->getUri());
    }

    public function test_request_query(): void
    {
        $request = new Request(
            '/some-path',
            ["Accept" => "*/*"],
            'some-body',
            ['param1' => 'some-value']
        );

        $this->assertEquals(['param1' => 'some-value'], $request->getQuery());
    }

    public function test_request_verb(): void
    {
        $request = new Request(
            '/some-path',
            ["Accept" => "*/*"],
            'some-body',
            ['param1' => 'some-value'],
            'VERB'
        );

        $this->assertEquals('VERB', $request->getVerb());
    }

}
