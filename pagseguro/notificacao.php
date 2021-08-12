<?php

$notificationCode = preg_replace('/[^[:alnum:]-]/','',$_POST["notificationCode"]);

//$data['token'] ='74FA269053B54E98B8C37791C1B1C39E';
$data['token'] ='48eea015-7427-4b52-83cc-f6fb6d525537fc2151fa426fa8acc011e3237816ea0e6cd9-5ca2-4407-99ae-5a38118f7aa6';
$data['email'] = 'assoc.distrito4490@gmail.com';


$data = http_build_query($data);

$url = 'https://ws.pagseguro.uol.com.br/v3/transactions/notifications/'.$notificationCode.'?'.$data;

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_URL, $url);
$xml = curl_exec($curl);
curl_close($curl);

$xml = simplexml_load_string($xml);

$reference = $xml->reference;
$status = $xml->status;

if($reference && $status){
 include_once 'conecta.php';
 $conn = new conecta();

 $rs_pedido = $conn->consultarPedido($reference);

 if($rs_pedido){
 $conn->atualizaPedido($reference,$status);
 }
}

?>