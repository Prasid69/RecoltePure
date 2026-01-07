<?php
// Lightweight .env loader to avoid hardcoding secrets
if (!function_exists('loadEnv')) {
    function loadEnv(string $path): void {
        if (!is_file($path)) {
            return;
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $trimmed = trim($line);
            if ($trimmed === '' || str_starts_with($trimmed, '#')) {
                continue;
            }
            $parts = explode('=', $trimmed, 2);
            if (count($parts) !== 2) {
                continue;
            }
            [$name, $value] = $parts;
            $name = trim($name);
            $value = trim($value);
            $value = trim($value, "'\"");
            putenv("{$name}={$value}");
            $_ENV[$name] = $value;
        }
    }
}

if (!function_exists('env')) {
    function env(string $key, $default = null) {
        $value = getenv($key);
        return ($value === false) ? $default : $value;
    }
}

// Auto-load project root .env
$defaultEnvPath = dirname(__DIR__) . '/.env';
loadEnv($defaultEnvPath);
