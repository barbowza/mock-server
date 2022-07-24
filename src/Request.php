<?php
// Request.php - Represents the http request received by the Server

declare (strict_types=1);

namespace MockServer;

class Request
{
    private string $uri;
    private string $method;
    private array  $headers;
    private string $body;
    private array  $query;

    /**
     * @param string $uri
     * @param ?string $method
     * @param ?array $headers
     * @param ?string $body
     * @param ?array $query
     */
    public function __construct(
        string $uri,
        ?string $method = null,
        ?array $headers = null,
        ?string $body = null,
        ?array $query = null
    ) {
        $this->uri     = $uri;
        $this->method   = $method ?? 'GET';
        $this->headers = $headers ?? [];
        $this->body    = $body ?? '';
        $this->query   = $query ?? [];
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getQuery(): array
    {
        return $this->query;
    }
}
