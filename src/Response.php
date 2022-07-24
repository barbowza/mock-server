<?php
// Response.php - Represents a http response to be returned to Caller

declare (strict_types=1);

namespace MockServer;

class Response
{
    public const HTTP_OK = 200;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_METHOD_NOT_ALLOWED = 405;
    public const HTTP_INTERNAL_SERVER_ERROR = 500;

    private ?string $body;
    private int $code;
    private array  $headers;

    /**
     * @param ?string $body
     * @param int $code
     * @param array $headers
     */
    public function __construct(
        ?string $body = null,
        int $code = self::HTTP_OK,
        array $headers = []
    ) {
        $this->body    = $body;
        $this->code     = $code;
        $this->headers = $headers;
    }

    public function setBody(?string $body): Response
    {
        $this->body = $body;
        return $this;
    }

    public function addHeader(string $header): Response
    {
        $this->headers[] = $header;
        return $this;
    }

    public function setCode(int $code): Response
    {
        $this->code = $code;
        return $this;
    }

    public function sendResponse(): void
    {
        foreach ($this->headers as $header) {
            header($header);
        }

        http_response_code($this->code);

        if ($this->body) {
            echo $this->body;
        }
    }

    public function __toString()
    {
        return $this->code . ' ' . $this->body . ' ' . implode(', ', $this->headers);
    }
}
