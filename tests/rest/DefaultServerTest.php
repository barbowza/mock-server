<?php /** @noinspection ALL */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class DefaultServerTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost:8765/']);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public function test_default_root(): void
    {
        $response = $this->http->request('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertMatchesRegularExpression('/default response/', $response->getBody()->getContents());
    }
}
