<?php

$pedido = preg_replace('/[^[:alnum:]-]/','',$_POST["idPedido"]);

$data['token'] ='74FA269053B54E98B8C37791C1B1C39E';
$data['email'] = 'david_nbxnb@hotmail.com';
$data['currency'] = 'BRL';
$data['itemId1'] = '1';
$data['itemQuantity1'] = '1';
$data['itemDescription1'] = 'Pedido de teste '.$pedido;
$data['itemAmount1'] = '291.00';
$data['reference'] = $pedido;

$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout';

$data = http_build_query($data);

$curl = curl_init();

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

$xml= curl_exec($curl);

curl_close($curl);

$xml= simplexml_load_string($xml);
echo $xml -> code;

?>