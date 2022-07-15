<?php
// index.php - The Driver
declare(strict_types=1);

namespace MockServer;

require '../vendor/autoload.php';

$config = new Config();

$router = new Router();
foreach ($config->getRoutes() as $route) {
    $router->addRoute($route);
}

$server  = new Server($router);
$request = Server::getRequest();

echo $server->handleRequest($request);
