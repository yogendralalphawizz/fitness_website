<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Security extends CI_Security {
	public function csrf_input(){
		echo '<input type="hidden" name="'.$this->get_csrf_token_name().'" value="'.$this->get_csrf_hash().'" />';
	}
	
	public function csrf_meta(){
		echo '<meta name="'.$this->get_csrf_token_name().'" content="'.$this->get_csrf_hash().'">';
	}
}
