<?php
// Request.php - Represents the http request received by the Server

declare (strict_types=1);

namespace MockServer;

class Request
{
    private string $uri;
    private array  $query;
    private array  $headers;
    private string $body;


    public function __construct(
        string $uri,
        array $headers = [],
        string $body = '',
        array $query = []
    ) {
        $this->uri     = $uri;
        $this->headers = $headers;
        $this->body    = $body;
        $this->query   = $query;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
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
