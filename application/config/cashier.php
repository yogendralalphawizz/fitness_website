<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
    1. do not forget to whiltelist redirect url and webhook url from csrf checks.
    2. provider query parameter will be added automatically to redirect url and webhook url.
*/
$config['redirect_url'] = '/Home/after_payment'; // relative to index.php

$config['cashfree'] = array(
    'enabled' => true,
    'sandbox' => true,
    'appId' => '530298c090e1edddd45d908fa92035',
    'secretKey' => '67afffcc87db46f14718f084f3f90fc3e4890f7e',
    'notifyUrl' => '/front/payment_webhook' // relative to index.php (https)
);

// webhook_url need to be set in razorpay dashboard
$config['razorpay'] = array(
    'enabled' => true,
    'keyId' => 'rzp_test_SlREUGXo5LBjfN',
    'keySecret' => '6D1gp5oUyh9swEfSx2CUY70x',
    'webhookSecret' => '!se9J9PUn#LzN3Z',
    'merchantName' => 'Donate Foundation',
    'merchantLogoPath' => '/assets/img/logo.png' // relative to index.php
);

$config['paypal'] = array(
	'enabled' => false,
	'sandbox' => false,
	'sandbox_clientId' => 'AbGN8L5WaS5_yju2wXTiB6hKtxGUXdWB6_SbZCB9FZrUb4puQhBn1nkbTFw-Mh1diSWwuC6iuDRWGM0j',
	'sandbox_clientSecret' => 'EBFb0ra9AdrdtN-6iqGXPOLpgCbSpZ-5yE4Io5sXsx8bWrCkeKZmJK-UQ8bRdANCLbj5ez5A0Ndu_mTW',
	'live_clientId' => '',
	'live_clientSecret' => '',
	'webhook_id' => '61X65055GG697090B' // The ID of the webhook as configured in Your Paypal Developer Portal account.
);

// webhook_url need to be set in stripe dashboard
$config['stripe'] = array(
	'enabled' => false,
	'sandbox' => false,
	'sandbox_key' => 'pk_test_2V1eh08jIHOt0lKrHjS3eG8M',
	'sandbox_secret' => 'sk_test_h0WZI26ppmAcWuILcyBaHy14',
	'live_key' => '',
	'live_secret' => '',
	'webhook_secret' => 'whsec_gJZwaihW2rjsgpAwltpDjDAnUqEC6sYJ'
);

// webhook_url and webhookAuthHeader need to be set in payumoney dashboard
$config['payumoney'] = array(
	'enabled' => false,
	'sandbox' => false,
	'key' => 'LOunvFmE',
	'salt' => 'VhMsujnBH0',
	'merchantLogoPath' => '/assets/img/logo.png', // relative to index.php
	'webhookAuthHeader' => array(
		'key' => 'X-Auth',
		'value' => '1234567890'
	)
);

// Instamojo processes payments in INR only.
$config['instamojo'] = array(
	'enabled' => false,
	'sandbox' => false,
	'test_client_id' => 'test_sr2VLf2FcjnJ8CHH3K1kJQ7rckZnYDCsPw2',
	'test_client_secret' => 'test_jabN5ciAd1wWLOibKzKsbWDTGKMedsS0LMIVF0QHixchlqJhjfn1zolXv8bHQa6fKqWYXspF6IQSedLT8tbMqG0mXBSH5Tbudlcbr0bjVJBmjeNx21Ob9pPnuzE',
	'test_salt' => '1c499fe89e28439db4ad2a03fd72cc42',
	'live_client_id' => '',
	'live_client_secret' => '',
	'live_salt' => '',
	'webhook_url' => '/front/payment_webhook' // relative to index.php
);

// Production only credentials
// Dynamic Event Notification (Webhook) need to be set in ccavenue dashboard
$config['ccavenue'] = array(
	'enabled' => false,
	'merchant_id' => '332043',
	'access_code' => 'AVSM02IB46AY86MSYA',
	'working_key' => 'DB54E215542A6E74E5988C2C531006B2'
);

// webhook_url need to be set in paytm dashboard
$config['paytm'] = array(
	'enabled' => false,
	'sandbox' => true,
	'test_merchant_id' => 'bLPezV67288362569241',
	'test_merchant_key' => 'wZqLJ8NaqMUBkWel',
	'test_website_name' => 'WEBSTAGING',
	'live_merchant_id' => '',
	'live_merchant_key' => '',
	'live_website_name' => ''
);

// IPN (webhook) need to be set in amazon-pay dashboard
$config['amazonpay'] = array(
	'enabled' => false,
	'sandbox' => false,
	'merchant_id' => 'A73IFW331B4Z7',
	'client_id' => 'amzn1.application-oa2-client.f1ecbe2988f24c40a79e85ce6c11f0bf',
	'mws_access_key' => 'AKIAJSCMJNXETTMFB4HA',
	'mws_secret_key' => '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',
	'region' => 'us' // us, de, uk, jp
);
