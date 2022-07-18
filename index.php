<?php
// index.php - The Driver
declare(strict_types=1);

namespace MockServer;

require 'vendor/autoload.php';

use Analog\Logger;
use Analog\Handler\Stderr;

$logger = new Logger();
$logger->handler(Stderr::init());

$config = new Config($logger);

$router = new Router($logger);
foreach ($config->getRoutes() as $route) {
    $router->addRoute($route);
}

$server  = new Server($router, $logger);
$request = Server::getRequest();

echo $server->handleRequest($request);

