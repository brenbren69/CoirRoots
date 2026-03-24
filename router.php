<?php
/**
 * PHP built-in server router for Railway deployment.
 * Serves static files directly; routes everything else through index.php.
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve existing static files (css, js, images, etc.) directly
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Everything else goes through the main app
require_once __DIR__ . '/index.php';
