<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payumoney {
	protected $CI = null;
    protected $config = null;
    protected $message = null;

    public function __construct($config){
        if( $config['sandbox'] === true ){
			$config['js_library_url'] = 'https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js'; // sanbox
        } else {
			$config['js_library_url'] = 'https://checkout-static.citruspay.com/bolt/run/bolt.min.js'; // live
        }
		$this->config = $config;
    }

    public function pre_payment( array $data ){
		$this->CI =& get_instance();
		
		$customer_name_arr = explode(' ', $data['customer_name']);
		$data['firstname'] = $customer_name_arr[0];
		$data['lastname'] = isset($customer_name_arr[1]) ? $customer_name_arr[1] : '';
		unset($data['customer_name']);
		
		if( empty($data['order_note']) ){
			$data['order_note'] = 'Invoice : ' . $data['order_id'];
		}
		
		$data['hash'] = $this->_generate_hash($data, 'pre');
		
		$this->_render_form($data);
		die;
    }

    public function post_payment($amount, $currency){
		$computed_hash = $this->_generate_hash( $_POST, 'post' );
		
		if( isset($_POST['status']) && isset($_POST['hash']) && $_POST['status'] == 'success'){
			if($computed_hash == $_POST['hash']){
				return array(
					'provider' => 'payumoney',
					'order_id' => $_POST['txnid'],
					'order_amount' => $_POST['amount'],
					'reference_id' => $_POST['payuMoneyId'],
					'tx_status' => $_POST['txnStatus'],
					'payment_mode' => $_POST['bankcode'],
					'tx_time' => strtotime($_POST['addedon'])
				);
			} else {
				$this->message = 'We could not verify the payment signature.';
				return false;
			}
		} else {
			$this->message = 'Invalid Payment Request.';
			return false;
		}
    }

    public function webhook(){
		$key = str_replace( '-', '_', strtoupper('HTTP-'$this->config['webhookAuthHeader']['key']) );
		
		if( isset($_SERVER[$key]) && $_SERVER[$key] == $this->config['webhookAuthHeader']['value'] ){
			$payload = file_get_contents('php://input');
			$payload = json_decode($payload, true);
			
			if($payload['status'] == 'Success'){
				return array(
					'provider' => 'payumoney',
					'order_id' => $payload['merchantTransactionId'],
					'order_amount' => $payload['amount'],
					'reference_id' => $payload['paymentId'],
					'tx_status' => $payload['status'],
					'payment_mode' => $payload['paymentMode'],
					'tx_time' => time()
				);
			} else {
				$this->message = 'Not Processing Events other than `Success`.';
				return false;
			}
		} else {
			$this->message = 'Invalid or missing '.$this->config['webhookAuthHeader']['key'].' header.';
			return false;
		}
    }

    public function message(){
        return $this->message;
    }

    // $type = pre | post
    protected function _generate_hash($data, $type = 'pre'){
		if( $type == 'pre' ){
			$data = [
				$this->config['key'], $data['order_id'], $data['order_amount'], $data['order_note'], $data['firstname'], $data['customer_email'],
				isset($data['udf1']) ? $data['udf1'] : '', isset($data['udf2']) ? $data['udf2'] : '', isset($data['udf3']) ? $data['udf3'] : '',
				isset($data['udf4']) ? $data['udf4'] : '', isset($data['udf5']) ? $data['udf5'] : '', isset($data['udf6']) ? $data['udf6'] : '',
				isset($data['udf7']) ? $data['udf7'] : '', isset($data['udf8']) ? $data['udf8'] : '', isset($data['udf9']) ? $data['udf9'] : '',
				isset($data['udf10']) ? $data['udf10'] : '', $this->config['salt']
			];
		} else {
			$data = [
				$this->config['salt'], isset($data['status']) ? $data['status'] : '', isset($data['udf10']) ? $data['udf10'] : '',
				isset($data['udf9']) ? $data['udf9'] : '', isset($data['udf8']) ? $data['udf8'] : '', isset($data['udf7']) ? $data['udf7'] : '',
				isset($data['udf6']) ? $data['udf6'] : '', isset($data['udf5']) ? $data['udf5'] : '', isset($data['udf4']) ? $data['udf4'] : '',
				isset($data['udf3']) ? $data['udf3'] : '', isset($data['udf2']) ? $data['udf2'] : '', isset($data['udf1']) ? $data['udf1'] : '',
				isset($data['email']) ? $data['email'] : '', isset($data['firstname']) ? $data['firstname'] : '', isset($data['productinfo']) ? $data['productinfo'] : '', 
				isset($data['amount']) ? $data['amount'] : '', isset($data['txnid']) ? $data['txnid'] : '', $this->config['key']
			];
		}

		return strtolower(hash('sha512', implode('|', $data)));
    }
    
	protected function _render_form($order_data){
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<title>Pay with PayUmoney</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" >
			<script id="bolt" src="<?php echo $this->config['js_library_url']; ?>" bolt-color="e34524" bolt-logo="<?php echo rtrim($this->CI->config->base_url(), '/') . $this->config['merchantLogoPath']; ?>"></script>
		</head>
		<body style="margin:0px;">
			<script type="text/javascript">
				bolt.launch({
					key: '<?php echo addslashes($this->config['key']); ?>',
					hash: '<?php echo addslashes($order_data['hash']); ?>',
					surl : '<?php echo addslashes($this->config['redirect_url']); ?>',
					furl: '<?php echo addslashes($this->config['redirect_url']); ?>',
					mode: 'dropout',
					txnid: '<?php echo addslashes($order_data['order_id']); ?>', 
					amount: '<?php echo addslashes($order_data['order_amount']); ?>',
					firstname: '<?php echo addslashes($order_data['firstname']); ?>',
					lastname: '<?php echo addslashes($order_data['lastname']); ?>',
					email: '<?php echo addslashes($order_data['customer_email']); ?>',
					phone: '<?php echo addslashes($order_data['customer_contact']); ?>',
					productinfo: '<?php echo addslashes($order_data['order_note']); ?>'
				}, {
					responseHandler: function(BOLT){
						console.log(BOLT.response);
						if(BOLT.response.status == 'CANCEL'){
							window.location.href = '<?php echo $this->config['redirect_url']; ?>&txnStatus=CANCEL&txnMessage=Payment+Cancelled+By+Customer.';
						}
					},
					catchException: function(BOLT){
						window.location.href = '<?php echo $this->config['redirect_url']; ?>&txnStatus=FAILURE&txnMessage=' + BOLT.message;
					}
				});
			</script>
		</body>
		</html>
		<?php
	}
}
