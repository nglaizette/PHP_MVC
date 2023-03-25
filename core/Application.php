<?php
namespace app\core;

use app\models\User;
use Exception;

/**
 *  Class Application
 *  @author ngvg
 * 	@package app\core
 */
class Application{
	public static string $ROOT_DIR;
	public static Application $app;

	public string $layout = 'main';
	public string $userClass;
	public Router $router;
	public Request $request;
	public Response $response;
	public Session $session;
	public ?UserModel $user;
	public View $view;

	public Database $db;
	public ?Controller $controller=null;
	
	public function __construct($rootPath, array $config)
	{
		error_reporting(E_ALL);
		ini_set("display_errors", 1);

		$this->userClass = $config['userClass'];
		self::$ROOT_DIR = $rootPath;
		self::$app = $this;
		$this->request = new Request();
		$this->response = new Response();
		$this->session = new Session();
		$this->router = new Router($this->request, $this->response);
		$this->view = new View();
		
		$this->db = new Database($config['db']);

		$user = new $this->userClass();
		$primaryValue = $this->session->get('user');
		
		if($primaryValue){
			$primaryKey = $user->primaryKey();
			$this->user = $user->findOne([$primaryKey => $primaryValue]);
		} else {
			$this->user = null;
		}
	}

	public static function isGuest()
	{
		return !self::$app->user;
	}

	public function run(){
		try
		{
			echo $this->router->resolve();
		} catch (Exception $e){
			$this->response->setStatusCode($e->getCode());
			echo $this->view->renderView('_error',[
				'exception' => $e
			]);
		}
	}

	public function getController(): Controller
	{
		return $this->controller;
	}

	public function setController(Controller $controller){
		$this->controller = $controller;
	}

	public function login(DbModel $user)
	{
		$this->user = $user;
		$primaryKey = $user->primaryKey();
		$primaryValue = $user->{$primaryKey};
		$this->session->set('user', $primaryValue);
		return true;
	}

	public function logout()
	{
		$this->user =  null;
		$this->session->remove('user');
	}
}
?>