<?php
// Router - Based on the genius [14 line router by moagrius](https://github.com/moagrius/RegexRouter)

declare (strict_types=1);

namespace MockServer;

class Router
{
    private array $routes;

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
            if (preg_match($pattern, $uri, $params) === 1) {
                array_shift($params);
                return $route->getResponseBody($uri);
            }
        }
        return null;
    }
}
