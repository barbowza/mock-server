<?php /** @noinspection ALL */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as GuzzleClient;

class DefaultServerTest extends TestCase
{
    private ?GuzzleClient $http;

    public function setUp(): void
    {
        $this->http = new GuzzleClient(['base_uri' => 'http://localhost:8765']);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public function test_default_root_static_response(): void
    {
        $response = $this->http->request('GET', '/mock-server');

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertStringContainsString('Operational', $response->getBody()->getContents());

        $this->assertStringContainsString('json', $response->getHeader('Content-Type')[0]);
    }

    public function test_default_status_dynamic_response(): void
    {
        $response = $this->http->request('GET', '/mock-server/status');

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertStringContainsString('Operational', $response->getBody()->getContents());
    }

    public function test_reflect_get(): void
    {
        $response = $this->http->request('GET', '/mock-server/reflect?a=b');

        $this->assertEquals(200, $response->getStatusCode());

        $response = json_decode($response->getBody()->getContents(), true);

        $this->assertArrayHasKey('timestamp', $response);

        $this->assertArrayHasKey('context', $response);
        $this->assertArrayHasKey('query', $response['context']);
        $this->assertEquals(['a' => 'b'], $response['context']['query']);

        $this->assertArrayHasKey('$_GET', $response);
    }

    public function test_reflect_post(): void
    {
        $response = $this->http->request(
            'POST',
            '/mock-server/reflect',
            [
                'json' => '{"key": "val", "num": 2}'
            ]
        );

        $this->assertEquals(200, $response->getStatusCode());

        $response = json_decode($a = $response->getBody()->getContents(), true);

        $this->assertArrayHasKey('timestamp', $response);

        $this->assertArrayHasKey('context', $response);
        $this->assertArrayHasKey('body', $response['context']);
        $this->assertEquals('"{\"key\": \"val\", \"num\": 2}"', $response['context']['body']);
    }
}
