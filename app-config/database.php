<?php

require_once __DIR__ . '/env.php';

// Supports both local .env (DB_HOST etc.) and Railway MySQL plugin vars (MYSQLHOST etc.)
defined('DB_HOST') || define('DB_HOST', (string) (coir_env('DB_HOST') ?? coir_env('MYSQLHOST', '127.0.0.1')));
defined('DB_PORT') || define('DB_PORT', (string) (coir_env('DB_PORT') ?? coir_env('MYSQLPORT', '3306')));
defined('DB_NAME') || define('DB_NAME', (string) (coir_env('DB_DATABASE') ?? coir_env('MYSQLDATABASE', 'coir_roots_db')));
defined('DB_USER') || define('DB_USER', (string) (coir_env('DB_USERNAME') ?? coir_env('MYSQLUSER', 'root')));
defined('DB_PASS') || define('DB_PASS', (string) (coir_env('DB_PASSWORD') ?? coir_env('MYSQLPASSWORD', '')));
defined('DB_CHARSET') || define('DB_CHARSET', 'utf8mb4');
