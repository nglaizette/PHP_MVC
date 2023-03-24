<?php

/** User: ngvg */
namespace app\core;

/**
 * Class DbModel
 * 
 * @author ngvg
 * @package app\core
 */

 abstract class DbModel extends Model
 {
	abstract public function tableName():string;
	abstract public function attributes():array;
	abstract public function primaryKey():string;

	public function save(){
		$tableName = $this->tableName();
		$attributes = $this->attributes();
		// array creation of attributes begining with semi column;
		$params = array_map(fn($attr) => ":$attr", $attributes);
		$statement = self::prepare("INSERT INTO $tableName (".implode(',',$attributes).") VALUES  (".implode(',', $params).");");

		//echo "<pre>";
		//var_dump($statement, $params, $attributes);
		//echo "</pre>";

		foreach($attributes as $attribute){
			$statement->bindValue(":$attribute", $this->{$attribute});
		}

		return $statement->execute();
		
	}

	public function findOne($where){
		$tableName = $this->tableName(); // self marche pas, static sur l'insance en cours
		$attributes = array_keys($where);
		// SELECT * from $tableName WHERE email = :email AND ...
		$sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
		$statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
		foreach($where as $key => $item){
			$statement->bindValue(":$key", $item);
		}

		$statement->execute();
		return $statement->fetchObject(static::class);
	}

	public static function prepare($sql){
		return Application::$app->db->pdo->prepare($sql);
	}
 }