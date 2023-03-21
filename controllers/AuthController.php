<?php
namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller{

	public function login(){
		$this->setLayout('auth');
		return $this->render('login');
	}

	public function register(Request $request){
		
		$user = new User();
		if($request->isPost()){
			//echo '<pre>';
			//var_dump($request->getBody());
			//echo '</pre>';
			$user->loadData($request->getBody());
			echo '<pre>';
			var_dump($user);
			echo '</pre>';
			if($user->validate() && $user->register()){
				echo '<pre>';
				var_dump($user->errors);
				echo '</pre>';
				return 'Success';
			}
			echo '<pre>';
			var_dump($user->errors);
			echo '</pre>';

			return $this->render('register', [
				'model' => $user
			]);
		}
		$this->setLayout('auth');
		return $this->render('register', [
			'model' => $user
		]);
	}
}
?>