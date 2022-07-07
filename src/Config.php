<?php
// Config.php - Parser for routes config

declare(strict_types=1);

namespace MockServer;

use RuntimeException;

class Config
{
    private const PATH_DEFAULT_CONFIG = __DIR__ . '/../config/default.php';

    private ?string $configPath;

    public function __construct(?string $configPath = null)
    {
        if (!is_null($configPath) && false === ($path = realpath($configPath))) {
            throw new RuntimeException("CONFIG file not found at $configPath");
        }

        $this->configPath = $path ?? null;
    }

    public function getRoutes(): ?array
    {
        $config = self::LoadConfigFromPhp($this->configPath);

        if (is_null($config) || is_null($configRoutes = ($config['routes'] ?? null))) {
            $config = self::LoadConfigFromPhp(self::PATH_DEFAULT_CONFIG);

            if (is_null($config) || is_null($configRoutes = ($config['routes'] ?? null))) {
                throw new RuntimeException("DEFAULT CONFIG file not found at " . self::PATH_DEFAULT_CONFIG);
            }

        }

        foreach ($configRoutes as $route) {
            $routes[] = [
                "path"     => $route['path'] ?? null,
                "verb"     => $routes['verb'] ?? null,
                "response" => $route['response'] ?? null,
            ];
        }
        return $routes ?? null;
    }

    private static function LoadConfigFromPhp(?string $configPath): ?array
    {
        if (is_null($configPath)) {
            return null;
        }

        return require($configPath);
    }
}
