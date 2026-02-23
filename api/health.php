<?php

header('Content-Type: application/json');

$keys = [
    'APP_ENV',
    'APP_DEBUG',
    'APP_KEY',
    'APP_URL',
    'DB_CONNECTION',
    'DB_HOST',
    'DB_PORT',
    'DB_DATABASE',
    'DB_USERNAME',
    'DB_PASSWORD',
    'MIDTRANS_SERVER_KEY',
    'MIDTRANS_CLIENT_KEY'
];

$env = [];
foreach ($keys as $key) {
    $value = getenv($key);
    $env[$key] = ($value !== false && trim((string) $value) !== '') ? 'OK' : 'MISSING';
}

$db = [
    'configured' => 'NO',
    'connect' => 'SKIPPED',
    'error' => null,
];

$host = getenv('DB_HOST') ?: '';
$port = getenv('DB_PORT') ?: '3306';
$name = getenv('DB_DATABASE') ?: '';
$user = getenv('DB_USERNAME') ?: '';
$pass = getenv('DB_PASSWORD') ?: '';

if ($host !== '' && $name !== '' && $user !== '') {
    $db['configured'] = 'YES';

    try {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $name);
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5,
        ]);
        $pdo->query('SELECT 1');
        $db['connect'] = 'OK';
    } catch (Throwable $exception) {
        $db['connect'] = 'FAILED';
        $db['error'] = $exception->getMessage();
    }
}

echo json_encode([
    'php' => PHP_VERSION,
    'files' => [
        'vendor_autoload' => file_exists(__DIR__ . '/../vendor/autoload.php') ? 'OK' : 'MISSING',
        'public_index' => file_exists(__DIR__ . '/../public/index.php') ? 'OK' : 'MISSING',
        'vite_manifest' => file_exists(__DIR__ . '/../public/build/manifest.json') ? 'OK' : 'MISSING',
    ],
    'env' => $env,
    'db' => $db,
], JSON_PRETTY_PRINT);
