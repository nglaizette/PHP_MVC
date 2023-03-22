<?php
namespace app\core;

/**
 *  Class Router
 *  @author ngvg
 * 	@package app\core
 */
class Session {

	protected const FLASH_KEY = 'flash_messages';

	public function __construct(){
		session_start();
		$flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
		foreach($flashMessages as $key => &$flashMessage){ // 
			// Mark to be removed.
			$flashMessage['remove'] = true;
		}

		$_SESSION[self::FLASH_KEY] = $flashMessages;
		//echo '<pre>';
		//var_dump($_SESSION[self::FLASH_KEY]);
		//echo '</pre>';
	}

	public function setFlash($key, $message)
	{
		$_SESSION[self::FLASH_KEY][$key] = [ 
			'remove' => false,
			'value' => $message 
		];

	}

	public function getFlash($key)
	{
		return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
	}

	public function __destruct()
	{
		// Iterate over $_Session and remove entries with remove=true
		$flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
		foreach($flashMessages as $key => &$flashMessage){ // 
			if($flashMessage['remove']){
				unset($flashMessages[$key]);
			}
		}
		//var_dump($_SESSION[self::FLASH_KEY]);
		$_SESSION[self::FLASH_KEY] = $flashMessages;
	}

}
?>