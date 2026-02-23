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
		'file' => $exception->getFile(),
		'line' => $exception->getLine(),
		'previous' => $exception->getPrevious() ? [
			'error' => get_class($exception->getPrevious()),
			'message' => $exception->getPrevious()->getMessage(),
			'file' => $exception->getPrevious()->getFile(),
			'line' => $exception->getPrevious()->getLine(),
		] : null,
		'trace' => array_slice($exception->getTrace(), 0, 25),
	], JSON_PRETTY_PRINT);
}
