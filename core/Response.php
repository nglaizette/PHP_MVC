<?php
namespace app\core;
/**
 *  Class Application
 *  @author ngvg
 * 	@package app\core
 */
class Response{
	public function setStatusCode(int $code){
		return http_response_code($code);
	}
}

?>