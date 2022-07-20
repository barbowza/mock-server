<?php
// Route.php - Route description

declare(strict_types=1);

namespace MockServer;

class Route
{
    private ?string $uriRegex;
    private ?string $verb;

    private ?string $staticResponse;
    private ?string $scriptPath;

    public function __construct(
        ?string $uriRegex,
        ?string $verb,
        ?string $staticResponse,
        ?string $scriptPath = null
    ) {
        $this->uriRegex = $uriRegex;
        $this->verb     = $verb;

        $this->staticResponse = $staticResponse;
        $this->scriptPath     = $scriptPath;
    }

    public function getResponse(RequestContext $context): Response
    {
        $response = new Response('no response');

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

    public function getVerb(): ?string
    {
        return $this->verb;
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
