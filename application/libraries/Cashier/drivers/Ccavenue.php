<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ccavenue
{
    protected $config = null;
    protected $message = null;

    public function __construct($config)
    {
		$config['endpoint'] = 'https://secure.ccavenue.com';
        $this->config = $config;
    }

    public function pre_payment(array $data)
    {
        $formatted_data = array(
            'tid' => md5( rand(0,99999) . time() ),
            'merchant_id' => $this->config['merchant_id'],
            'order_id' => $data['order_id'],
            'amount' => $data['order_amount'],
            'currency' => $data['order_currency'],
            'redirect_url' => $this->config['redirect_url'],
            'cancel_url' => $this->config['redirect_url'],
            'language' => 'EN',
            'integration_type' => 'iframe_normal',
            'billing_name' => $data['customer_name'],
            'billing_email' => $data['customer_email'],
            'billing_tel' => $data['customer_contact'],
            'merchant_param1' => $data['order_note']
        );

        $formatted_data = http_build_query($formatted_data);
        $encrypted_data = $this->_encrypt($formatted_data, $this->config['working_key']);

        $url = $this->config['endpoint'].'/transaction/transaction.do?command=initiateTransaction&encRequest='.$encrypted_data.'&access_code='.$this->config['access_code'];
        $this->_render_form($url);
        die;
    }

    public function post_payment($amount, $currency)
    {
        if( isset($_POST['encResp']) && ! empty($_POST['encResp']) ){
            $body = $this->_decrypt($_POST['encResp'], $this->config['working_key']);
            if( $body ){
                parse_str($body, $response);
                
                if($response['order_status'] == 'Success'){
                    if($response['amount'] >= $amount && $response['currency'] == $currency){
                        return array(
                            'provider' => 'ccavenue',
                            'order_id' => $response['order_id'],
                            'order_amount' => $response['amount'],
                            'reference_id' => $response['tracking_id'],
                            'tx_status' => $response['order_status'],
                            'payment_mode' => $response['payment_mode'],
                            'tx_time' => DateTime::createFromFormat("d/m/Y H:i:s", $response['trans_date'])->getTimestamp()
                        );
                    } else {
                        $this->message = 'Payment amount could not be verified, Contact us for refund.';
                        return false;
                    }
                } else {
                    $this->message = $response['failure_message'];
                    return false;
                }
            } else {
                $this->message = 'Invalid Payment Response.';
                return false;
            }
        } else {
            $this->message = 'Invalid Payment Response.';
            return false;
        }
    }

    public function webhook()
    {
        if( isset($_POST['encResp']) && ! empty($_POST['encResp']) ){
            $body = $this->_decrypt($_POST['encResp'], $this->config['working_key']);
            if( $body ){
                parse_str($body, $response);
                
                if($response['order_status'] == 'Success'){
                    return array(
						'provider' => 'ccavenue',
						'order_id' => $response['order_id'],
						'order_amount' => $response['amount'],
						'reference_id' => $response['tracking_id'],
						'tx_status' => $response['order_status'],
						'payment_mode' => $response['payment_mode'],
						'tx_time' => DateTime::createFromFormat("d/m/Y H:i:s", $response['trans_date'])->getTimestamp()
					);
                } else {
                    $this->message = $response['failure_message'];
                    return false;
                }
            } else {
                $this->message = 'Invalid Payment Response.';
                return false;
            }
        } else {
            $this->message = 'Invalid Payment Response.';
            return false;
        }
    }

    public function message()
    {
        return $this->message;
    }

    public function _render_form($url)
    {
        ?>
        <!DOCTYPE html>
		<html>
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
			<title>Pay with CCAvenue</title>
            <style type="text/css"> #ccAvenueFrame{ margin: 0px auto; display: block; } </style>
		</head>
		<body>
            <iframe src="<?php echo $url; ?>" id="ccAvenueFrame" width="482" height="450" frameborder="0" scrolling="No" ></iframe>
            <script type="text/javascript">
                window.addEventListener('load', function(){
                    window.addEventListener('message', function(e){
                        var ccAvenueFrame = document.querySelector('#ccAvenueFrame');
                        ccAvenueFrame.onload = function(){
                            ccAvenueFrame.style.height = ccAvenueFrame.contentWindow.document.body.scrollHeight + 'px';
                        }; 
                    }, false);
                });
            </script>
        </body>
		</html>
        <?php
    }

    protected function _encrypt($plainText, $key)
    {
        $key = $this->_hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }

    protected function _decrypt($encryptedText, $key)
    {
        $key = $this->_hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = $this->_hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }

    protected function _hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString .= $packedString;
            }

            $count += 2;
        }
        return $binString;
    }
}
