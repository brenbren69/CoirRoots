<?php
// Temporary debug page - DELETE after fixing DB connection
$vars = ['MYSQLHOST', 'MYSQLPORT', 'MYSQLDATABASE', 'MYSQLUSER', 'MYSQLPASSWORD',
         'MYSQL_HOST', 'MYSQL_PORT', 'MYSQL_DATABASE', 'MYSQL_USER', 'MYSQL_PASSWORD',
         'MYSQL_URL', 'DATABASE_URL', 'DB_HOST', 'DB_PORT', 'DB_NAME',
         'RAILWAY_TCP_PROXY_DOMAIN', 'RAILWAY_TCP_PROXY_PORT'];

echo "<pre style='font-family:monospace;font-size:14px;padding:20px'>";
echo "=== Environment Variables ===\n\n";
foreach ($vars as $v) {
    $val = getenv($v);
    if ($val !== false) {
        // Mask password
        if (stripos($v, 'password') !== false || stripos($v, 'url') !== false) {
            $val = substr($val, 0, 6) . '***MASKED***';
        }
        echo "$v = $val\n";
    } else {
        echo "$v = (not set)\n";
    }
}

echo "\n=== DB Connection Test ===\n\n";
$host = getenv('MYSQLHOST') ?: getenv('MYSQL_HOST') ?: '127.0.0.1';
$port = getenv('MYSQLPORT') ?: getenv('MYSQL_PORT') ?: '3306';
$db   = getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE') ?: 'railway';
$user = getenv('MYSQLUSER') ?: getenv('MYSQL_USER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: getenv('MYSQL_PASSWORD') ?: '';

echo "Connecting to: $host:$port / $db as $user\n\n";
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5,
    ]);
    echo "SUCCESS - Connected!\n";
} catch (Exception $e) {
    echo "FAILED: " . $e->getMessage() . "\n";
}
echo "</pre>";
