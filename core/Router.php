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
			return $this->renderView($callback);
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

	public function renderView($viewName, $params=[]){

		$layoutContent = $this->layoutContent();
		$viewContent = $this->renderOnlyView($viewName, $params);
		return str_replace('{{content}}',$viewContent, $layoutContent);
	}

	protected function layoutContent(){
		$layout = Application::$app->layout;
		if(Application::$app->controller)
		{
			$layout = Application::$app->getController()->layout;
		}
		ob_start();
		include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
		return ob_get_clean();
	}

	protected function renderOnlyView($viewName, $params){
		//echo '<pre>';
		//var_dump($params);
		//echo '</pre>';

		// tricky part to transform the name of the hashmap into a variable name
		foreach($params as $key => $value){
			$$key = $value;
		}
		ob_start();
		include_once Application::$ROOT_DIR."/views/$viewName.php";
		return ob_get_clean();
	}
	
}
?>