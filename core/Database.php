<?php
/** User: me */
namespace app\core;

use PDO;

/**
 * Class Database
 * 
 * @author me <me@dd.com>
 * @package app\core
 */
class Database
{
	public PDO $pdo;

	public function __construct(array $config)
	{
		$dsn      = $config['dsn'] ?? ''; //domain service name
		$user     = $config['user'] ?? '';
		$password = $config['password'] ?? '';
		echo '<pre>';
		var_dump($dsn);
		var_dump($user);
		var_dump($password);
		echo '</pre>';
		$this->pdo = new PDO($dsn, $user, $password);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}

	public function applyMigrations()
	{
		$this->createMigrationTable();
		$this->getAppliedMigration();
		
		$files = scandir(Application::$ROOT_DIR.'/migrations');
		//echo '<pre>';
		//var_dump($files);
		//echo '</pre>';
	}

	public function createMigrationTable()
	{
		//echo '<pre>';
		//var_dump($this->pdo);
		//echo '</pre>';
		$this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
			id INT AUTO_INCREMENT PRIMARY KEY,
			migration VARCHAR(255),
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=INNODB;");
	}

	public function getAppliedMigration(){
		$statement = $this->pdo->prepare("SELECT migration FROM migrations");
		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_COLUMN);
	}
}