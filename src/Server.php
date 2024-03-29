<?php
// Server.php - The top of the tree

declare (strict_types=1);

namespace MockServer;

use Psr\Log\LoggerInterface;
use RuntimeException;

class Server
{
    public const VERSION = '1.1.0';

    private Router $router;

    private ?LoggerInterface $logger;

    public function __construct(Router $router, ?LoggerInterface $logger = null)
    {
        $this->router = $router;
        $this->logger = $logger;
    }

    public function handleRequest(Request $request): Response
    {
        try {
            if (is_null($response = $this->router->execute($request))) {
                $response = new Response(
                    'Unmatched uri: ' . $request->getUri(),
                    Response::HTTP_NOT_FOUND
                );
                $this->logInfo((string)$response);
            }
        } catch (RuntimeException $e) {
            $response = new Response(
                'Server exception: ' . $e->getFile() . ' ' . $request->getMethod() . ' ' . $request->getUri() . ' ' . trim($request->getBody()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
            $this->logInfo((string)$response);
        }

        return $response;
    }

    /**
     * Get everything required to describe the Request from php
     * @return Request
     */
    public static function getRequest(): Request
    {
        $parsed  = parse_url($_SERVER['REQUEST_URI']);
        $uri     = $parsed['path'] ?? 'no-path';
        $method  = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $headers = self::getHeaders();
        $body    = self::getBody();
        parse_str($parsed['query'] ?? '', $query);

        return new Request($uri, $method, $headers, $body, $query);
    }

    public static function createContext(Request $request, Route $route): RequestContext
    {
        return new RequestContext($request, $route);
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
