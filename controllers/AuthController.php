<?php
namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\RegisterModel;

class AuthController extends Controller{

	public function login(){
		$this->setLayout('auth');
		return $this->render('login');
	}

	public function register(Request $request){
		
		$registerModel = new RegisterModel();
		if($request->isPost()){
			//echo '<pre>';
			//var_dump($request->getBody());
			//echo '</pre>';
			$registerModel->loadData($request->getBody());
			echo '<pre>';
			var_dump($registerModel);
			echo '</pre>';
			if($registerModel->validate() && $registerModel->register()){
				echo '<pre>';
				var_dump($registerModel->errors);
				echo '</pre>';
				return 'Success';
			}
			echo '<pre>';
			var_dump($registerModel->errors);
			echo '</pre>';

			return $this->render('register', [
				'model' => $registerModel
			]);
		}
		$this->setLayout('auth');
		return $this->render('register', [
			'model' => $registerModel
		]);
	}
}
?>