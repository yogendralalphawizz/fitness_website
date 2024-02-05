<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal {
	protected $CI = null;
    protected $config = null;
    protected $message = null;

    public function __construct($config){
        $endpoints = array(
            'live' => 'https://api-m.paypal.com',
            'sandbox' => 'https://api-m.sandbox.paypal.com'
        );
        
        if($config['sandbox'] === true){
            $config['endpoint'] = $endpoints['sandbox'];
            $config['clientId'] = $config['sandbox_clientId'];
            $config['clientSecret'] = $config['sandbox_clientSecret'];
        } else {
            $config['endpoint'] = $endpoints['live'];
            $config['clientId'] = $config['live_clientId'];
            $config['clientSecret'] = $config['live_clientSecret'];
        }
        
        foreach(['sandbox_clientId','sandbox_clientSecret','live_clientId','live_clientSecret'] as $key){
			unset($config[$key]);
        }
        
		$this->config = $config;
		
		$this->CI =& get_instance();
		$this->CI->load->library('session');
    }

    public function pre_payment( array $data ){
		$exploded_customer_name = explode(' ', $data['customer_name']);
		
        $order_data = array(
			'intent' => 'CAPTURE',
			'purchase_units' => array(
				array(
					'description' => $data['order_note'],
					'amount' => array(
						'currency_code' => $data['order_currency'],
						'value' => $data['order_amount']
					),
					'invoice_id' => $data['order_id']
				)
			),
			'payer' => array(
				'email_address' => $data['customer_email'],
				'name' => array(
					'given_name' => $exploded_customer_name[0],
					'surname' => isset($exploded_customer_name[1]) ? $exploded_customer_name[1] : ''
				),
				'phone_with_type' => array(
					'phone_type' => 'MOBILE',
					'phone_number' => array(
						'national_number' => $data['customer_contact']
					)
				)
			)
		);

		$this->_render_form($order_data);
		die;
    }

    public function post_payment($amount, $currency){
		$access_token = $this->_get_access_token();
        if($access_token === false){
			// token expired, regenerating...
			$access_token = $this->_get_access_token();
        }
		
		if( $order_id = $this->CI->input->get('order_id') ){
			// ok
		} else {
			$this->message = 'Invalid Payment Request, Any Amount deducated will be refunded in 5-7 days.';
			return false;
		}

		$order_data = $this->_curl_request(
			$this->config['endpoint'] . '/v2/checkout/orders/'.$order_id,
			'GET',
			array(),
			array('Authorization' => 'Bearer ' . $access_token)
		);

		if( $order_data === false ){
			return false;
		}
		
		if( isset($order_data['name']) ){
			$this->message = $order_data['message'];
			return false;
		}

		if( $order_data['status'] != 'APPROVED' ){
			switch($order_data['status']){
				case 'CREATED':
					$this->message = 'The Order was created, but Not Paid Yet.';
					break;
				case 'SAVED':
					$this->message = 'The order was saved, but Not Paid Yet.';
					break;
				case 'VOIDED':
					$this->message = 'All purchase units in the order are voided.';
					break;
				case 'COMPLETED':
					$this->message = 'This Order was created, but Not Paid Yet.';
					break;
				case 'PAYER_ACTION_REQUIRED':
					$this->message = 'The order requires an action from the payer.';
					break;
			}
			return false;
		}

		$amount_data = $order_data['purchase_units'][0]['amount'];
		if($amount_data['value'] == $amount && $amount_data['currency_code'] == $currency){
			// ok
		} else {
			$this->message = 'Payment Amount could not be verified, You will get complete refund in 5-7 Business days.';
			return false;
		}

		// capture the payment
		$capture_data = $this->_curl_request(
			$this->config['endpoint'] . '/v2/checkout/orders/'.$order_id.'/capture',
			'POST',
			array(),
			array('Authorization' => 'Bearer ' . $access_token, 'Content-Type' => 'application/json')
		);

		if( $capture_data === false ){
			return false;
		}
		
		if( isset($capture_data['name']) ){
			$this->message = $capture_data['message'];
			return false;
		}

		if( $capture_data['status'] != 'COMPLETED' ){
			switch($capture_data['status']){
				case 'CREATED':
					$this->message = 'The Order was created, but Not Paid Yet.';
					break;
				case 'SAVED':
					$this->message = 'The order was saved, but Not Paid Yet.';
					break;
				case 'VOIDED':
					$this->message = 'All purchase units in the order are voided.';
					break;
				case 'APPROVED':
					$this->message = 'This Order was paid, but not visible on Our Server. You will get complete refund in 5-7 Business days.';
					break;
				case 'PAYER_ACTION_REQUIRED':
					$this->message = 'The order requires an action from the payer.';
					break;
			}
			return false;
		}

		$purchase_unit = $order_data['purchase_units'][0];
		$tx_time = isset($order_data['update_time']) ? $order_data['update_time'] : $order_data['create_time'];

		return array(
			'provider' => 'paypal',
			'order_id' => $purchase_unit['invoice_id'],
			'order_amount' => $purchase_unit['amount']['value'],
			'reference_id' => $order_data['id'],
			'tx_status' => $order_data['status'],
			'payment_mode' => 'unknown',
			'tx_time' => strtotime($tx_time)
		);
    }

    public function webhook(){
		$access_token = $this->_get_access_token();
        if($access_token === false){
			// token expired, regenerating...
			$access_token = $this->_get_access_token();
		}
		
		$body = json_decode(@file_get_contents('php://input'), true);

		$request = array(
			'auth_algo' => $_SERVER['HTTP_PAYPAL_AUTH_ALGO'],
			'cert_url' => $_SERVER['HTTP_PAYPAL_CERT_URL'],
			'transmission_id' => $_SERVER['HTTP_PAYPAL_TRANSMISSION_ID'],
			'transmission_sig' => $_SERVER['HTTP_PAYPAL_TRANSMISSION_SIG'],
			'transmission_time' => $_SERVER['HTTP_PAYPAL_TRANSMISSION_TIME'],
			'webhook_id' => $this->config['webhook_id'],
			'webhook_event' => $body
		);

        $verify_data = $this->_curl_request(
			$this->config['endpoint'] . '/v1/notifications/verify-webhook-signature',
			'POST',
			$request,
			array('Authorization' => 'Bearer ' . $access_token, 'Content-Type' => 'application/json')
		);
		
		if( $verify_data === false ){
			return false;
		}

		if( $verify_data['verification_status'] != 'SUCCESS' ){
			$this->message = 'Current Webhook Event Signature could not be verified.';
			return false;
		}

		if( $body['event_type'] == 'CHECKOUT.ORDER.APPROVED' ){
			$resource = $body['resource'];

			// capturing payment
			$capture_data = $this->_curl_request(
				$this->config['endpoint'] . '/v2/checkout/orders/'.$resource['id'].'/capture',
				'POST',
				array(),
				array('Authorization' => 'Bearer ' . $access_token, 'Content-Type' => 'application/json')
			);
	
			if( $verify_data === false ){
				return false;
			}
			
			if( isset($capture_data['name']) ){
				$this->message = $capture_data['message'];
				return false;
			}
	
			if( $capture_data['status'] != 'COMPLETED' ){
				switch($capture_data['status']){
					case 'CREATED':
						$this->message = 'The Order was created, but Not Paid Yet.';
						break;
					case 'SAVED':
						$this->message = 'The order was saved, but Not Paid Yet.';
						break;
					case 'VOIDED':
						$this->message = 'All purchase units in the order are voided.';
						break;
					case 'APPROVED':
						$this->message = 'This Order was paid, but not visible on Our Server. You will get complete refund in 5-7 Business days.';
						break;
					case 'PAYER_ACTION_REQUIRED':
						$this->message = 'The order requires an action from the payer.';
						break;
				}
				return false;
			}

			$purchase_unit_payment_capture = $capture_data['purchase_units'][0]['payments']['captures'][0];

			return array(
				'provider' => 'paypal',
				'order_id' => $purchase_unit_payment_capture['invoice_id'],
				'order_amount' => $purchase_unit_payment_capture['amount']['value'],
				'reference_id' => $capture_data['id'],
				'tx_status' => $capture_data['status'],
				'payment_mode' => 'unknown',
				'tx_time' => strtotime($purchase_unit_payment_capture['update_time'])
			);
		} else if( $body['event_type'] == 'CHECKOUT.ORDER.COMPLETED' ){
			$resource = $body['resource'];
			$tx_time = isset($resource['update_time']) ? $resource['update_time'] : $resource['create_time'];
			
			return array(
				'provider' => 'paypal',
				'order_id' => isset($resource['invoice_id']) ? $resource['invoice_id'] : '',
				'order_amount' => $resource['gross_amount']['value'],
				'reference_id' => $resource['id'],
				'tx_status' => $resource['status'],
				'payment_mode' => 'unknown',
				'tx_time' => strtotime($tx_time)
			);
		} else {
			$this->message = 'Not Processing Events other than `CHECKOUT.ORDER.*`.';
			return false;
		}
    }

    public function message(){
        return $this->message;
    }
    
    protected function _get_access_token(){
		if( $data = $this->CI->session->userdata('PAYPAL_AUTH_DATA') ){
			if( time() < $data['expire'] ){
				$token = $data['token'];
			} else {
				$this->CI->session->unset_userdata('PAYPAL_AUTH_DATA');
				return false;
			}
		} else {
			$response = $this->_curl_request(
				$this->config['endpoint'] . '/v1/oauth2/token',
				'POST',
				array( 'grant_type' => 'client_credentials' ),
				array( 'Accept' => 'application/json', 'Accept-Language' => 'en_US' ),
				array( 'CURLOPT_USERPWD' => $this->config['clientId'] . ':' . $this->config['clientSecret'] )
			);
			
			$this->CI->session->set_userdata('PAYPAL_AUTH_DATA', array(
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
            curl_close($curl);
            return json_decode($result, true);
        }
	}
	
	protected function _render_form($order_data){
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
			<title>Pay with Paypal</title>
			<script src="https://www.paypal.com/sdk/js?client-id=<?php echo $this->config['clientId']; ?>"></script>
		</head>
		<body>
			<div style="text-align:center; margin-top:25vh;">
				<div id="paypal-button-container"></div>
			</div>

			<script type="text/javascript">
				paypal.Buttons({
					createOrder: function (data, actions) {
						return actions.order.create(<?php echo json_encode($order_data); ?>);
					},
					onApprove: function (data, actions) {
						window.location.href = '<?php echo $this->config['redirect_url']; ?>&order_id=' + data.orderID;
					}
				}).render('#paypal-button-container');
			</script>
		</body>
		</html>
		<?php
	}
}
