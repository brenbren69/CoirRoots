<?php
// One-time database setup — run once then delete this file
require_once __DIR__ . '/app-config/database.php';
require_once __DIR__ . '/models/Database.php';

echo "<pre style='font-family:monospace;font-size:13px;padding:20px;background:#1a1a1a;color:#00ff00;'>";
echo "=== Coir Roots Database Setup ===\n\n";

function getSqlStatements(string $sql): array {
    $results = [];
    foreach (explode(';', $sql) as $stmt) {
        // Strip comment lines to get the real SQL for filtering
        $lines = explode("\n", $stmt);
        $sqlLines = [];
        foreach ($lines as $line) {
            $l = trim($line);
            if ($l === '' || str_starts_with($l, '--')) continue;
            $sqlLines[] = $l;
        }
        $actual = trim(implode(' ', $sqlLines));
        if (empty($actual)) continue;
        // Skip USE and CREATE DATABASE — Railway DB is already selected
        if (stripos($actual, 'USE ') === 0) continue;
        if (stripos($actual, 'CREATE DATABASE') === 0) continue;
        $results[] = $stmt; // execute original (with comments — PDO handles them fine)
    }
    return $results;
}

try {
    $pdo = Database::getInstance()->getConnection();
    echo "✓ Database connected successfully\n\n";

    // Run schema.sql
    echo "Running schema.sql...\n";
    $statements = getSqlStatements(file_get_contents(__DIR__ . '/database/schema.sql'));
    $count = 0;
    foreach ($statements as $stmt) {
        $pdo->exec($stmt);
        $count++;
    }
    echo "✓ Schema created ($count statements executed)\n\n";

    // Run seed.sql
    echo "Running seed.sql...\n";
    $statements = getSqlStatements(file_get_contents(__DIR__ . '/database/seed.sql'));
    $count = 0;
    foreach ($statements as $stmt) {
        try {
            $pdo->exec($stmt);
            $count++;
        } catch (PDOException $e) {
            echo "  (skipped — already exists)\n";
        }
    }
    echo "✓ Seed data inserted ($count statements executed)\n\n";

    // Create admin user
    echo "Creating admin user...\n";
    $hash = password_hash('Admin@123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT IGNORE INTO users (name, email, password, mobile, address, role) VALUES (?, ?, ?, ?, ?, 'seller')");
    $stmt->execute(['Admin User', 'admin@coirroots.ph', $hash, '+639171234567', 'Brgy. Guinobatan, Albay, Philippines']);
    echo "✓ Admin user ready (admin@coirroots.ph / Admin@123)\n\n";

    echo "=== Setup Complete! ===\n";
    echo "\nYou can now visit the site: https://coirroots-production.up.railway.app\n";
    echo "IMPORTANT: Delete db-setup.php after setup!\n";

} catch (Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
}

echo "</pre>";
