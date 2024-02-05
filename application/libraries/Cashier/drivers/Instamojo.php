<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instamojo {
	protected $CI = null;
    protected $config = null;
    protected $message = null;
	
    public function __construct($config){
		$endpoints = array(
			'sandbox' => 'https://test.instamojo.com',
			'live' => 'https://api.instamojo.com'
		);
		
		if( $config['sandbox'] === true ){
			$config['endpoint'] = $endpoints['sandbox'];
			$config['client_id'] = $config['test_client_id'];
			$config['client_secret'] = $config['test_client_secret'];
			$config['salt'] = $config['test_salt'];
		} else {
			$config['endpoint'] = $endpoints['live'];
			$config['client_id'] = $config['live_client_id'];
			$config['client_secret'] = $config['live_client_secret'];
			$config['salt'] = $config['live_salt'];
		}
		
		foreach(['test_client_id','test_client_secret','live_client_id','live_client_secret','test_salt','live_salt'] as $key){
			unset($config[$key]);
		}
		
		$this->config = $config;
		
		$this->CI =& get_instance();
		$this->CI->load->library('session');
    }

    public function pre_payment( array $data ){
		$access_token = $this->_get_access_token();
        if($access_token === false){
			// token expired, regenerating...
			$access_token = $this->_get_access_token();
        }
		
		// overriding order_note, because instamojo doesn't provide user-defined fields
		$data['order_note'] = 'Invoice : ' . $data['order_id'];
		
        $response = $this->_curl_request(
			$this->config['endpoint'] . '/v2/payment_requests/',
			'POST',
			array(
				'amount' => number_format($data['order_amount'], 2, '.'),
				'purpose' => $data['order_note'],
				'buyer_name' => $data['customer_name'],
				'email' => $data['customer_email'],
				'phone' => $data['customer_contact'],
				'redirect_url' => $this->config['redirect_url'],
				'webhook' => rtrim( get_instance()->config->base_url(), '/' ) . $this->config['webhook_url'],
				'allow_repeated_payments' => false,
				'send_email' => false,
				'send_sms' => false
			),
			array( 'Authorization' => 'Bearer ' . $access_token )
        );

        if( ! in_array($response['http_code'], array(200, 201)) ){
			switch($response['http_code']){
				case '404':
					$this->message = 'Instamojo API Endpoint is not valid.';
					break;
				case '400':
					$message = '';
					foreach( $response['body'] as $field => $errors ){
						$message .= $field . ' : ' . implode(",", $errors) . "\n";
					}
					$this->message = $message;
					break;
				case '401':
					$this->message = $response['body']['message'];
					break;
				default:
					$this->message = 'There was an error on one of Instamojo servers with our request.';
			}
			return false;
        }
        
        $this->CI->session->set_userdata('INSTAMOJO_MERCHANT_ORDER_ID', $data['order_id']);
        
        redirect($response['body']['longurl']);
        die;
    }

    public function post_payment($amount, $currency){
		$access_token = $this->_get_access_token();
        if($access_token === false){
			// token expired, regenerating...
			$access_token = $this->_get_access_token();
        }

		if( ! isset($_REQUEST['payment_id']) || empty($_REQUEST['payment_id']) ){
			$this->message = 'Invalid Payment Request.';
			return false;
		}

		if( ! isset($_REQUEST['payment_request_id']) || empty($_REQUEST['payment_request_id']) ){
			$this->message = 'Invalid Payment Request.';
			return false;
		}

		if( $order_id = $this->CI->session->userdata('INSTAMOJO_MERCHANT_ORDER_ID') ){
            $this->CI->session->unset_userdata('INSTAMOJO_MERCHANT_ORDER_ID');
        } else {
			$this->message = 'Invalid Payment Request.';
			return false;
        }

		$payment_id = $_REQUEST['payment_id'];

		$response = $this->_curl_request(
			$this->config['endpoint'] . '/v2/payments/'.$payment_id.'/',
			'GET',
			array(),
			array( 'Authorization' => 'Bearer ' . $access_token )
		);

		if( $response['http_code'] != 200 ){
			switch($response['http_code']){
				case '404':
					$this->message = 'Invalid Payment Request.';
					break;
				case '400':
					$message = '';
					foreach( $response['body'] as $field => $errors ){
						$message .= $field . ' : ' . implode(",", $errors) . "\n";
					}
					$this->message = $message;
					break;
				case '401':
					$this->message = $response['body']['message'];
					break;
				default:
					$this->message = 'There was an error on one of Instamojo servers with our request.';
			}
			return false;
		}

		$response = $response['body'];

		if( $response['status'] == false ){
			$this->message = 'Payment with given ID was failed.';
			return false;
		} else if($response['status'] == null) {
			$this->message = 'Payment was initiated but not paid.';
			return false;
		}

		$payment_request_url = $this->config['endpoint'] . '/v2/payment_requests/' . $_REQUEST['payment_request_id'];

		if( rtrim($response['payment_request'], '/') != $payment_request_url ){
			$this->message = 'Invalid Payment Request.';
			return false;
		}

		$amount = number_format($amount, 2, '.');

		if($amount > $response['amount'] || $currency != $response['currency'] ){
			$refund = $this->_curl_request(
				$this->config['endpoint'] . '/v2/payments/'.$payment_id.'/refund/',
				'POST',
				array(
					'type' => 'PTH',
					'body' => 'Payment amount could not be verified.',
					'transaction_id' => $order_id
				),
				array( 'Authorization' => 'Bearer ' . $access_token )
			);

			if($refund['http_code'] == 200){
				$this->message = 'Paymount amount could not be verified, You will get complete refund in 5-7 Business days.';
			} else {
				$this->message = 'Paymount amount could not be verified. Contact Us for Refund with Order ID : ' . $order_id;
			}

			return false;
		}

		return array(
			'provider' => 'instamojo',
			'order_id' => $order_id,
			'order_amount' => $response['amount'],
			'reference_id' => $response['id'],
			'tx_status' => 'Credit',
			'payment_mode' => $response['instrument_type'],
			'tx_time' => strtotime( isset($response['updated_at']) ? $response['updated_at'] : $response['created_at'] )
		);
    }

    public function webhook(){
		$data = $_POST;
		$mac_provided = $data['mac'];
		unset($data['mac']);

		ksort($data, SORT_STRING | SORT_FLAG_CASE);

		$mac_calculated = hash_hmac('sha1', implode('|', $data), $this->config['salt']);

		if($mac_provided == $mac_calculated){
			if($data['status'] == "Credit"){
				$order_purpose_explode = explode(':', $data['purpose']);
				if( isset($order_purpose_explode[1]) ){
					$order_id = trim( $order_purpose_explode[1] );
				} else {
					$order_id = '';
				}
				
				return array(
					'provider' => 'instamojo',
					'order_id' => $order_id,
					'order_amount' => $data['amount'],
					'reference_id' => $data['payment_id'],
					'tx_status' => 'Credit',
					'payment_mode' => $data['instrument_type'],
					'tx_time' => time()
				);
			} else {
				$this->message = 'Payment was not successful.';
            	return false;
			}
		} else {
			$this->message = 'We could not verify the webhook event signature.';
            return false;
		}
    }

    public function message(){
        return $this->message;
    }

    protected function _get_access_token(){
		if( $data = $this->CI->session->userdata('INSTAMOJO_AUTH_DATA') ){
			if( time() < $data['expire'] ){
				$token = $data['token'];
			} else {
				$this->CI->session->unset_userdata('INSTAMOJO_AUTH_DATA');
				return false;
			}
		} else {
			$response = $this->_curl_request(
				$this->config['endpoint'] . '/oauth2/token/',
				'POST',
				array(
					'grant_type' => 'client_credentials',
					'client_id' => $this->config['client_id'],
					'client_secret' => $this->config['client_secret']
				)
			)['body'];

			$this->CI->session->set_userdata('INSTAMOJO_AUTH_DATA', array(
				'token' => $response['access_token'],
				'expire' => time() + $response['expires_in']
			));
			
			$token = $response['access_token'];
		}

		return $token;
    }
    
    protected function _curl_request($url, $method = 'POST', $post_values = array(), $headers_values = array(), $curl_options = array()){
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return instead of echo
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // follow redirection
		curl_setopt($curl, CURLOPT_TIMEOUT, 10); // timeout
		curl_setopt($curl, CURLOPT_USERAGENT, 'PHP/'. phpversion() .' ('. php_uname('s') .' '. php_uname('r') .') '. php_uname('n') .' Cashier/1.0'); // setting user agent
		
		if( $method == 'POST' ){
			curl_setopt($curl, CURLOPT_POST, 1);
		}
		
		$content_type = 'application/x-www-form-urlencoded';

		$headers = array();
		foreach($headers_values as $key => $value){
			$headers[] = $key.': '.$value;
			if( strtolower($key) == 'content-type' ){
				$content_type = strtolower($value);
			}
		}
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		if( $post_values ){
			if($content_type == 'application/json'){
				$post_values = json_encode($post_values);
			} else {
				$post_values = http_build_query($post_values);
			}

			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_values);
		}
		
		foreach($curl_options as $option => $value)
		{
			curl_setopt($curl, constant($option), $value);
		}

		$result = curl_exec($curl);

        if($result === false){
            $this->message = curl_error($curl);
            curl_close($curl);
            return false;
        } else {
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            return array('http_code' => $httpcode, 'body' => json_decode($result, true));
        }
    }
}
