<?php
header('Content-Type: application/json');
include_once('config.php');
$key=$_GET['key'];
$merchant_code=$_GET['merchant_code'];
// $sign = strtoupper(md5($merchant_code.strtolower($_GET['orderid']).$_GET['amount'].$_GET['timestamp'].$_GET['notifyurl'].$key));


$data = [
	'merchant_code'	=> $merchant_code,
	'orderid'	=> strtolower($_GET['orderid']),
	'amount'	=> $_GET['amount'],
	'timestamp'	=> $_GET['timestamp'],
	'reference'	=> $_GET['reference'],
	'notifyurl'	=> $_GET['notifyurl'],
	'httpurl'	=> $_GET['httpurl'],
	'channel'	=> $_GET['channel'],
	// 'sign'	=> $sign
];


	ksort($data);
	$raw = urldecode(http_build_query($data)).'&'.$key; 
    $data['sign']= md5($raw);

// echo json_encode($data);

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => $gateway_url."pay",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 60,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => json_encode($data),
	CURLOPT_HTTPHEADER => array(
	  "cache-control: no-cache",
	  "content-type: application/json",
	),
));

		
$res = curl_exec($curl);

$resarray=json_decode($res,true);
$res=[
		"request"=>$data,
		"response"=>$resarray , 
		'raw' => $res , 
		'code' => curl_getinfo($curl , CURLINFO_HTTP_CODE),
	];

echo json_encode($res);


?>