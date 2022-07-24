<?php
// Route.php - Route description

declare(strict_types=1);

namespace MockServer;

class Route
{
    private ?string $uriRegex;
    private array $methods;

    private ?string $staticResponse;
    private ?string $scriptPath;

    private array $responseHeaders;

    /**
     * @param string|null $uriRegex
     * @param string|null $methods comma separated list of request methods permitted for route or '*' for all
     * @param string|null $staticResponse
     * @param string|null $scriptPath
     * @param string[] $responseHeaders
     */
    public function __construct(
        string $uriRegex,
        ?string $methods = null,
        ?string $staticResponse = null,
        ?string $scriptPath = null,
        array $responseHeaders = []
    ) {
        $this->uriRegex = $uriRegex;
        $this->methods  = explode(',', str_replace(' ', '', $methods ?? '*'));

        $this->staticResponse = $staticResponse;
        $this->scriptPath     = $scriptPath;

        $this->responseHeaders = $responseHeaders;
    }

    public function getResponse(RequestContext $context): Response
    {
        $response = new Response();

        foreach($this->responseHeaders as $header) {
            $response->addHeader($header);
        }

        if ($this->scriptPath) {
            return $this->executeScript($context, $response);
        }

        if ($this->staticResponse) {
            $response->setBody($this->staticResponse);
        }

        return $response;
    }

    public function getUriRegex(): ?string
    {
        return $this->uriRegex;
    }

    public function getMethods(): ?string
    {
        return implode(', ', $this->methods);
    }

    public function isPermittedMethod($method): bool
    {
        return !empty(array_intersect(['*', $method], $this->methods));
    }

    public function getHeaders(): array
    {
        return $this->responseHeaders;
    }

    /**
     * @param RequestContext $context Block of information silently passed to included Script
     * @param Response $response Response to be populated and returned by script
     * @return Response
     * @noinspection PhpUnusedParameterInspection
     */
    private function executeScript(RequestContext $context, Response $response): Response
    {
        $path = realpath($this->scriptPath);
        if ($path) {
            return include $path;
        }
        return $response;
    }
}
