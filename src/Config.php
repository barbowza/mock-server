<?php
// Config.php - Parser for routes config

declare(strict_types=1);

namespace MockServer;

use RuntimeException;

class Config
{
    private const DEFAULT_CONFIG_DIR = __DIR__ . '/../config';
    private const DEFAULT_FILENAME = 'default.php';

    private const TOKEN_ROUTES = 'routes';
    private const TOKEN_URI_REGEX = 'uri';
    private const TOKEN_VERB = 'verb';
    private const TOKEN_RESPONSE = 'response';
    private const TOKEN_STATIC_DATA = 'static-data';
    private const TOKEN_SCRIPT_FILE = 'script-file';

    private string $configPath;

    public function __construct(string $configPath = self::DEFAULT_CONFIG_DIR)
    {
        if ($path = realpath($configPath)) {
            $this->configPath = $path;
        } else {
            throw new RuntimeException("CONFIG file not found at $configPath");
        }
    }

    public function getRoutes(): ?array
    {
        $config = self::LoadConfigsFromDir($this->configPath);

        if (empty($config) || is_null($configRoutes = ($config[self::TOKEN_ROUTES] ?? null))) {
            throw new RuntimeException("DEFAULT CONFIG file not found at " . $this->configPath . '/' . self::DEFAULT_FILENAME);
        }

        $defaults = array_fill_keys(
            [self::TOKEN_URI_REGEX, self::TOKEN_VERB, self::TOKEN_RESPONSE, self::TOKEN_STATIC_DATA, self::TOKEN_SCRIPT_FILE],
            null
        );

        foreach ($configRoutes as $route) {
            [self::TOKEN_URI_REGEX      => $uri,
             self::TOKEN_VERB     => $verb,
             self::TOKEN_RESPONSE => $response] = $route + $defaults;

            /** @noinspection DisconnectedForeachInstructionInspection */
            [self::TOKEN_STATIC_DATA => $staticData,
             self::TOKEN_SCRIPT_FILE => $scriptFile] = ($response ?? []) + $defaults;

            if ($scriptFile) {
                $scriptFile = realpath($this->configPath . "/$scriptFile") ?: null;
            }

            $routes[] = new Route($uri, $verb, $staticData, $scriptFile);
        }
        return $routes ?? null;
    }

    private static function LoadConfigFromPhp(?string $filePath): ?array
    {
        if (is_null($filePath) || false === ($path = realpath($filePath))) {
            return null;
        }

        return require($path);
    }

    private static function LoadConfigsFromDir(?string $configPath): array
    {
        $files = [self::DEFAULT_FILENAME]; #TODO glob php files from dir

        $configs = [];
        foreach ($files as $filename) {
            $configs[$filename] = self::LoadConfigFromPhp($configPath . "/$filename");
        }

        #TODO merge arrays to single config, with default lowest priority

        return $configs[self::DEFAULT_FILENAME];
    }
}
