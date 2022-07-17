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

    /**
     * getResponse is passed the Request so it can build a context to pass to script
     *
     * @param Request $request
     * @return string
     */
    public function getResponse(Request $request): string
    {
        if (!is_null($this->scriptPath)) {
            return $this->executeScript($this->createContext($request)) ?? 'no response';
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

    private function executeScript(array $context): ?string
    {
        $path = realpath($this->scriptPath);
        if ($path) {
            return include $path;
        }
        return null;
    }

    private function createContext(Request $request): array
    {
        return [
            'uri' => $request->getUri()
        ];
    }
}