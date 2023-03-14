<?php
namespace app\core;

/**
 *  Class Request
 *  @author ngvg
 * 	@package app\core
 */
class Request
{
	protected array $routes = [];

	public function getPath()
	{
		$path = $_SERVER['REQUEST_URI'] ?? '/';
		$position = strpos($path, '?');

		if(!$position){
			return $path;
		}

		$path = substr($path, 0, $position);
		return $path;
	}

	public function getMethod()
	{
		return strtolower($_SERVER['REQUEST_METHOD']);
	}
	
}
?>