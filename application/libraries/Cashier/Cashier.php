<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashier {
	protected $CI = null;
	protected $config = null;
	protected $driver = null;
	protected $message = null;
	
	protected $required_fields = array(
		'order_id' => 'Order ID',
		'order_amount' => 'Order Amount',
		'order_currency' => 'Order Currency',
		'customer_name' => 'Customer Name',
		'customer_email' => 'Customer Email',
		'customer_contact' => 'Customer Contact',
		'order_note' => 'Order Note'
	);

	public function __construct(){
		$this->CI =& get_instance();
		
		$this->CI->config->load('cashier', TRUE);
		$this->config = $this->CI->config->item('cashier');
	}

	public function driver( $driver ){
		if( isset($this->config[$driver]) ){
	
			if($this->config[$driver]['enabled'] === true){
				$class_name = ucfirst(strtolower($driver));
				$path = __DIR__ . '/drivers/' . $class_name . '.php';
				if( file_exists($path) ){
					require_once($path);

					$base_url = rtrim($this->CI->config->base_url(), '/');

					$this->config[$driver]['redirect_url'] = $this->_modify_url(
						$base_url.$this->config['redirect_url'], ['provider' => $driver]
					);

					$this->driver = new $class_name( $this->config[$driver] );
					return true;
				} else {
					$this->message = 'Select Payment Gateway does not have a driver.';
				}
			} else {
				$this->message = 'Selected Payment Gateway is not enabled currently.';
			}
		} else {
			$this->message = 'Internal Error while Processing this Payment Gateway.';
		}
		
		return false;
	}

	public function pre_payment( array $data ){
		if( $this->driver ){
			$message = '';

			foreach($this->required_fields as $key => $pretty_name){
				if( ! isset($data[$key]) || empty($data[$key]) ){
					if($key != 'order_note'){
						$message .= $pretty_name . " is a required field.\n";
					}
				}
			}

			if( $message == '' ){
				if( $this->driver->pre_payment( $data ) === false ){
					$this->message = $this->driver->message();
					return false;
				} else {
					return true;
				}
			} else {
				$this->message = $message;
				return false;
			}
		} else {
			$this->message = 'Payment Gateway Driver is not loaded.';
			return false;
		}
	}

	public function post_payment($amount, $currency){
		if( $driver = $this->CI->input->get('provider', true) ){
			if( $this->driver($driver) ){
				if( $result = $this->driver->post_payment($amount, $currency) ){
					return $result;
				} else {
					$this->message = $this->driver->message();
					return false;
				}
			} else {
				return false;
			}
		} else {
			$this->message = 'We could not identify Payment gateway provider.';
			return false;
		}
	}

	public function webhook(){
		if( $driver = $this->CI->input->get('provider', true) ){
			if( $this->driver($driver) ){
				if( $result = $this->driver->webhook() ){
					return $result;
				} else {
					$this->message = $this->driver->message();
					return false;
				}
			} else {
				return false;
			}
		} else {
			$this->message = 'We could not identify Payment gateway provider.';
			return false;
		}
	}

	public function message(){
		return $this->message;
	}

	public function _modify_url($url, $modify_get){
		if( preg_match('/\?/', $url) ){
			$parsed = explode('?', $url);
			parse_str( $parsed[1], $orig_get );
			foreach($modify_get as $key => $value){
				$orig_get[$key] = $value;
			}
			$url = $parsed[0] . '?' . http_build_query($orig_get);
		}
		return $url . '?' . http_build_query($modify_get);
	}
}
