<?php

include 'config.php';
//POST

//new version 4
$json='{"amount":"12.00","merchant_code":"abcd1234","order_id":"ord1543976117","reference":"reference\/attach","status":"PAID","transaction_id":"IC520PMOAFS","sign":"af07d0bcfa4aeadc025e566cd2a3e854"}';

$parsed = json_decode($json,1);

ksort($parsed);

$expected_sign= $parsed['sign'];

unset($parsed['sign']);

$tos = urldecode(http_build_query($parsed)) ."&".$key;

$local_sign = md5($tos);


if($local_sign == $expected_sign && ($parsed['status'] == 'PAID'||$parsed['status'] == 'SUCCESS')){
	echo "\nok";
}else echo "\nfailed";