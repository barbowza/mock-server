<?php
// Request.php - Represents the http request received by the Server

declare (strict_types=1);

namespace MockServer;

class Request
{
    protected string $uri;
    public array  $headers;
    public string $body;

    public function __construct(string $uri, array $headers = [], string $body = '')
    {
        $this->uri     = $uri;
        $this->headers = $headers;
        $this->body    = $body;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}
