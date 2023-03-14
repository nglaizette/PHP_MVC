<?php

	require_once __DIR__.'/vendor/autoload.php';
	use app\core\Application;

	//echo "Hello world";
	$app = new Application();

	$app->router->get('/', function(){
		return 'Hello world from router';
	});

	$app->router->get('/contact', function(){
		return 'Hello world from router, Contact';
	});

	$app->run();
?>