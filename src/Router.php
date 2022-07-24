<?php
// Router - Based on the genius [14 line router by moagrius](https://github.com/moagrius/RegexRouter)

declare (strict_types=1);

namespace MockServer;

use Psr\Log\LoggerInterface;

class Router
{
    /** @var Route[] $routes */
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

    public function execute(Request $request): ?Response
    {
        /**
         * @var string $uriRegex
         * @var Route $route
         */
        foreach ($this->routes as $uriRegex => $route) {
            if (preg_match($uriRegex, $request->getUri(), $matches) === 1) {

                $this->logInfo('Router matched:' . $matches[0]);

                if ($route->isPermittedMethod($request->getMethod())) {
                    return $route->getResponse(Server::createContext($request));
                }

                return new Response(
                    '405 Method Not Allowed',
                    Response::HTTP_METHOD_NOT_ALLOWED,
                    ['Allow: ' . $route->getMethods()]
                );
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
