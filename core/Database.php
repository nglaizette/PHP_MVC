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
		echo '</pre>'.PHP_EOL;
		$this->pdo = new PDO($dsn, $user, $password);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}

	public function applyMigrations()
	{
		$this->createMigrationTable();
		$appliedMigrations = $this->getAppliedMigration();
		
		$files = scandir(Application::$ROOT_DIR.'/migrations');
		//echo '<pre>';
		//var_dump($files);
		//echo '</pre>';
		$toApplyMigrations = array_diff($files,$appliedMigrations);
		
		//echo '<pre>';
		//var_dump($toApplyMigrations);
		//echo '</pre>';
		$newMigrations = [];
		foreach($toApplyMigrations as $migration){
			if($migration === '.' || $migration === '..'){
				continue;
			}

			require_once Application::$ROOT_DIR.'/migrations/'.$migration;
			$className = pathinfo($migration, PATHINFO_FILENAME);

			//echo '<pre>';
			//var_dump($className);
			//echo '</pre>';

			$instances = new $className();
			//var_dump($instances);

			$this->log("Applying migration $migration");
			$instances->up();
			$this->log("Applied migration $migration");
			$newMigrations[] = $migration;
		}

		if(!empty($newMigrations)){
			$this->saveMigrations($newMigrations);
		} else {
			$this->log("All migrations have been applied");
		}
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

	public function saveMigrations(array $migrations){
		var_dump($migrations);
		$migrationArray = array_map(fn($m) => "('$m')", $migrations);
		var_dump($migrationArray);
		$str = implode(",", $migrationArray);
		var_dump($str);
		$statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str ");
		$statement->execute();
	}

	protected function log($message){
		echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
	}

	public function prepare($sql)
	{
		return $this->pdo->prepare($sql);
	}
}