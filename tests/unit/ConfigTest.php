<?php

declare(strict_types=1);

use MockServer\Config;
use MockServer\Route;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    protected const PATH_CONFIG_DEFAULT = __DIR__   . '/../_data/config-default';
    protected const PATH_CONFIG_NO_ROUTES = __DIR__ . '/../_data/config-no-routes';

    public function test_constructor_throws_on_bad_path(): void
    {
        $this->expectException(RuntimeException::class);
        new Config('/not/a/real/path');
    }

    public function test_can_load_routes_from_config_with_routes(): void
    {
        $config = new Config(self::PATH_CONFIG_DEFAULT);

        /** @var Route[] $routes */
        $routes = $config->getRoutes();

        $this->assertIsArray($routes);
        $this->assertCount(3, $routes);

        $this->assertInstanceOf(Route::class, $routes[0]);

        $this->assertStringContainsString('hello', $routes[0]->getUriRegex());
        $this->assertStringContainsString('param', $routes[1]->getUriRegex());
        $this->assertStringContainsString('dynamic', $routes[2]->getUriRegex());
    }

    public function test_config_getRoutes_without_routes_throws(): void
    {
        $config = new Config(self::PATH_CONFIG_NO_ROUTES);

        $this->expectException(RuntimeException::class);

        $config->getRoutes();
    }

    public function test_no_config_file_uses_defaults(): void
    {
        $this->assertIsArray((new Config())->getRoutes());
    }
}
