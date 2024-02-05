<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Razorpay {
    protected $config = null;
    protected $message = null;

    public function __construct($config){
        $config['endpoint'] = 'https://api.razorpay.com/v1';
        $this->config = $config;
    }

    public function pre_payment( array $data ){
        $url = $this->config['endpoint'] . '/orders';

        $request = array(
            'amount' => $data['order_amount'] * 100, // in paise
            'currency' => $data['order_currency'],
            'receipt' => $data['order_id']
        );

        if( $data['order_note'] ){
            $request['notes'] = [ $data['order_note'] ];
        }

        $response = $this->_curl_request($url, $request);
        
        if( $response === false ){
			return false;
		}
		
        if( isset($response['error']) ){
            $this->message = $response['error']['description'];
            return false;
        }

        $data['rzrpay_order_id'] = $response['id'];
        $this->_render_form($data);
        die;
    }

    public function post_payment($amount, $currency){
        $token = (isset($_POST['razorpay_order_id']) ? $_POST['razorpay_order_id'] : '')
            . '|' . (isset($_POST['razorpay_payment_id']) ? $_POST['razorpay_payment_id'] : '');

        $hash_hmac = hash_hmac('sha256', $token, $this->config['keySecret']);

        if($hash_hmac == $_POST['razorpay_signature']){
            $order_data = $this->_curl_request(
                $this->config['endpoint'] . '/orders/' . $_POST['razorpay_order_id'],
                array(),
                'GET'
            );
            
			if( $order_data === false ){
				return false;
			}
            
            $amount = $amount * 100;

            if($order_data['status'] == 'attempted'){
                if($amount == $order_data['amount']){
                    $payment_data = $this->_curl_request(
                        $this->config['endpoint'] . '/payments/' . $_POST['razorpay_payment_id'] . '/capture',
                        array( 'amount' => $amount, 'currency' =>  $currency )
                    );

                    if( $payment_data === false ){
						return false;
					}
				
                    if($payment_data['status'] == 'captured'){
                        return array(
                            'provider' => 'razorpay',
                            'order_id' => $order_data['receipt'],
                            'order_amount' => $order_data['amount'],
                            'reference_id' => $order_data['id'],
                            'tx_status' => 'paid',
                            'payment_mode' => $payment_data['method'],
                            'tx_time' => $order_data['created_at']
                        );
                    } else {
                        $this->message = 'Payment could not be captured, You will get complete refund in 5-7 Business days.';
                        return false;
                    }
                } else {
                    $this->message = 'Payment Amount could not be verified, You will get complete refund in 5-7 Business days.';
                    return false;
                }
            } else if($order_data['status'] == 'paid') {
                return array(
                    'provider' => 'razorpay',
                    'order_id' => $order_data['receipt'],
                    'order_amount' => $order_data['amount'],
                    'reference_id' => $order_data['id'],
                    'tx_status' => $order_data['status'],
                    'payment_mode' => 'unknown',
                    'tx_time' => $order_data['created_at']
                );
            } else {
                $this->message = 'Payment could not be verified, You will get complete refund in 5-7 Business days.';
                return false;
            }
        } else {
            $this->message = 'We could not verify the payment signature.';
            return false;
        }
    }

    public function webhook(){
        $payload = file_get_contents("php://input");
        $signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'];
        $hash_hmac = hash_hmac('sha256', $payload, $this->config['webhookSecret']);

        if($signature == $hash_hmac){
            $payload = json_decode($payload, true);
            if($payload['event'] == 'order.paid'){
                return array(
                    'provider' => 'razorpay',
                    'order_id' => $payload['payload']['order']['entity']['receipt'],
                    'order_amount' => $payload['payload']['order']['entity']['amount'],
                    'reference_id' => $payload['payload']['order']['entity']['id'],
                    'tx_status' => $payload['payload']['order']['entity']['status'],
                    'payment_mode' => $payload['payload']['payment']['entity']['method'],
                    'tx_time' => $payload['payload']['order']['entity']['created_at']
                );
            } else {
                $this->message = 'Not Processing Events other than `order.paid`.';
            }
        } else {
            $this->message = 'Current Webhook Event Signature could not be verified.';
        }

        return false;
    }

    public function message(){
        return $this->message;
    }

    protected function _curl_request($url, $post_data = array(), $method = 'POST'){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->config['keyId'] . ":" . $this->config['keySecret']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_USERAGENT, 'PHP/'. phpversion() .' ('. php_uname('s') .' '. php_uname('r') .') '. php_uname('n') .' Cashier/1.0');
		
        if($method == 'POST'){
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        
        if($post_data){
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        }

        $result = curl_exec($ch);

        if($result === false){
            $this->message = curl_error($ch);
            curl_close($ch);
            return false;
        } else {
            curl_close($ch);
            return json_decode($result, true);
        }
    }

    private function _render_form($data){
        ?>
        <!DOCTYPE html>
        <html>
        <head lang="en">
            <meta charset="utf-8">
            <title>Pay with Razorpay</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style type="text/css">
            .razorpay-payment-button{
                padding: 10px;
                background: #2196f3;
                border: 0px;
                border-radius: 5px;
                font-size: 15px;
                cursor:pointer;
            }
            </style>
        </head>
        <body>
            <form style="text-align:center; margin-top: 25vh;" action="<?php echo $this->config['redirect_url']; ?>" method="POST">
                <img src="data:image/png;base64,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" style="width:200px;">
                <br><br>
                <script
                    src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="<?php echo $this->config['keyId']; ?>"
                    data-order_id="<?php echo $data['rzrpay_order_id']; ?>"
                    data-name="<?php echo $this->config['merchantName']; ?>"
                    data-image="<?php echo get_instance()->config->base_url($this->config['merchantLogoPath']); ?>"
                    data-amount="<?php echo $data['order_amount'] * 100; ?>"
                    data-currency="<?php echo $data['order_currency']; ?>"
                    data-prefill.name="<?php echo $data['customer_name']; ?>"
                    data-prefill.email="<?php echo $data['customer_email']; ?>"
                    data-prefill.contact="<?php echo $data['customer_contact']; ?>"
                    <?php if($data['order_note']){ ?>data-notes.0="<?php echo $data['order_note']; ?>"<?php } ?>
                >
                </script>
            </form>

           <script type="text/javascript">
                window.addEventListener('load', function(){
                    document.getElementsByClassName('razorpay-payment-button')[0].click();
                });
            </script>
        </body>
        </html>
        <?php
    }
}
