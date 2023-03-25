<?php
namespace app\models;

use app\core\Model;

/**
 * Class Contactform
 * 
 * @author ngvg
 * @package app\model 
 */
class ContactForm extends Model
{
	public string $subject = '';
	public string $email = '';
	public string $body = '';
	
	public function rules():array
	{
		return [
			'subject' => [self::RULE_REQUIRED],
			'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
			'body' => [self::RULE_REQUIRED]
		];
	}

	public function labels(): array
	{
		return [
			'email' => 'Your email',
			'subject' => 'Subject',
			'body' => 'Your message'
		];
	}

	public function send(){
		return true;
	}
}
?>