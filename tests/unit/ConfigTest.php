<?php

declare(strict_types=1);

use MockServer\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    protected const PATH_CONFIG_DEFAULT = __DIR__ . '/../_data/config-default.php';
    protected const PATH_CONFIG_NO_ROUTES = __DIR__ . '/../_data/config-no-routes.php';

    public function setUp(): void
    {
    }

    public function test_can_load_routes_from_config_with_routes(): void
    {
        $config = new Config(self::PATH_CONFIG_DEFAULT);

        $routes = $config->getRoutes();

        $this->assertIsArray($routes);

        $this->assertIsArray($routes[0]);
        $this->assertArrayHasKey('path', $routes[0]);
    }

    public function test_handles_config_without_routes(): void
    {
        $config = new Config(self::PATH_CONFIG_NO_ROUTES);

        $this->assertNull($config->getRoutes());
    }
}
