<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paytm
{
    protected $config = null;
    protected $message = null;

    public function __construct($config)
    {
        $endpoints = array(
            'sandbox' => 'https://securegw-stage.paytm.in',
            'live' => 'https://securegw.paytm.in',
        );

        if ($config['sandbox'] === true) {
            $config['endpoint'] = $endpoints['sandbox'];
			$config['merchant_id'] = $config['test_merchant_id'];
			$config['merchant_key'] = $config['test_merchant_key'];
			$config['website_name'] = $config['test_website_name'];
        } else {
            $config['endpoint'] = $endpoints['live'];
			$config['merchant_id'] = $config['live_merchant_id'];
			$config['merchant_key'] = $config['live_merchant_key'];
			$config['website_name'] = $config['live_website_name'];
        }

		foreach(['test_merchant_id','test_merchant_key','test_website_name','live_merchant_id','live_merchant_key','live_website_name'] as $key){
			unset($config[$key]);
		}

        $this->config = $config;
    }

    public function pre_payment(array $data)
    {
		$name_array = explode(' ', $data['customer_name']);

		$formatted_data = array(
			'head' => array(
				'signature' => null
			),
			'body' => array(
				'requestType' => 'Payment',
				'mid' => $this->config['merchant_id'],
				'orderId' => $data['order_id'],
				'websiteName' => $this->config['website_name'],
				'txnAmount' => array(
					'value' => $data['order_amount'],
					'currency' => $data['order_currency']
				),
				'userInfo' => array(
					'custId' => isset($data['customer_id']) ? $data['customer_id'] : (int) $data['customer_contact'],
					'mobile' => $data['customer_contact'],
					'email' => $data['customer_email'],
					'firstName' => $name_array[0],
					'lastName' => isset($name_array[1]) ? $name_array[1] : ''
				),
				'callbackUrl' => $this->config['redirect_url'],
				'extendInfo' => array(
					'comments' => $data['order_note']
				)
			)
		);

		$formatted_data['head']['signature'] = $this->generateSignature(
			json_encode($formatted_data['body']),
			$this->config['merchant_key']
		);

		$response = $this->_curl_request(
			$this->config['endpoint'] . '/theia/api/v1/initiateTransaction?mid='.$this->config['merchant_id'].'&orderId='.$data['order_id'],
			'POST',
			$formatted_data,
			array( 'Content-Type' => 'application/json' )
		);

		if( isset($response['body']['resultInfo']['resultStatus']) && $response['body']['resultInfo']['resultStatus'] == 'S' ){
			$data['token'] = $response['body']['txnToken'];
		} else {
			$this->message = $response['body']['resultInfo']['resultMsg'];
			return false;
		}

		$this->_render_form($data);
		die;
    }

    public function post_payment($amount, $currency)
    {
		$paytmParams = array();
		foreach($_POST as $key => $value){
			if($key == "CHECKSUMHASH"){
				$paytmChecksum = $value;
			} else {
				$paytmParams[$key] = $value;
			}
		}

		$is_valid_checksum = $this->verifySignature(
			$paytmParams,
			$this->config['merchant_key'],
			$paytmChecksum
		);

		if($is_valid_checksum == true){
			if($paytmParams['STATUS'] == 'TXN_SUCCESS'){
				if($paytmParams['CURRENCY'] == $currency && $paytmParams['TXNAMOUNT'] >= $amount){
					return array(
						'provider' => 'paytm',
						'order_id' => $paytmParams['ORDERID'],
						'order_amount' => $paytmParams['TXNAMOUNT'],
						'reference_id' => $paytmParams['TXNID'],
						'tx_status' => $paytmParams['STATUS'],
						'payment_mode' => $paytmParams['PAYMENTMODE'],
						'tx_time' => strtotime($paytmParams['TXNDATE'])
					);
				} else {
					$formatted_data = array(
						'head' => array(
							'signature' => null
						),
						'body' => array(
							'mid' => $this->config['merchant_id'],
							'orderId' => $paytmParams['ORDERID'],
							'refId' => 'REFUND_'.$paytmParams['TXNID'],
							'txnId' => $paytmParams['TXNID'],
							'refundAmount' => $paytmParams['TXNAMOUNT'],
							'txnType' => 'REFUND',
							'comments' => 'Payment amount could not be verified.'
						)
					);
			
					$formatted_data['head']['signature'] = $this->generateSignature(
						json_encode($formatted_data['body']),
						$this->config['merchant_key']
					);
			
					$response = $this->_curl_request(
						$this->config['endpoint'] . '/refund/apply',
						'POST',
						$formatted_data,
						array( 'Content-Type' => 'application/json' )
					);
			
					if( isset($response['body']['resultInfo']['resultStatus']) && $response['body']['resultInfo']['resultStatus'] == 'PENDING' ){
						if($response['body']['resultInfo']['resultCode'] == 601){
							$this->message = 'Payment Amount Verification Failed, You will get refund in 5-7 business days.';
							return false;
						} else {
							$this->message = 'Payment Amount Verification Failed, Contact Us for Refund.';
							return false;
						}
					} else {
						$this->message = 'Payment Amount Verification Failed, ' . $response['body']['resultInfo']['resultMsg'];
						return false;
					}
				}
			} else if($paytmParams['STATUS'] == 'TXN_FAILURE') {
				$this->message = 'Payment status was not successful.';
				return false;
			} else {
				$this->message = 'Payment status was pending.';
				return false;
			}
		} else {
			$this->message = 'We could not verify the Payment Signature.';
			return false;
		}
    }

    public function webhook()
    {
		if( isset($_POST['STATUS']) && ! empty($_POST['STATUS']) ){
			if( $_POST['STATUS'] == 'TXN_SUCCESS' ){
				return array(
					'provider' => 'paytm',
                    'order_id' => $_POST['ORDERID'],
                    'order_amount' => $_POST['TXNAMOUNT'],
                    'reference_id' => $_POST['TXNID'],
                    'tx_status' => $_POST['STATUS'],
                    'payment_mode' => $_POST['PAYMENTMODE'],
                    'tx_time' => strtotime($_POST['TXNDATETIME'])
				);
			} else {
				$this->message = 'Payment status was not successful.';
				return false;
			}
		} else {
			$this->message = 'Invalid Request.';
			return false;
		}
    }

    public function message()
    {
        return $this->message;
    }

    public function _render_form($data)
    {
        ?>
        <!DOCTYPE html>
		<html>
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
			<title>Pay with Paytm</title>
		</head>
		<body>
			<div style="text-align:center; margin-top:20vh;">
				<img src="data:image/png;base64,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b3JnL2xkZi94bXAvMS4wLyIKICAgIHhtbG5zOkdJTVA9Imh0dHA6Ly93d3cuZ2ltcC5vcmcveG1wLyIKICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIKICAgIHhtbG5zOnRpZmY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vdGlmZi8xLjAvIgogICAgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIgogICB4bXBNTTpEb2N1bWVudElEPSJnaW1wOmRvY2lkOmdpbXA6ZTYwZTQzNTktOGI1Yi00NDcyLTg3YmItNGEzMTkyZDhiNTkxIgogICB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOmU1OTIyZGI1LTBlMTItNGNmZC05NmE2LWFjZGUxMTk2YzE5MCIKICAgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjM2N2Q2MzNlLTk0MjItNDM0NS1iY2EzLTgyOWU0MGIyMjQ3MyIKICAgR0lNUDpBUEk9IjIuMCIKICAgR0lNUDpQbGF0Zm9ybT0iTGludXgiCiAgIEdJTVA6VGltZVN0YW1wPSIxNjEzMTU3NTg4MDMwNDY2IgogICBHSU1QOlZlcnNpb249IjIuMTAuMjIiCiAgIGRjOkZvcm1hdD0iaW1hZ2UvcG5nIgogICB0aWZmOk9yaWVudGF0aW9uPSIxIgogICB4bXA6Q3JlYXRvclRvb2w9IkdJTVAgMi4xMCI+CiAgIDxpcHRjRXh0OkxvY2F0aW9uQ3JlYXRlZD4KICAgIDxyZGY6QmFnLz4KICAgPC9pcHRjRXh0OkxvY2F0aW9uQ3JlYXRlZD4KICAgPGlwdGNFeHQ6TG9jYXRpb25TaG93bj4KICAgIDxyZGY6QmFnLz4KICAgPC9pcHRjRXh0OkxvY2F0aW9uU2hvd24+CiAgIDxpcHRjRXh0OkFydHdvcmtPck9iamVjdD4KICAgIDxyZGY6QmFnLz4KICAgPC9pcHRjRXh0OkFydHdvcmtPck9iamVjdD4KICAgPGlwdGNFeHQ6UmVnaXN0cnlJZD4KICAgIDxyZGY6QmFnLz4KICAgPC9pcHRjRXh0OlJlZ2lzdHJ5SWQ+CiAgIDx4bXBNTTpIaXN0b3J5PgogICAgPHJkZjpTZXE+CiAgICAgPHJkZjpsaQogICAgICBzdEV2dDphY3Rpb249InNhdmVkIgogICAgICBzdEV2dDpjaGFuZ2VkPSIvIgogICAgICBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmEyYTcxODkzLTMyZDQtNGNiMS04NTkxLWUxNzRhMTJhMTg2MiIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iR2ltcCAyLjEwIChMaW51eCkiCiAgICAgIHN0RXZ0OndoZW49IiswNTozMCIvPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJzYXZlZCIKICAgICAgc3RFdnQ6Y2hhbmdlZD0iLyIKICAgICAgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDoxNDZkYjI3ZS02MzQ5LTQ1YzItOWUyYS03YTE0YTEwODkxOGIiCiAgICAgIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkdpbXAgMi4xMCAoTGludXgpIgogICAgICBzdEV2dDp3aGVuPSIrMDU6MzAiLz4KICAgIDwvcmRmOlNlcT4KICAgPC94bXBNTTpIaXN0b3J5PgogICA8cGx1czpJbWFnZVN1cHBsaWVyPgogICAgPHJkZjpTZXEvPgogICA8L3BsdXM6SW1hZ2VTdXBwbGllcj4KICAgPHBsdXM6SW1hZ2VDcmVhdG9yPgogICAgPHJkZjpTZXEvPgogICA8L3BsdXM6SW1hZ2VDcmVhdG9yPgogICA8cGx1czpDb3B5cmlnaHRPd25lcj4KICAgIDxyZGY6U2VxLz4KICAgPC9wbHVzOkNvcHlyaWdodE93bmVyPgogICA8cGx1czpMaWNlbnNvcj4KICAgIDxyZGY6U2VxLz4KICAgPC9wbHVzOkxpY2Vuc29yPgogIDwvcmRmOkRlc2NyaXB0aW9uPgogPC9yZGY6UkRGPgo8L3g6eG1wbWV0YT4KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAg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" style="width:200px;">
			</div>
			<script type="text/javascript">
				function on_paytm_load(){
					var config = {
						'root': '',
						'flow': 'DEFAULT',
						'data': {
							'orderId': '<?php echo $data['order_id']; ?>',
							'token': '<?php echo $data['token']; ?>',
							'tokenType': 'TXN_TOKEN',
							'amount': '<?php echo $data['order_amount']; ?>'
						},
						'handler': {
							'notifyMerchant': function(event,data){
								console.log({
									'info':'notifyMerchant',
									'event': event,
									'data': data
								});
							}
						}
					};

					if(window.Paytm && window.Paytm.CheckoutJS){
						window.Paytm.CheckoutJS.onLoad(function excecuteAfterCompleteLoad() {
							window.Paytm.CheckoutJS.init(config).then(function onSuccess() {
								window.Paytm.CheckoutJS.invoke();
							}).catch(function onError(error){
								console.log({
									'info':'error',
									'data': error
								});
							});
						});
					}
				}
			</script>
			<script type="text/javascript" crossorigin="anonymous" src="<?php echo $this->config['endpoint']; ?>/merchantpgpui/checkoutjs/merchants/<?php echo $this->config['merchant_id']; ?>.js" onload="on_paytm_load();"> </script>
		</body>
		</html>
        <?php
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

	// PaytmChecksum Utility
	private $iv = "@@@@&&&&####$$$$";

	private function encrypt($input, $key) {
		$key = html_entity_decode($key);

		if(function_exists('openssl_encrypt')){
			$data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, $this->iv );
		} else {
			$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
			$input = $this->pkcs5Pad($input, $size);
			$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
			mcrypt_generic_init($td, $key, $this->iv);
			$data = mcrypt_generic($td, $input);
			mcrypt_generic_deinit($td);
			mcrypt_module_close($td);
			$data = base64_encode($data);
		}
		return $data;
	}

	private function decrypt($encrypted, $key) {
		$key = html_entity_decode($key);
		
		if(function_exists('openssl_decrypt')){
			$data = openssl_decrypt ( $encrypted , "AES-128-CBC" , $key, 0, $this->iv );
		} else {
			$encrypted = base64_decode($encrypted);
			$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
			mcrypt_generic_init($td, $key, $this->iv);
			$data = mdecrypt_generic($td, $encrypted);
			mcrypt_generic_deinit($td);
			mcrypt_module_close($td);
			$data = $this->pkcs5Unpad($data);
			$data = rtrim($data);
		}
		return $data;
	}

	private function generateSignature($params, $key) {
		if(!is_array($params) && !is_string($params)){
			throw new Exception("string or array expected, ".gettype($params)." given");			
		}
		if(is_array($params)){
			$params = $this->getStringByParams($params);			
		}
		return $this->generateSignatureByString($params, $key);
	}

	private function verifySignature($params, $key, $checksum){
		if(!is_array($params) && !is_string($params)){
			throw new Exception("string or array expected, ".gettype($params)." given");
		}
		if(isset($params['CHECKSUMHASH'])){
			unset($params['CHECKSUMHASH']);
		}
		if(is_array($params)){
			$params = $this->getStringByParams($params);
		}		
		return $this->verifySignatureByString($params, $key, $checksum);
	}

	private function generateSignatureByString($params, $key){
		$salt = $this->generateRandomString(4);
		return $this->calculateChecksum($params, $key, $salt);
	}

	private function verifySignatureByString($params, $key, $checksum){
		$paytm_hash = $this->decrypt($checksum, $key);
		$salt = substr($paytm_hash, -4);
		return $paytm_hash == $this->calculateHash($params, $salt) ? true : false;
	}

	private function generateRandomString($length) {
		$random = "";
		srand((double) microtime() * 1000000);

		$data = "9876543210ZYXWVUTSRQPONMLKJIHGFEDCBAabcdefghijklmnopqrstuvwxyz!@#$&_";	

		for ($i = 0; $i < $length; $i++) {
			$random .= substr($data, (rand() % (strlen($data))), 1);
		}

		return $random;
	}

	private function getStringByParams($params) {
		ksort($params);		
		$params = array_map(function ($value){
			return ($value !== null && strtolower($value) !== "null") ? $value : "";
	  	}, $params);
		return implode("|", $params);
	}

	private function calculateHash($params, $salt){
		$finalString = $params . "|" . $salt;
		$hash = hash("sha256", $finalString);
		return $hash . $salt;
	}

	private function calculateChecksum($params, $key, $salt){
		$hashString = $this->calculateHash($params, $salt);
		return $this->encrypt($hashString, $key);
	}

	private function pkcs5Pad($text, $blocksize) {
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
	}

	private function pkcs5Unpad($text) {
		$pad = ord($text[strlen($text) - 1]);
		if ($pad > strlen($text))
			return false;
		return substr($text, 0, -1 * $pad);
	}
}
