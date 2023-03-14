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

		echo '<pre>';
		var_dump($path);
		echo '</pre>';
		exit;
	}
	
}
?>