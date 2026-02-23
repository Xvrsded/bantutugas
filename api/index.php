<?php

try {
	require __DIR__ . '/../public/index.php';
} catch (Throwable $exception) {
	http_response_code(500);
	header('Content-Type: application/json');

	echo json_encode([
		'status' => 'bootstrap_failed',
		'error' => get_class($exception),
		'message' => $exception->getMessage(),
	], JSON_PRETTY_PRINT);
}
