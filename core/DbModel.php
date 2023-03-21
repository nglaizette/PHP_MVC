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
	abstract public function attributes(): array;

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

		$statement->execute();
	}

	public static function prepare($sql){
		return Application::$app->db->pdo->prepare($sql);
	}
 }