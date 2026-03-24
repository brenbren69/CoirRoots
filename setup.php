<?php

declare(strict_types=1);

require_once __DIR__ . '/app-config/database.php';
require_once __DIR__ . '/app-config/app.php';

function setup_output(string $message): void
{
    if (PHP_SAPI === 'cli') {
        echo $message . PHP_EOL;
        return;
    }

    echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "<br>\n";
}

function setup_heading(string $message): void
{
    if (PHP_SAPI === 'cli') {
        echo PHP_EOL . $message . PHP_EOL;
        echo str_repeat('=', strlen($message)) . PHP_EOL;
        return;
    }

    echo '<h2>' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "</h2>\n";
}

function setup_strip_comments(string $sql): string
{
    $lines = preg_split("/\r\n|\n|\r/", $sql) ?: [];
    $clean = [];

    foreach ($lines as $line) {
        $trimmed = ltrim($line);
        if (str_starts_with($trimmed, '--')) {
            continue;
        }
        $clean[] = $line;
    }

    return implode("\n", $clean);
}

function setup_run_sql_file(PDO $pdo, string $path): void
{
    if (!is_file($path)) {
        throw new RuntimeException('Missing SQL file: ' . $path);
    }

    $sql = trim(setup_strip_comments((string) file_get_contents($path)));
    if ($sql === '') {
        return;
    }

    $statements = preg_split('/;\s*(?:\r\n|\n|\r|$)/', $sql) ?: [];

    foreach ($statements as $statement) {
        $statement = trim($statement);
        if ($statement === '') {
            continue;
        }
        $pdo->exec($statement);
    }
}

function setup_admin_exists(PDO $pdo, string $email): bool
{
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);

    return (bool) $stmt->fetchColumn();
}

function setup_create_admin(PDO $pdo): void
{
    $email = 'admin@coirroots.ph';

    if (setup_admin_exists($pdo, $email)) {
        setup_output('Admin account already exists: ' . $email);
        return;
    }

    $stmt = $pdo->prepare(
        'INSERT INTO users (name, email, password, mobile, address, role, created_at, updated_at)
         VALUES (:name, :email, :password, :mobile, :address, :role, NOW(), NOW())'
    );

    $stmt->execute([
        ':name' => 'Coir Roots Admin',
        ':email' => $email,
        ':password' => password_hash('Admin@123', PASSWORD_DEFAULT),
        ':mobile' => '09171234567',
        ':address' => 'Naga City, Camarines Sur, Philippines',
        ':role' => 'seller',
    ]);

    setup_output('Created seller account: admin@coirroots.ph / Admin@123');
}

function setup_table_has_rows(PDO $pdo, string $table): bool
{
    $stmt = $pdo->query('SELECT COUNT(*) FROM `' . $table . '`');
    return (int) $stmt->fetchColumn() > 0;
}

if (PHP_SAPI !== 'cli') {
    session_start();
    echo "<!doctype html><html><head><meta charset=\"utf-8\"><title>Coir Roots Setup</title>";
    echo "<style>body{font-family:Arial,sans-serif;background:#f6f2e8;color:#2d2418;max-width:780px;margin:40px auto;padding:0 20px;line-height:1.6}code{background:#efe5d1;padding:2px 6px;border-radius:4px}</style>";
    echo "</head><body>";
    echo '<h1>Coir Roots Setup</h1>';
}

try {
    setup_heading('Connecting to MySQL');

    $serverDsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=' . DB_CHARSET;
    $pdo = new PDO($serverDsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    setup_output('Connected to MySQL at ' . DB_HOST . ':' . DB_PORT);

    setup_heading('Importing schema');
    setup_run_sql_file($pdo, __DIR__ . '/database/schema.sql');
    setup_output('Schema import completed for database `' . DB_NAME . '`.');

    $appDsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    $appPdo = new PDO($appDsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    setup_heading('Importing seed data');
    if (setup_table_has_rows($appPdo, 'categories') || setup_table_has_rows($appPdo, 'products')) {
        setup_output('Seed data already exists. Skipping import.');
    } else {
        setup_run_sql_file($pdo, __DIR__ . '/database/seed.sql');
        setup_output('Seed data import completed.');
    }

    setup_heading('Creating seller account');
    setup_create_admin($appPdo);

    setup_heading('Done');
    setup_output('Buyer storefront: ' . APP_URL . '/index.php?page=home');
    setup_output('Seller login: ' . APP_URL . '/index.php?page=seller-login');
} catch (Throwable $e) {
    http_response_code(500);
    setup_heading('Setup failed');
    setup_output($e->getMessage());
}

if (PHP_SAPI !== 'cli') {
    echo '</body></html>';
}
