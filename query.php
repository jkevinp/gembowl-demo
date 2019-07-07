<?php

include 'config.php';

echo $gateway_url."query";


$data = [];//data will contain the order information you want to query.

$data['merchant_code'] = $merchant_code; //provided by gateway

//must fill in order id or trans id
$data['orderid'] = 'ord1543976117'; 
//$data['transid'] = '0';
$data['amount'] = 12.00;
$data['timestamp'] = time();


//sort the array base on key
ksort($data);
//concat  merchant key provided by gateway
$tos = http_build_query($data)."&".$key;
//use md5 and change case to upper
$data['sign'] = md5($tos);


//convert data array to json, post to query url
$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_URL => $gateway_url."query",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 60,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POST => 1,
	CURLOPT_POSTFIELDS => json_encode($data),
	CURLOPT_HTTPHEADER => array(
	  "cache-control: no-cache",
	  "content-type: application/json",
	),
));	

$res = curl_exec($curl);

if ($res === false) {
	var_dump(curl_error($curl));
	var_dump(curl_errno($curl));
}


$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

var_dump($res);

/*response : 
{
    "merchant_code": "abcd1234",
    "orderid": "order1533702237",
    "transid": "0",
    "status": "VALIDATED"
} 

{
    "status": false,
    "message": "xxxx"
}

*/




