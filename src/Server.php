<?php
// Server.php - The top of the tree

declare (strict_types=1);

namespace MockServer;

class Server
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handleRequest(Request $request): ?string
    {
        return $this->router->execute($request);
    }

    public static function getRequest(): Request
    {
        $uri = $_SERVER['REQUEST_URI'];
        $headers = self::getHeaders();
        return new Request($uri, $headers);
    }

    private static function getHeaders(): array
    {
        // https://stackoverflow.com/a/11709337
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headers[str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
            }
        }
        return $headers;
    }
}