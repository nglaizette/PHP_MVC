<?php

	require_once __DIR__.'/../vendor/autoload.php';
	use app\core\Application;

	//echo "Hello world";
	$app = new Application();

	$app->router->get('/', 'home');

	$app->router->get('/contact', 'contact');

	$app->run();
?>