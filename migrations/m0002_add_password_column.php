<?php
/**
 * User: NGVG
 * Date: 18/03/2023
 * 
 */
use app\core\Application;

 class m0002_add_password_column{
	public function up(){
		$db = \app\core\Application::$app->db;
		$db->pdo->exec("ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL;");
	}

	public function down(){
		$db = \app\core\Application::$app->db;
		$db->pdo->exec("ALTER TABLE users DROP COLUMN password;");
	}
 }