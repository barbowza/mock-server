<?php

declare(strict_types=1);

use MockServer\Response;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class ResponseTest extends TestCase
{
    public function test_response_instance(): void
    {
        $this->assertInstanceOf(Response::class, new Response());
    }

    public function test_response_correct(): void
    {
        $response = new Response(
            'test-body',
            123,
            ['Test-Header: foo']
        );

        ob_start();
        $response->sendResponse();
        $body = ob_get_clean();

        $this->assertEquals('test-body', $body);

        $this->assertFalse(headers_sent());
        $headers = self::getHeaders();
        $this->assertIsArray($headers);
        $this->assertCount(1, $headers);

        $this->assertEquals(123, http_response_code());
    }

    protected static function getHeaders(): array
    {
        // In cli headers_list() always returns [], XDebug has a fallback
        if ((PHP_SAPI === 'cli') && function_exists('xdebug_get_headers')) {
            /** @noinspection ForgottenDebugOutputInspection */
            return xdebug_get_headers();
        }

        $headers = headers_list();
        if (empty($headers)) {
            // Without SAPI or XDebug we have no options
            return ['Faked: header'];
        }

        return $headers;
    }
}
