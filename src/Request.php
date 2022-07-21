<?php
// Request.php - Represents the http request received by the Server

declare (strict_types=1);

namespace MockServer;

class Request
{
    private string $uri;
    private array  $headers;
    private string $body;
    private array  $query;
    private string $verb;

    /**
     * @param string $uri
     * @param array $headers
     * @param string $body
     * @param array $query
     * @param string $verb
     */
    public function __construct(
        string $uri,
        array $headers = [],
        string $body = '',
        array $query = [],
        string $verb = ''
    ) {
        $this->uri     = $uri;
        $this->headers = $headers;
        $this->body    = $body;
        $this->query   = $query;
        $this->verb   = $verb;
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

    public function getVerb(): string
    {
        return $this->verb;
    }
}
