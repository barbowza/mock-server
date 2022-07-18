<?php
// Config.php - Parser for routes config

declare(strict_types=1);

namespace MockServer;

use RuntimeException;

class Config
{
    private const DEFAULT_CONFIG_DIR = __DIR__ . '/../config';

    /** Flag used in file as being a config */
    private const MOCK_SERVER_CONFIG = 'mock-server-config';

    private const TOKEN_ROUTES = 'routes';
    private const TOKEN_URI_REGEX = 'uri';
    private const TOKEN_VERB = 'verb';
    private const TOKEN_RESPONSE = 'response';
    private const TOKEN_STATIC_DATA = 'static-data';
    private const TOKEN_SCRIPT_FILE = 'script-file';

    private string $configPath;
    private ?array $config = null;

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
        $config = $this->getConfig();

        $defaults = array_fill_keys(
            [self::TOKEN_URI_REGEX, self::TOKEN_VERB, self::TOKEN_RESPONSE, self::TOKEN_STATIC_DATA, self::TOKEN_SCRIPT_FILE],
            null
        );

        foreach ($config['routes'] as $route) {
            [
                self::TOKEN_URI_REGEX => $uri,
                self::TOKEN_VERB      => $verb,
                self::TOKEN_RESPONSE  => $response
            ] = $route + $defaults;

            /** @noinspection DisconnectedForeachInstructionInspection */
            [
                self::TOKEN_STATIC_DATA => $staticData,
                self::TOKEN_SCRIPT_FILE => $scriptFile
            ] = ($response ?? []) + $defaults;

            if ($scriptFile) {
                $scriptFile = realpath($this->configPath . "/$scriptFile") ?: null;
            }

            $routes[] = new Route($uri, $verb, $staticData, $scriptFile);
        }
        return $routes ?? null;
    }

    private function getConfig(): array
    {
        if (!is_null($this->config)) {
            return $this->config;
        }

        return $this->config = self::LoadFromConfigDir($this->configPath);
    }

    private static function LoadFromConfigDir(?string $configPath): array
    {
        $files = glob($configPath . '/' . '*.config.php');

        $routes = [];
        foreach ($files as $filename) {
            $config = include $filename;
            if (is_array($config) && self::isConfig($config)) {
                if (isset($config[self::TOKEN_ROUTES]) && is_array($config[self::TOKEN_ROUTES])) {
                    $routes = [...$routes, ...$config[self::TOKEN_ROUTES]];
                }
            }
        }

        if (empty($routes)) {
            $msg = "NO ROUTES FOUND in config at " . $configPath;
            error_log($msg);
            $routes = self::fallbackRoutesConfig($msg);
        }

        return [
            self::TOKEN_ROUTES => $routes
        ];
    }

    private static function isConfig(array $config): bool
    {
        if (isset($config[self::MOCK_SERVER_CONFIG])) {
            return true;
        }
        return false;
    }

    private static function fallbackRoutesConfig($msg): array
    {
        return [
            [
                self::TOKEN_URI_REGEX => '!.*!i',
                self::TOKEN_VERB      => 'GET',
                self::TOKEN_RESPONSE  => [
                    self::TOKEN_STATIC_DATA => $msg,
                ]
            ]
        ];
    }
}
