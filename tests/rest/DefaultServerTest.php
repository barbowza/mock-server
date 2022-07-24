<?php /** @noinspection ALL */

declare(strict_types=1);

use GuzzleHttp\Exception\ClientException;
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
        $this->assertArrayHasKey('request.query', $response['context']);
        $this->assertEquals(['a' => 'b'], $response['context']['request.query']);

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
        $this->assertArrayHasKey('request.body', $response['context']);
        $this->assertEquals('"{\"key\": \"val\", \"num\": 2}"', $response['context']['request.body']);
    }

    public function test_method_any_allows_all_supported(): void
    {
        $response = $this->http->request('GET', '/mock-server');
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->http->request('HEAD', '/mock-server');
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->http->request('POST', '/mock-server');
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->http->request('PUT', '/mock-server');
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->http->request('DELETE', '/mock-server');
        $this->assertEquals(200, $response->getStatusCode());

        // CONNECT not supported

        $response = $this->http->request('OPTIONS', '/mock-server');
        $this->assertEquals(200, $response->getStatusCode());

        // TRACE not supported
    }

    public function test_method_mismatch_responds_405(): void
    {
        $this->expectException(ClientException::class);
        $response = $this->http->request('DELETE', '/mock-server/status');

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertStringContainsString('Allow: GET', implode(' ', $response->getHeaders()));

    }
}
