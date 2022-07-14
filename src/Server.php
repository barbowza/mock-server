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
}
