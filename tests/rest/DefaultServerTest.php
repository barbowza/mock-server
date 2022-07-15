<?php /** @noinspection ALL */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class DefaultServerTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost:8765']);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public function test_default_root_static_response(): void
    {
        $response = $this->http->request('GET', '/mock-server/');

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertStringContainsString('default response', $response->getBody()->getContents());
    }

    public function test_default_status_dynamic_response(): void
    {
        $response = $this->http->request('GET', '/mock-server/status');

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertStringContainsString('dynamic response', $response->getBody()->getContents());
    }
}
