<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Exception.php';
require_once __DIR__ . '/PHPMailer.php';
require_once __DIR__ . '/SMTP.php';

class Mailer extends \PHPMailer\PHPMailer\PHPMailer {
	public function __construct(){
		$CI =& get_instance();
		
		$CI->config->load('mailer', TRUE);
		$config = $CI->config->item('mailer');
		
		parent::__construct(true);
		
		switch($config['method']){
			case 'mail':
				$this->isMail();
				break;
			case 'smtp':
				$this->isSMTP();
				break;
			case 'sendmail':
				$this->isSendmail();
				break;
			case 'qmail':
				$this->isQmail();
				break;
			default:
				$this->isMail();
		}
		unset($config['method']);
		
		$this->setFrom($config['fromEmail'], $config['fromName']);
		unset($config['fromEmail']); unset($config['fromName']);

		foreach($config as $key => $value){
			$this->{$key} = $value;
		}
	}

	public function clearAll(){
		$this->Subject = '';
		$this->Body = '';
		$this->AltBody = '';
		$this->clearQueuedAddresses('to');
		$this->clearQueuedAddresses('cc');
		$this->clearQueuedAddresses('bcc');
		$this->clearReplyTos();
		$this->clearAllRecipients();
		$this->clearAttachments();
		$this->clearCustomHeaders();
	}
}
