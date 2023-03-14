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

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function get($path, $callback)
	{
		$this->routes['get'][$path] = $callback;
	}

	public function resolve()
	{
		$path = $this->request->getPath();
		$method = $this->request->getMethod();
		echo '<pre>';
		var_dump($this->routes);
		echo '</pre>';
		$callback = $this->routes[$method][$path] ?? false;

		if(!$callback){
			echo "Not found";
			exit;
		}

		echo '<pre>';
		var_dump($callback);
		var_dump($path);
		var_dump($method);
		var_dump($_SERVER);
		echo '</pre>';

		echo(call_user_func($callback));
		exit;
	}
	
}
?>