<?php
namespace app\models;

use app\core\Model;

class RegisterModel extends Model{

	public string $firstname;
	public string $lastname;
	public string $email;
	public string $password;
	public string $confirmPassword;


	public function rules():array{
		return [
			
		];
	}

	public function register():bool{
		echo "Creation new user";
		return true;
	}

}