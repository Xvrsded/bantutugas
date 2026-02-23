<?php

$runtimeCacheDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'laravel-bootstrap-cache';

if (! is_dir($runtimeCacheDir)) {
	@mkdir($runtimeCacheDir, 0777, true);
}

$cacheFiles = [
	'APP_PACKAGES_CACHE' => $runtimeCacheDir . DIRECTORY_SEPARATOR . 'packages.php',
	'APP_SERVICES_CACHE' => $runtimeCacheDir . DIRECTORY_SEPARATOR . 'services.php',
	'APP_CONFIG_CACHE' => $runtimeCacheDir . DIRECTORY_SEPARATOR . 'config.php',
	'APP_ROUTES_CACHE' => $runtimeCacheDir . DIRECTORY_SEPARATOR . 'routes.php',
	'APP_EVENTS_CACHE' => $runtimeCacheDir . DIRECTORY_SEPARATOR . 'events.php',
];

foreach ($cacheFiles as $key => $value) {
	if (getenv($key) === false || getenv($key) === '') {
		putenv($key . '=' . $value);
		$_ENV[$key] = $value;
		$_SERVER[$key] = $value;
	}
}

require __DIR__ . '/../public/index.php';
