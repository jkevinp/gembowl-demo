<?php

//provided by gateway
$merchant_code = "abcd1234";
$key = "71afe35bd5daa0d7d2f9d55721d6d475";
$gateway_url = 'http://pmapi.local/v4/';
$ajax_check_url = "https://cashier.gembowl.com/check";


//merchant provided parameters
$order_id = "ord".time();
$reference = "reference/attach";
$amount = rand(1,100);
$timestamp = time();
$notification_url = 'http://ptsv2.com/t/bsare-1533929861/post';
$http_back_url = 'http://merchantsite.com';



$merchant_withrawal = [
	'merchant_code' => 'abcd1234',
	'amount' => rand(1,100),
	'message' => base64_encode('your message 提款留言'),
	'callback_url' => 'http://ptsv2.com/t/to93c-1561171127/post',
	'timestamp' => time(),
];

 ksort($merchant_withrawal);
 $mwtos = urldecode(http_build_query($merchant_withrawal)).'&71afe35bd5daa0d7d2f9d55721d6d475'; 

 $merchant_withrawal['sign'] = md5($mwtos);
