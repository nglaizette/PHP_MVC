<?php
namespace app\controllers;

use app\core\Application;

class SiteController{


	public function home(){
		$params = [
			'name' => "Nico"
		];

		return Application::$app->router->renderView('home');
	}
	public function handleContact(){
		return 'Handling submitted data';
	}

	public function contact(){
		return Application::$app->router->renderView('contact');
	}
}
?>