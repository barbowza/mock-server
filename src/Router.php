<?php
// Router - Based on the genius [14 line router by moagrius](https://github.com/moagrius/RegexRouter)

declare (strict_types=1);

namespace MockServer;

use Psr\Log\LoggerInterface;

class Router
{
    private array $routes;

    private ?LoggerInterface $logger;

    public function __construct(?LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    public function addRoute(Route $route): void
    {
        $this->routes[$route->getUriRegex()] = $route;
    }

    public function execute(Request $request): ?string
    {
        $uri = $request->getUri();

        /**
         * @var string $pattern
         * @var Route $route
         */
        foreach ($this->routes as $pattern => $route) {
            if (preg_match($pattern, $uri, $matches) === 1) {
                $this->logInfo('Router matched:' . $matches[0]);
                return $route->getResponse($request);
            }
        }
        return null;
    }

    private function logInfo(string $message): void
    {
        if ($this->logger) {
            $this->logger->info($message);
        }
    }
}
