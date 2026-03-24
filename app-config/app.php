<?php

require_once __DIR__ . '/env.php';

defined('APP_NAME') || define('APP_NAME', (string) coir_env('APP_NAME', 'Coir Roots'));
defined('APP_URL') || define('APP_URL', (string) coir_env('APP_URL', 'http://localhost/Coir-Roots'));
defined('APP_VERSION') || define('APP_VERSION', '1.0.0');
defined('SHIPPING_FEE') || define('SHIPPING_FEE', 150.00);
defined('FREE_SHIPPING_THRESHOLD') || define('FREE_SHIPPING_THRESHOLD', 2000.00);
