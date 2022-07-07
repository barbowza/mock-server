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

    public function getResponseBody(string $uri): string
    {
        if (!is_null($this->scriptPath)) {
            return $this->executeScript($uri) ?? 'no response';
        }

        return $this->staticResponse ?? 'no response';
    }

    public function getUriRegex(): ?string
    {
        return $this->uriRegex;
    }

    public function getVerb(): ?string
    {
        return $this->verb;
    }

    private function executeScript(string $uri): ?string
    {
        $path = realpath($this->scriptPath);
        if ($path) {
            $context = [
                'uri' => $uri
            ];
            include $path;
            return getResponse($context);
        }
        return null;
    }
}