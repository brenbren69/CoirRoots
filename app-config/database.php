<?php

require_once __DIR__ . '/env.php';

// Parse MYSQL_URL if Railway provides a connection string
$_coirMysqlUrl = coir_env('MYSQL_URL') ?? coir_env('DATABASE_URL');
$_coirUrlParts = $_coirMysqlUrl ? parse_url($_coirMysqlUrl) : [];

// Supports: local .env, Railway individual vars (MYSQLHOST etc.), Railway MYSQL_URL
defined('DB_HOST') || define('DB_HOST', (string) (coir_env('DB_HOST') ?? coir_env('MYSQLHOST') ?? coir_env('MYSQL_HOST') ?? ($_coirUrlParts['host'] ?? '127.0.0.1')));
defined('DB_PORT') || define('DB_PORT', (string) (coir_env('DB_PORT') ?? coir_env('MYSQLPORT') ?? coir_env('MYSQL_PORT') ?? ($_coirUrlParts['port'] ?? '3306')));
defined('DB_NAME') || define('DB_NAME', (string) (coir_env('DB_DATABASE') ?? coir_env('MYSQLDATABASE') ?? coir_env('MYSQL_DATABASE') ?? ltrim($_coirUrlParts['path'] ?? 'coir_roots_db', '/')));
defined('DB_USER') || define('DB_USER', (string) (coir_env('DB_USERNAME') ?? coir_env('MYSQLUSER') ?? coir_env('MYSQL_USER') ?? ($_coirUrlParts['user'] ?? 'root')));
defined('DB_PASS') || define('DB_PASS', (string) (coir_env('DB_PASSWORD') ?? coir_env('MYSQLPASSWORD') ?? coir_env('MYSQL_PASSWORD') ?? ($_coirUrlParts['pass'] ?? '')));
unset($_coirMysqlUrl, $_coirUrlParts);
defined('DB_CHARSET') || define('DB_CHARSET', 'utf8mb4');
