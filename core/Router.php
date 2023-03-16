<?php
namespace app\core;

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
		$method = $this->request->getMethod();
		//echo '<pre>';
		//var_dump($this->routes);
		//echo '</pre>';
		$callback = $this->routes[$method][$path] ?? false;

		if(!$callback){
			$this->response->setStatusCode(404);
			return $this->renderView("_404");
		}

		if(is_string($callback)){
			return $this->renderView($callback);
		}

		if(is_array($callback)){
			$callback[0] = new $callback[0](); // creation of an instance of the proper type

		}

		//echo '<pre>';
		//var_dump($callback);
		//var_dump($path);
		//var_dump($method);
		//var_dump($_SERVER);
		//echo '</pre>';

		return call_user_func($callback);
	}

	public function renderView($viewName){

		$layoutContent = $this->layoutContent();
		$viewContent = $this->renderOnlyView($viewName);
		return str_replace('{{content}}',$viewContent, $layoutContent);
	}

	protected function layoutContent(){
		ob_start();
		include_once Application::$ROOT_DIR."/views/layouts/main.php";
		return ob_get_clean();
	}

	protected function renderOnlyView($viewName){
		ob_start();
		include_once Application::$ROOT_DIR."/views/$viewName.php";
		return ob_get_clean();
	}
	
}
?>