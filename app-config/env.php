<?php

if (!function_exists('coir_env_load')) {
    function coir_env_load(?string $path = null): void
    {
        static $loaded = false;

        if ($loaded) {
            return;
        }

        $path ??= dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';

        if (!is_file($path) || !is_readable($path)) {
            $loaded = true;
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            if ($value !== '' && (
                (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                (str_starts_with($value, "'") && str_ends_with($value, "'"))
            )) {
                $value = substr($value, 1, -1);
            }

            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }

        $loaded = true;
    }
}

if (!function_exists('coir_env')) {
    function coir_env(string $key, mixed $default = null): mixed
    {
        coir_env_load();

        // $_ENV may be empty in PHP built-in server / Docker — use getenv() as reliable fallback
        if (isset($_ENV[$key])) return $_ENV[$key];
        $val = getenv($key);
        if ($val !== false) return $val;
        return $default;
    }
}
