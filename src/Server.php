<?php
// Server.php - The top of the tree

declare (strict_types=1);

namespace MockServer;

use Psr\Log\LoggerInterface;

class Server
{
    private Router $router;

    private ?LoggerInterface $logger;

    public function __construct(Router $router, ?LoggerInterface $logger = null)
    {
        $this->router = $router;
        $this->logger = $logger;
    }

    public function handleRequest(Request $request): ?string
    {
        if (is_null($response = $this->router->execute($request))) {
            $response = '404 mock-server did not match uri: ' . $request->getUri();
            $this->logInfo($response);
        }
        return $response;
    }

    /**
     * Get everything required to describe the Request from php
     * @return Request
     */
    public static function getRequest(): Request
    {
        $parsed = parse_url($_SERVER['REQUEST_URI']);
        $uri    = $parsed['path'] ?? 'no-path';
        parse_str($parsed['query'] ?? '', $query);
        $headers = self::getHeaders();
        $body    = self::getBody();

        return new Request($uri, $headers, $body, $query);
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

    private static function getBody(): ?string
    {
        return file_get_contents("php://input");
    }

    private function logInfo(string $message): void
    {
        if ($this->logger) {
            $this->logger->info($message);
        }
    }
}
