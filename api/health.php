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
    'counts' => null,
];

$host = getenv('DB_HOST') ?: '';
$port = getenv('DB_PORT') ?: '3306';
$name = getenv('DB_DATABASE') ?: '';
$user = getenv('DB_USERNAME') ?: '';
$pass = getenv('DB_PASSWORD') ?: '';

$dbUrl = getenv('DB_URL') ?: '';
if (($host === '' || $name === '' || $user === '') && $dbUrl !== '') {
    $parsedUrl = parse_url($dbUrl);

    if (is_array($parsedUrl)) {
        $host = $host !== '' ? $host : ($parsedUrl['host'] ?? '');
        $port = $port !== '3306' ? $port : (string) ($parsedUrl['port'] ?? '3306');
        $name = $name !== '' ? $name : ltrim((string) ($parsedUrl['path'] ?? ''), '/');
        $user = $user !== '' ? $user : urldecode((string) ($parsedUrl['user'] ?? ''));
        $pass = $pass !== '' ? $pass : urldecode((string) ($parsedUrl['pass'] ?? ''));
    }
}

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

        try {
            $db['counts'] = [
                'services' => (int) $pdo->query('SELECT COUNT(*) FROM services')->fetchColumn(),
                'active_services' => (int) $pdo->query('SELECT COUNT(*) FROM services WHERE is_active = 1')->fetchColumn(),
                'portfolios' => (int) $pdo->query('SELECT COUNT(*) FROM portfolios')->fetchColumn(),
                'featured_portfolios' => (int) $pdo->query('SELECT COUNT(*) FROM portfolios WHERE is_featured = 1')->fetchColumn(),
                'testimonials' => (int) $pdo->query('SELECT COUNT(*) FROM testimonials')->fetchColumn(),
            ];
        } catch (Throwable $exception) {
            $db['counts'] = [
                'error' => $exception->getMessage(),
            ];
        }
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
    'db_source' => [
        'db_url_present' => $dbUrl !== '' ? 'YES' : 'NO',
        'host' => $host !== '' ? 'OK' : 'MISSING',
        'port' => $port !== '' ? 'OK' : 'MISSING',
        'database' => $name !== '' ? 'OK' : 'MISSING',
        'username' => $user !== '' ? 'OK' : 'MISSING',
    ],
], JSON_PRETTY_PRINT);
