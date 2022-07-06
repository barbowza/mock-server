<?php
// Config.php - Parser for routes config

declare(strict_types=1);

namespace MockServer;

use RuntimeException;

class Config
{
    private ?string $configPath;

    /**
     * 
     * @param string $configPath path
     * @return void 
     */
    public function __construct(string $configPath)
    {
        if(false === ($path = realpath($configPath))) {
            throw new RuntimeException("CONFIG file not found at $configPath");
        }

        $this->configPath = $path;
    }

    public function getRoutes(): ?array
    {
        $config = $this->LoadConfigFromPhp();

        if (is_null($configRoutes = $config['routes'] ?? null)) {
            return null;
        }

        foreach ($configRoutes as $route) {
            $routes[] = [
                "path" => $route['path'] ?? '/misconfigured-routes',
                "verb" => $routes['verb'] ?? '*',
                "response" => $route['response'] ?? 'misconfigured-response',
            ];
        }
        return $routes ?? null;
    }

    private function LoadConfigFromPhp(): array
    {
        return require($this->configPath);
    }
}
