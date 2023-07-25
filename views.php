<?php
$r = $_SERVER['REQUEST_URI'];

switch ($r) {
	case '':
	case '/':
		require __DIR__ . 'views/index.php';
		break;

	case '/anime':
		require __DIR__ . '/views/anime.php';

	default:
		http_response_code(404);
		require __DIR__ . './views/404.php';
}
