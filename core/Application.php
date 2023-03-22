<?php
namespace app\core;

/**
 *  Class Application
 *  @author ngvg
 * 	@package app\core
 */
class Application{
	public static string $ROOT_DIR;
	public static Application $app;
	public Router $router;
	public Request $request;
	public Response $response;
	public Session $session;

	public Database $db;
	public Controller $controller;
	
	public function __construct($rootPath, array $config)
	{
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		self::$ROOT_DIR = $rootPath;
		self::$app = $this;
		$this->request = new Request();
		$this->response = new Response();
		$this->session = new Session();
		$this->router = new Router($this->request, $this->response);
		$this->db = new Database($config['db']);
	}

	public function run(){
		echo $this->router->resolve();
	}

	public function getController(): Controller
	{
		return $this->controller;
	}

	public function setController(Controller $controller){
		$this->controller = $controller;
	}
}
?>