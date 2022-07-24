<?php
// RequestContext.php - The context of the request to info the dynamic Scripts

declare (strict_types=1);

namespace MockServer;

class RequestContext
{
    private Request $request;
    private Route   $route;

    /**
     * @param Request $request
     * @param Route $route
     */
    public function __construct(Request $request, Route $route)
    {
        $this->request = $request;
        $this->route  = $route;
    }

    public function getRequestUri(): string
    {
        return $this->request->getUri();
    }

    public function getRequestMethod(): string
    {
        return $this->request->getMethod();
    }

    public function getRequestHeaders(): array
    {
        return $this->request->getHeaders();
    }

    public function getRequestBody(): string
    {
        return $this->request->getBody();
    }

    public function getRequestQuery(): array
    {
        return $this->request->getQuery();
    }

    public function getServerVersion(): string
    {
        return Server::VERSION;
    }

    public function getRouteUriRegex(): string
    {
        return $this->route->getUriRegex();
    }

    public function getRouteMethods(): string
    {
        return $this->route->getMethods();
    }

    public function getRouteHeaders(): array
    {
        return $this->route->getHeaders();
    }

    public function toArray(): array
    {
        return [
            'request.uri'     => $this->getRequestUri(),
            'request.method'  => $this->getRequestMethod(),
            'request.headers' => $this->getRequestHeaders(),
            'request.body'    => $this->getRequestBody(),
            'request.query'   => $this->getRequestQuery(),

            'server.version' => $this->getServerVersion(),

            'route.uriRegex' => $this->getRouteUriRegex(),
            'route.methods' => $this->getRouteMethods(),
            'route.headers' => $this->getRouteHeaders(),
        ];

    }
}
