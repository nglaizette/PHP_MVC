<?php
namespace app\core;

use app\core\exception\NotFoundException;

/**
 *  Class Router
 *  @author ngvg
 * 	@package app\core
 */
class Router
{
	protected array $routes = [];
	public Request $request;
	public Response $response;

	public function __construct(Request $request, Response $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	public function get($path, $callback)
	{
		$this->routes['get'][$path] = $callback;
	}

	public function post($path, $callback)
	{
		$this->routes['post'][$path] = $callback;
	}

	public function resolve()
	{
		$path = $this->request->getPath();
		$method = $this->request->method();
		//echo '<pre>';
		//var_dump($this->routes);
		//echo '</pre>';
		$callback = $this->routes[$method][$path] ?? false;

		if(!$callback){
			Application::$app->setController(new Controller());
			throw new NotFoundException();
		}

		if(is_string($callback)){
			return Application::$app->view->renderView($callback);
		}

		if(is_array($callback)){
			//** @var \app\core\Controller $contorller */
			$controller = new $callback[0]();// creation of an instance of the proper type
			Application::$app->setController($controller); 
			Application::$app->controller->action = $callback[1];
			$callback[0] = Application::$app->getController();

			foreach($controller->getMiddlewares() as $middleware){
				$middleware->execute();
			}

		}

		//echo '<pre>';
		//var_dump($callback);
		//var_dump($path);
		//var_dump($method);
		//var_dump($_SERVER);
		//echo '</pre>';

		return call_user_func($callback, $this->request, $this->response);
	}	
}
?>