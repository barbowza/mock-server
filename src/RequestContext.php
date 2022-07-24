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

    public function getMethod(): string
    {
        return $this->request->getMethod();
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

    public function getVersion(): string
    {
        return Server::VERSION;
    }

    public function toArray(): array
    {
        return [
            'request.uri'     => $this->getUri(),
            'request.method'  => $this->getMethod(),
            'request.headers' => $this->getHeaders(),
            'request.body'    => $this->getBody(),
            'request.query'   => $this->getQuery(),

            'server.version' => $this->getVersion()
        ];

    }
}
