<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stripe {
    protected $CI = null;
    protected $config = null;
    protected $message = null;
	
    public function __construct($config){
        $config['endpoint'] = 'https://api.stripe.com';
        
        if($config['sandbox'] === true){
            $config['key'] = $config['sandbox_key'];
            $config['secret'] = $config['sandbox_secret'];
        } else {
            $config['key'] = $config['live_key'];
            $config['secret'] = $config['live_secret'];
        }
        
        $this->config = $config;

        $this->CI =& get_instance();
        $this->CI->load->library('session');
    }

    public function pre_payment( array $data ){
        $url = $this->config['endpoint'] . '/v1/checkout/sessions';
        
        // see : https://stripe.com/docs/currencies#zero-decimal
		if( ! in_array( $data['order_currency'], ['BIF','CLP','DJF','GNF','JPY','KMF','KRW','MGA','PYG','RWF','UGX','VND','VUV','XAF','XOF','XPF']) ){
			$data['order_amount'] = $data['order_amount'] * 100;
		}
		
        $request = [
			'success_url' => $this->config['redirect_url'],
			'cancel_url' => $this->config['redirect_url'],
			'mode' => 'payment',
			'payment_method_types' => ['card'],
			'client_reference_id' => $data['order_id'],
			'customer_email' => $data['customer_email'],
			'line_items' => array(
				array(
					'price_data' => array(
						'currency' => strtolower($data['order_currency']),
						'unit_amount_decimal' => $data['order_amount'],
						'product_data' => array(
							'name' => 'Invoice : ' . $data['order_id']
						)
					),
					'description' => (empty($data['order_note']) ? 'Invoice : ' . $data['order_id'] : $data['order_note']),
					'quantity' => 1
				)
			),
			'metadata' => array(
				'customer_name' => $data['customer_name'],
				'customer_contact' => $data['customer_contact']
			),
			'payment_intent_data' => array(
				'capture_method' => 'manual'
			)
        ];

		$response = $this->_curl_request(
			$url,
			'POST',
			$request,
			[ 'Authorization' => 'Bearer ' . $this->config['secret'] ],
			[ 'CURLOPT_IPRESOLVE' => 1 ]
		);
		
		if( $response === false ){
			return false;
		}

		if( isset($response['error']) ){
			$this->message = $response['error']['message'];
			return false;
		}
		
		if( ! isset($response['id']) ){
			$this->message = 'Internal Error Occured while initializing Payment Session.';
			return false;
		}

        $this->CI->session->set_userdata('STRIPE_CHECKOUT_SESSION_ID', $response['id']);

		$this->_render_form($response);
		die;
    }

    public function post_payment($amount, $currency){
        if( $session_id = $this->CI->session->userdata('STRIPE_CHECKOUT_SESSION_ID') ){
            $this->CI->session->unset_userdata('STRIPE_CHECKOUT_SESSION_ID');
        } else {
			$this->message = 'Payment Request is not valid, Any amount deducted will be refunded in 5-7 days.';
			return false;
        }

		$response = $this->_curl_request(
			$this->config['endpoint'] . '/v1/checkout/sessions/' . $session_id,
			'GET',
			[ ],
			[ 'Authorization' => 'Bearer ' . $this->config['secret'] ],
			[ 'CURLOPT_IPRESOLVE' => 1 ]
		);
		
		if( $response === false ){
			return false;
		}

        if( isset($response['error']) ){
            $this->message = $response['error']['message'];
            if($response['error']['type'] == 'invalid_request_error'){
                $this->message = 'Payment Request is not valid, Any amount deducted will be refunded in 5-7 days.';
            }
            return false;
        }

        $paymentIntent = $this->_curl_request(
            $this->config['endpoint'] . '/v1/payment_intents/' . $response['payment_intent'],
            'GET',
            [ ],
            [ 'Authorization' => 'Bearer ' . $this->config['secret'] ],
            [ 'CURLOPT_IPRESOLVE' => 1 ]
        );
        
        if( $paymentIntent === false ){
			return false;
		}
        
        if( isset($paymentIntent['error']) ){
            $this->message = $paymentIntent['error']['message'];
            return false;
        }
        
		switch($paymentIntent['status']){
			case 'requires_payment_method':
				$this->message = 'Payment request is not attached to any payment method.';
				return false;
			case 'requires_confirmation':
				$this->message = 'Payment request is need to be confirmed.';
				return false;
			case 'requires_action':
				$this->message = 'Payment request requires an action to be performed.';
				return false;
			case 'succeeded':
				// see : https://stripe.com/docs/currencies#zero-decimal
				if( ! in_array( $currency, ['BIF','CLP','DJF','GNF','JPY','KMF','KRW','MGA','PYG','RWF','UGX','VND','VUV','XAF','XOF','XPF']) ){
					$paymentIntent['amount_received'] = $paymentIntent['amount_received'] / 100;
				}
				
				return array(
					'provider' => 'stripe',
					'order_id' => $response['client_reference_id'],
					'order_amount' => $paymentIntent['amount_received'],
					'reference_id' => $paymentIntent['id'],
					'tx_status' => $paymentIntent['status'],
					'payment_mode' => $paymentIntent['charges']['data'][0]['payment_method_details']['type'],
					'tx_time' => $paymentIntent['charges']['data'][0]['created']
				);
			case 'processing':
				$this->message = 'Payment request is being processed on Stripe.';
				return false;
			case 'canceled':
				$this->message = 'Payment request has been cancelled.';
				return false;
		}

        // see : https://stripe.com/docs/currencies#zero-decimal
        if( ! in_array( $currency, ['BIF','CLP','DJF','GNF','JPY','KMF','KRW','MGA','PYG','RWF','UGX','VND','VUV','XAF','XOF','XPF']) ){
            $amount = $amount * 100;
        }

        $captured = $this->_curl_request(
            $this->config['endpoint'] . '/v1/payment_intents/' . $response['payment_intent'] . '/capture',
            'POST',
            [ 'amount_to_capture' => $amount ],
            [ 'Authorization' => 'Bearer ' . $this->config['secret'] ],
            [ 'CURLOPT_IPRESOLVE' => 1 ]
        );
        
        if( $captured === false ){
			return false;
		}
        
        if( isset($captured['error']) ){
			if($captured['error']['code'] == 'amount_too_large'){
				$this->message = 'Paid Amount is lower than Expected Amount, Any amount deducted will be refunded in 5-7 days.';
				return false;
			} else if($captured['error']['message'] == 'This PaymentIntent could not be captured because it has already been captured.'){
				$this->message = 'This Payment Request is already processed.';
				return false;
			} else {
				$this->message = $captured['error']['message'];
				return false;
			}
		}

		switch($captured['status']){
			case 'requires_payment_method':
				$this->message = 'Payment request is not attached to any payment method.';
				break;
			case 'requires_confirmation':
				$this->message = 'Payment request is need to be confirmed.';
				break;
			case 'requires_action':
				$this->message = 'Payment request requires an action to be performed.';
				break;
			case 'succeeded':
				// see : https://stripe.com/docs/currencies#zero-decimal
				if( ! in_array( $currency, ['BIF','CLP','DJF','GNF','JPY','KMF','KRW','MGA','PYG','RWF','UGX','VND','VUV','XAF','XOF','XPF']) ){
					$captured['amount_received'] = $captured['amount_received'] / 100;
				}
				
				return array(
					'provider' => 'stripe',
					'order_id' => $response['client_reference_id'],
					'order_amount' => $captured['amount_received'],
					'reference_id' => $captured['id'],
					'tx_status' => $captured['status'],
					'payment_mode' => $captured['charges']['data'][0]['payment_method_details']['type'],
					'tx_time' => $captured['charges']['data'][0]['created']
				);
				break;
			case 'processing':
				$this->message = 'Payment request is being processed on Stripe.';
				break;
			case 'canceled':
				$this->message = 'Payment request has been cancelled.';
				break;
		}
		
		return false;
    }

    public function webhook(){
		$payload = @file_get_contents('php://input');
		
		$formatted_header_items = [];
		$header_items = explode(',', $_SERVER['HTTP_STRIPE_SIGNATURE']);
		foreach($header_items as $header_item){
			$header_item_parts = explode('=', $header_item, 2);
			$formatted_header_items[ $header_item_parts[0] ] = $header_item_parts[1];
		}
		
		$hash_hmac = hash_hmac('sha256', $formatted_header_items['t'] . $payload, $this->config['webhook_secret']);
		
		if( hash_equals($hash_hmac, $formatted_header_items['v1']) && ( time() - $formatted_header_items['t'] <= 300 ) ){
			$this->message = 'Signature did not matched or Timestamp outside the tolerance zone.';
			return false;
		} else {
			$payload = json_decode( $payload, true );
			
			if( $payload['type'] == 'payment_intent.succeeded' ){
				$response = $payload['data']['object'];
				
				return array(
					'provider' => 'stripe',
					'order_id' => $response['metadata']['order_id'],
					'order_amount' => $response['amount_received'],
					'reference_id' => $response['id'],
					'tx_status' => $response['status'],
					'payment_mode' => 'card',
					'tx_time' => $response['created']
				);
			}
			
			return false;
		}
    }

    public function message(){
        return $this->message;
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
    
    private function _render_form($session){
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
			<title>Pay with Stripe</title>
			<script src="https://js.stripe.com/v3/"></script>
			<style type="text/css">
            #checkout-button{
                padding: 10px;
                background: #2196f3;
                border: 0px;
                border-radius: 5px;
                font-size: 15px;
                cursor:pointer;
                color:white;
            }
            </style>
		</head>
		<body>
			<div style="text-align:center; margin-top:25vh;">
				<img src="data:image/png;base64,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" style="width:200px;">
                <br><br>
				<button id="checkout-button">Pay with Stripe</button>
			</div>

			<script type="text/javascript">
				var stripe = Stripe('<?php echo $this->config['key']; ?>');
			
				stripe.redirectToCheckout({ sessionId: '<?php echo $session['id']; ?>' }).then(function(result){
					if (result.error) {
						window.location.href = '<?php echo $this->config['redirect_url']; ?>&error=' + result.error.message
					}
				});
			</script>
		</body>
		</html>
		<?php
    }
}
