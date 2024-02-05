<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashfree {
    protected $config = null;
    protected $message = null;

    public function __construct($config){
        $endpoints = array(
            'live' => 'https://api.cashfree.com',
            'sandbox' => 'https://test.cashfree.com'
        );
        
        if($config['sandbox'] === true){
            $config['endpoint'] = $endpoints['sandbox'];
        } else {
            $config['endpoint'] = $endpoints['live'];
        }

        $this->config = $config;
    }

    public function pre_payment( array $data ){
        $url = $this->config['endpoint'] . '/api/v1/order/create';
        
        $request = array();
        
        $request['appId'] = $this->config['appId'];
        $request['secretKey'] = $this->config['secretKey'];
        $request['returnUrl'] = $this->config['redirect_url'];
        $request['notifyUrl'] = rtrim( get_instance()->config->base_url(), '/' ) . $this->config['notifyUrl'];
        
        foreach($data as $key => $value){
            switch($key){
                case 'order_id':
                    $request['orderId'] = $value;
                    break;
                case 'order_amount':
                    $request['orderAmount'] = $value;
                    break;
                case 'order_currency':
                    $request['orderCurrency'] = $value;
                    break;
                case 'customer_name':
                    $request['customerName'] = $value;
                    break;
                case 'customer_email':
                    $request['customerEmail'] = $value;
                    break;
                case 'customer_contact':
                    $request['customerPhone'] = $value;
                    break;
                case 'order_note':
                    $request['orderNote'] = $value;
                    break;
            }
        }

        $response = $this->_curl_request($url, $request);

        if($response['status'] == 'OK'){
            redirect( $response['paymentLink'] );
            die;
        } else {
            $this->message = $response['reason'];
            return false;
        }
    }

    public function post_payment($amount, $currency){
        // we will not verify $amount, $currency because the token already verifies it

        $token = (isset($_POST['orderId']) ? $_POST['orderId'] : '')
            . (isset($_POST['orderAmount']) ? $_POST['orderAmount'] : '')
            . (isset($_POST['referenceId']) ? $_POST['referenceId'] : '')
            . (isset($_POST['txStatus']) ? $_POST['txStatus'] : '')
            . (isset($_POST['paymentMode']) ? $_POST['paymentMode'] : '')
            . (isset($_POST['txMsg']) ? $_POST['txMsg'] : '')
            . (isset($_POST['txTime']) ? $_POST['txTime'] : '');

        $hash_hmac = hash_hmac('sha256', $token, $this->config['secretKey'], true);
        $computedSignature = base64_encode($hash_hmac);

        if( isset($_POST['signature']) && $_POST['signature'] == $computedSignature ){
            if($_POST['txStatus'] == 'SUCCESS'){
                return array(
                    'provider' => 'cashfree',
                    'order_id' => $_POST['orderId'],
                    'order_amount' => $_POST['orderAmount'],
                    'reference_id' => $_POST['referenceId'],
                    'tx_status' => $_POST['txStatus'],
                    'payment_mode' => $_POST['paymentMode'],
                    'tx_time' => strtotime($_POST['txTime'])
                );
            } else {
                $this->message = $_POST['txMsg'];
                return false;
            }
        } else {
            $this->message = 'We could not verify the payment signature.';
            return false;
        }
    }

    public function webhook(){
        $token = $_POST['orderId'] . $_POST['orderAmount'] 
            . $_POST['referenceId'] . $_POST['txStatus']
            . $_POST['paymentMode'] . $_POST['txMsg'] . $_POST['txTime'];

        $hash_hmac = hash_hmac('sha256', $token, $this->config['secretKey'], true);
        $computedSignature = base64_encode($hash_hmac);

        if($_POST['signature'] == $computedSignature){
            if($_POST['txStatus'] == 'SUCCESS'){
                return array(
					'provider' => 'cashfree',
                    'order_id' => $_POST['orderId'],
                    'order_amount' => $_POST['orderAmount'],
                    'reference_id' => $_POST['referenceId'],
                    'tx_status' => $_POST['txStatus'],
                    'payment_mode' => $_POST['paymentMode'],
                    'tx_time' => $_POST['txTime']
                );
            } else {
                $this->message = $_POST['txMsg'];
                return false;
            }
        } else {
            $this->message = 'We could not verify the payment signature.';
            return false;
        }
    }

    public function message(){
        return $this->message;
    }

    protected function _curl_request($url, $post_data){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($post_data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_USERAGENT, 'PHP/'. phpversion() .' ('. php_uname('s') .' '. php_uname('r') .') '. php_uname('n') .' Cashier/1.0');
		
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
}
