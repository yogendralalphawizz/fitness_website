<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Amazonpay {
	protected $CI = null;
    protected $config = null;
    protected $message = null;

    public function __construct($config){
		$this->config = $config;
		$mws_endpoint_urls = [ 'us' => 'mws.amazonservices.com', 'eu' => 'mws-eu.amazonservices.com', 'na' => 'mws.amazonservices.com', 'jp' => 'mws.amazonservices.jp' ];
		$this->config['mws_endpoint_url'] = $mws_endpoint_urls[ $this->config['region'] ];
		
		$modePath = ($this->config['sandbox'] == true) ? 'OffAmazonPayments_Sandbox' : 'OffAmazonPayments';
		$this->config['mws_service_url'] = 'https://' . $this->config['mws_endpoint_url'] . '/' . $modePath . '/2013-01-01';
		$this->config['mws_endpoint_path'] = '/' . $modePath . '/2013-01-01';
		
		$this->CI =& get_instance();
		$this->CI->load->library('session');
    }

    public function pre_payment( array $data ){
		if( isset($_POST['orderReferenceId']) && isset($_POST['accessToken']) && ! empty($_POST['orderReferenceId']) && ! empty($_POST['accessToken']) ){
			$parameters = [
				'AmazonOrderReferenceId' => $_POST['orderReferenceId'],
				'OrderReferenceAttributes.OrderTotal.CurrencyCode' => $data['order_currency'],
				'OrderReferenceAttributes.OrderTotal.Amount' => $data['order_amount'],
				'OrderReferenceAttributes.SellerNote' => $data['order_note'],
				'OrderReferenceAttributes.SellerOrderAttributes.SellerOrderId' => $data['order_id'],
				'OrderReferenceAttributes.SellerOrderAttributes.CustomInformation' => json_encode([
					'customer_name' => $data['customer_name'],
					'customer_email' => $data['customer_email'],
					'customer_contact' => $data['customer_contact']
				]),
				'AWSAccessKeyId' => $this->config['mws_access_key'],
				'Action' => 'SetOrderReferenceDetails',
				'SellerId' => $this->config['merchant_id'],
				'SignatureMethod' => 'HmacSHA256',
				'SignatureVersion' => 2,
				'Timestamp' => gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time()),
				'Version' => '2013-01-01'
			];
			
			$parameters['Signature'] = $this->_sign_parameters($parameters);
			
			$queryParameters = array();
			foreach ($parameters as $key => $value) {
				$queryParameters[] = $key . '=' . str_replace('%7E', '~', rawurlencode($value));
			}
			
			$parameters = implode('&', $queryParameters);
			
			$response = $this->_curl_request( $this->config['mws_service_url'], 'POST', $parameters );
			if( $response && ! isset($response['Error']) ){
				$this->CI->session->set_userdata('AMAZON_ORDER_REFERENCE_ID', $_POST['orderReferenceId']);
				echo json_encode([ 'status' => 1, 'message' => 'Success' ]);
			} else {
				echo json_encode([ 'status' => 0,'message' => $response['Error']['Message'] ]);
			}
		} else {
			$this->_render_form();
			die;
		}
    }

    public function post_payment($amount, $currency){
		if( $order_reference_id = $this->CI->session->userdata('AMAZON_ORDER_REFERENCE_ID') ){
			$this->CI->session->unset_userdata('AMAZON_ORDER_REFERENCE_ID');
		} else {
			$this->message = 'Invalid Payment Request.';
			return false;
		}
		
		$parameters = [
			'AmazonOrderReferenceId' => $order_reference_id,
			'AWSAccessKeyId' => $this->config['mws_access_key'],
			'Action' => 'ConfirmOrderReference',
			'SellerId' => $this->config['merchant_id'],
			'SignatureMethod' => 'HmacSHA256',
			'SignatureVersion' => 2,
			'Timestamp' => gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time()),
			'Version' => '2013-01-01'
		];
		
		$parameters['Signature'] = $this->_sign_parameters($parameters);
		
		$queryParameters = array();
		foreach ($parameters as $key => $value) {
			$queryParameters[] = $key . '=' . str_replace('%7E', '~', rawurlencode($value));
		}
		$queryParameters = implode('&', $queryParameters);
		
		$response = $this->_curl_request( $this->config['mws_service_url'], 'POST', $queryParameters );
		
		if( $response && ! isset($response['Error']) ){
			$parameters = [
				'AmazonOrderReferenceId' => $order_reference_id,
				'AuthorizationAmount.Amount' => $amount,
				'AuthorizationAmount.CurrencyCode' => $currency,
				'AuthorizationReferenceId' => uniqid(),
				'CaptureNow' => true,
				'SellerAuthorizationNote' => 'Authorizing and capturing the payment',
				'TransactionTimeout' => 0,
				'SoftDescriptor' => null,
				'AWSAccessKeyId' => $this->config['mws_access_key'],
				'Action' => 'Authorize',
				'SellerId' => $this->config['merchant_id'],
				'SignatureMethod' => 'HmacSHA256',
				'SignatureVersion' => 2,
				'Timestamp' => gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time()),
				'Version' => '2013-01-01'
			];
			
			$parameters['Signature'] = $this->_sign_parameters($parameters);
			
			$queryParameters = array();
			foreach ($parameters as $key => $value) {
				$queryParameters[] = $key . '=' . str_replace('%7E', '~', rawurlencode($value));
			}
			$queryParameters = implode('&', $queryParameters);
			
			$response1 = $this->_curl_request( $this->config['mws_service_url'], 'POST', $queryParameters );
			if( $response1 && ! isset($response1['Error']) ){
				return array(
					'provider' => 'amazonpay',
                    'order_id' => $order_reference_id,
                    'order_amount' => $response1['AuthorizeResult']['AuthorizationDetails']['CapturedAmount']['Amount'],
                    'reference_id' => $response1['AuthorizeResult']['AuthorizationDetails']['AmazonAuthorizationId'],
                    'tx_status' => $response1['AuthorizeResult']['AuthorizationDetails']['AuthorizationStatus']['State'],
                    'payment_mode' => 'unknown',
                    'tx_time' => strtotime($response1['AuthorizeResult']['AuthorizationDetails']['CreationTimestamp'])
				);
			} else {
				$this->message = $response1['Error']['Message'];
				return false;
			}
		} else {
			$this->message = $response['Error']['Message'];
			return false;
		}
    }

    public function webhook(){
        $body = json_decode( @file_get_contents('php://input'), true );
        
        if( isset($_SERVER['HTTP_X_AMZ_SNS_MESSAGE_TYPE']) && $_SERVER['HTTP_X_AMZ_SNS_MESSAGE_TYPE'] == 'Notification' ){
			if( isset($body['Type']) && $body['Type'] == 'Notification' ){
				$signatureFields = array();
				foreach(['Message','MessageId','Subject','Timestamp','TopicArn','Type'] as $field){
					if( $field == 'Subject' && ! isset($body[ $field ]) ){ continue; }
					array_push($signatureFields, $field);
                    array_push($signatureFields, $body[ $field ]);
				}
				$signatureFields = implode("\n", $signatureFields) . "\n";
				
				$received_signature = base64_decode( $body['Signature'] );
				$cert_path = $body['SigningCertURL'];
				
				$parsed = parse_url($cert_path);
				if( empty($parsed['scheme']) || empty($parsed['host']) || $parsed['scheme'] !== 'https' || substr($cert_path, -4) !== '.pem' || !preg_match('/^sns\.[a-zA-Z0-9\-]{3,}\.amazonaws\.com(\.cn)?$/', $parsed['host']) ){
					$this->message = 'Invalid IPN Notification.';
					return false;
				} else {
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, $cert_path);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return instead of echo
					curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // follow redirection
					curl_setopt($curl, CURLOPT_TIMEOUT, 10); // timeout
					curl_setopt($curl, CURLOPT_USERAGENT, 'PHP/'. phpversion() .' ('. php_uname('s') .' '. php_uname('r') .') '. php_uname('n') .' Cashier/1.0');
					curl_setopt($curl, CURLOPT_PORT, 443);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
					curl_setopt($curl, CURLOPT_HTTPHEADER, array());
					$cert = curl_exec($curl);
					
					if($cert === false){
						$this->message = curl_error($curl);
						curl_close($curl);
						return false;
					} else {
						curl_close($curl);
					}
					
					$certKey = openssl_get_publickey($cert);
					
					if($certKey === false) {
						$this->message = 'Unable to extract public key from cert.';
						return false;
					}
					
					$certInfo = openssl_x509_parse($cert, true);
					$certSubject = $certInfo["subject"];
					if(is_null($certSubject)) {
						$this->message = 'Error with certificate - subject cannot be found.';
						return false;
					}
					
					if (strcmp($certSubject["CN"], 'sns.amazonaws.com')) {
						$this->message = 'Unable to verify certificate issued by Amazon - error with certificate subject.';
						return false;
					}
					
					$result = -1;
					try {
						$result = openssl_verify($signatureFields, $received_signature, $certKey, OPENSSL_ALGO_SHA1);
					} catch (\Exception $ex) {
						$this->message = 'Unable to verify signature - error with the verification algorithm.';
						return false;
					}
					
					if( $result > 0 ){
						$body = json_decode($body['Message'], true);
						if( $body['NotificationType'] == 'PaymentCapture' ){
							$body = json_decode( json_encode( simplexml_load_string($body['NotificationData']) ), true)['CaptureDetails'];

							$temp = explode('-', $body['AmazonCaptureId']); unset($temp[3]);
							
							return array(
								'provider' => 'amazonpay',
								'order_id' => implode('-', $temp),
								'order_amount' => $body['CaptureAmount']['Amount'],
								'reference_id' => $body['AmazonCaptureId'],
								'tx_status' => $body['CaptureStatus']['State'],
								'payment_mode' => 'unknown',
								'tx_time' => strtotime($body['CaptureStatus']['LastUpdateTimestamp'])
							);
						} else {
							$this->message = 'Not listening for other events except capturing.';
							return false;
						}
					} else {
						$this->message = 'Unable to match signature from remote server.';
						return false;
					}
				}
			} else {
				$this->message = 'Invalid IPN Notification.';
				return false;
			}
        } else {
			$this->message = 'Invalid IPN Notification.';
			return false;
        }
    }

    public function message(){
        return $this->message;
    }
    
    protected function _curl_request($url, $method = 'POST', $post_string = ''){
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return instead of echo
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // follow redirection
		curl_setopt($curl, CURLOPT_TIMEOUT, 10); // timeout
		curl_setopt($curl, CURLOPT_USERAGENT, 'PHP/'. phpversion() .' ('. php_uname('s') .' '. php_uname('r') .') '. php_uname('n') .' Cashier/1.0');
		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array());
		
		if( $method == 'POST' ){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_string);
		}

		$result = curl_exec($curl);

        if($result === false){
            $this->message = curl_error($curl);
            curl_close($curl);
            return false;
        } else {
            curl_close($curl);
            $result = new SimpleXMLElement($result);
            return json_decode( json_encode($result), true );
        }
	}

    protected function _render_form(){
		$sandbox = '';
		if( $this->config['sandbox'] == true ){ $sandbox = 'sandbox/'; }
		$amazon_widget_js_url = 'https://static-na.payments-amazon.com/OffAmazonPayments/' . $this->config['region'] . '/' . $sandbox . 'js/Widgets.js';
		?>
		<!DOCTYPE html>
		<html lang="en">
			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<title>Pay with Amazon</title>
				<script type='text/javascript' src="<?php echo $amazon_widget_js_url; ?>" async></script>
			</head>

			<body>
				<div style="text-align:center; margin-top:20vh;">
					<div id="amazon_pay_step1">
						<p>Login with <span style="color: #ff9800; font-weight:bold;">Amazon Pay</span> and Proceed to Payment by Clicking the following button.</p>
						<div class="text-center" style="margin-top:40px;" id="AmazonPayButton"></div>
					</div>
					<div id="amazon_pay_step2" style="display:none;">
						<img src="data:image/png;base64,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" style="width:200px;">
						<br><br>
						<div id="walletWidgetDiv" style="width:400px; height:240px; display:inline-block;"></div>
						<form style="margin-top:40px;" role="form" method="post" action="<?php echo $this->config['redirect_url']; ?>">
                            <button style="padding: 15px;color: white;background: #ff9800;border: none;border-radius: 5px; cursor:pointer;">Pay Now</button>
                        </form>
					</div>
				</div>
				<script type='text/javascript'>
					function redirect_back(){
						var referer = '<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''; ?>';
						if( referer != ''){
							window.location.href = referer;
						} else {
							window.history.back();
						}
					}

					window.onAmazonLoginReady = function () {
						try {
							amazon.Login.setClientId("<?php echo $this->config['client_id']; ?>");
							amazon.Login.setUseCookie(true);
						} catch (err) {
							console.log('Error1 : ' + JSON.stringify(err));
						}
					};

					var amazon_pay_access_token = null;
					window.onAmazonPaymentsReady = function () {
						OffAmazonPayments.Button("AmazonPayButton", "<?php echo $this->config['merchant_id']; ?>", {
							type: "PwA",       // PwA, Pay, A, LwA, Login
							color: "Gold", // Gold, LightGray, DarkGray
							size: "large",    // small, medium, large, x-large
							language: "en-GB", // for Europe/UK regions only: en-GB, de-DE, fr-FR, it-IT, es-ES
							authorization: function() {
								loginOptions = { scope: "profile payments:widget", popup: true };
								var authRequest = amazon.Login.authorize(loginOptions, function(response){
									if ( response.error ) {
										alert('Internal Error Occured, redirecting you back...');
										console.log('Error2 : ' + response.error);
										redirect_back();
									}
									
									document.querySelector('#amazon_pay_step1').style.display = 'none';
									document.querySelector('#amazon_pay_step2').style.display = 'block';
									
									amazon_pay_access_token = response.access_token;

									new OffAmazonPayments.Widgets.Wallet({
										sellerId: "<?php echo $this->config['merchant_id']; ?>",
										design: { designMode: 'responsive' },
										onOrderReferenceCreate: function (orderReference){
											var xhr = new XMLHttpRequest();
											xhr.open("POST", '<?php echo $_SERVER['REQUEST_URI']; ?>', true);
											xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
											xhr.onreadystatechange = function() {
												if (this.readyState == 4 && this.status == 200) {
													var message = JSON.parse(this.responseText);
													if(message.status != 1){
														alert('Internal Error Occured, redirecting you back...');
														console.log('Error5 : ' + message.message);
														redirect_back();
													}
												}
											};
											xhr.send('orderReferenceId='+orderReference.getAmazonOrderReferenceId()+'&accessToken='+amazon_pay_access_token);
										},
										onError: function (error) {
											alert('Internal Error Occured, redirecting you back...');
											console.log('Error3 : ' + error.getErrorMessage());
											redirect_back();
										}
									}).bind("walletWidgetDiv");
								});
							},
							onError: function(error) {
								alert('Internal Error Occured, redirecting you back...');
								console.log('Error4 : ' + response.error);
								redirect_back();
							}
						});

						window.addEventListener("unload", function() {
							amazon.Login.logout();
							document.cookie = "amazon_Login_accessToken=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
						});
					};
				</script>
			</body>
		</html>
		<?php
    }
    
    private function _sign_parameters($parameters){
		uksort($parameters, 'strcmp');
		
		$stringToSign = 'POST';
		$stringToSign .= "\n";
		$stringToSign .= $this->config['mws_endpoint_url'];
		$stringToSign .= "\n";
		$stringToSign .= $this->config['mws_endpoint_path'];
		$stringToSign .= "\n";

		$queryParameters = array();
		foreach ($parameters as $key => $value) {
			$queryParameters[] = $key . '=' . str_replace('%7E', '~', rawurlencode($value));
		}
		$stringToSign .= implode('&', $queryParameters);

		return base64_encode(hash_hmac('sha256', $stringToSign, $this->config['mws_secret_key'], true));
    }
}
