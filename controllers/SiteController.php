<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;

class SiteController extends Controller{


	public function home(){
		$params = [
			'name' => "Nico"
		];

		return $this->render('home', $params);
	}
	public function handleContact(){
		return 'Handling submitted data';
	}

	public function contact(){
		return $this->render('contact');
	}
}
?>