<?php

header('Content-Type: application/json');

$required = [
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
];

$envStatus = [];
foreach ($required as $key) {
    $value = getenv($key);
    $envStatus[$key] = ($value !== false && trim((string) $value) !== '') ? 'OK' : 'MISSING';
}

echo json_encode([
    'php' => PHP_VERSION,
    'files' => [
        'vendor_autoload' => file_exists(__DIR__ . '/../vendor/autoload.php') ? 'OK' : 'MISSING',
        'bootstrap_app' => file_exists(__DIR__ . '/../bootstrap/app.php') ? 'OK' : 'MISSING',
        'public_index' => file_exists(__DIR__ . '/../public/index.php') ? 'OK' : 'MISSING',
        'vite_manifest' => file_exists(__DIR__ . '/../public/build/manifest.json') ? 'OK' : 'MISSING',
    ],
    'env' => $envStatus,
], JSON_PRETTY_PRINT);
