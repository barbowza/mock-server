<?php
// RequestContext.php - The context of the request to info the dynamic Scripts

declare (strict_types=1);

namespace MockServer;

class RequestContext
{
    private Request $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getUri(): string
    {
        return $this->request->getUri();
    }

    public function getHeaders(): array
    {
        return $this->request->getHeaders();
    }

    public function getBody(): string
    {
        return $this->request->getBody();
    }

    public function getQuery(): array
    {
        return $this->request->getQuery();
    }

    public function toArray(): array
    {
        return [
            'uri'     => $this->getUri(),
            'headers' => $this->getHeaders(),
            'body'    => $this->getBody(),
            'query'   => $this->getQuery(),
        ];

    }
}
