<?php
// Config.php - Parser for routes config

declare(strict_types=1);

namespace MockServer;

use Psr\Log\LoggerInterface;
use RuntimeException;

class Config
{
    public const DEFAULT_CONFIG_DIR = __DIR__ . '/../config';

    public const CONFIG_GLOB = '/*.config.php';

    /** Flag used to indicate file is a config */
    public const MOCK_SERVER_CONFIG = 'mock-server-config';

    public const TOKEN_ROUTES = 'routes';
    public const TOKEN_URI_REGEX = 'uri';
    public const TOKEN_VERB = 'verb';
    public const TOKEN_RESPONSE = 'response';
    public const TOKEN_STATIC_DATA = 'static-data';
    public const TOKEN_SCRIPT_FILE = 'script-file';
    public const TOKEN_HEADERS = 'headers';

    private ?LoggerInterface $logger;

    private string $configDir;
    private ?array $config = null;

    public function __construct(?LoggerInterface $logger = null, string $configDir = self::DEFAULT_CONFIG_DIR)
    {
        $this->logger = $logger;

        if ($dir = realpath($configDir)) {
            $this->configDir = $dir;
        } else {
            throw new RuntimeException("CONFIG file not found at $configDir");
        }
    }

    public function getRoutes(): ?array
    {
        $config = $this->getConfig();

        $defaults = array_fill_keys(
            [self::TOKEN_URI_REGEX, self::TOKEN_VERB, self::TOKEN_RESPONSE, self::TOKEN_STATIC_DATA, self::TOKEN_SCRIPT_FILE],
            null
        );
        $defaults[self::TOKEN_HEADERS] = [];

        foreach ($config['routes'] as $route) {
            [
                self::TOKEN_URI_REGEX => $uri,
                self::TOKEN_VERB      => $verb,
                self::TOKEN_RESPONSE  => $response,
            ] = $route + $defaults;

            [
                self::TOKEN_STATIC_DATA => $staticData,
                self::TOKEN_SCRIPT_FILE => $scriptFile,
                self::TOKEN_HEADERS => $headers,
            ] = ($response ?? []) + $defaults;

            if ($scriptFile) {
                $scriptFile = realpath($this->configDir . "/{$scriptFile}") ?: null;
            }

            $routes[] = new Route($uri, $verb, $staticData, $scriptFile, $headers);
        }
        return $routes ?? null;
    }

    private function getConfig(): array
    {
        if (!is_null($this->config)) {
            return $this->config;
        }

        return $this->config = $this->LoadFromConfigDir();
    }

    private function LoadFromConfigDir(): array
    {
        $files = glob($this->configDir . self::CONFIG_GLOB);

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
            $msg = "NO ROUTES FOUND in config at " . $this->configDir;
            $this->logAlert($msg);
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

    /**
     * Provide an emergency fallback route for when no routes found in any config file
     * @param string $msg
     * @return array[]
     */
    private static function fallbackRoutesConfig(string $msg = 'fallback response'): array
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

    private function logAlert(string $message): void
    {
        if ($this->logger) {
            $this->logger->alert($message);
        }
    }
}
