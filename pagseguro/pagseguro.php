<?php

$ref = $_POST['ref'];

$idingresso = $_POST['idingresso'];
$quantidade = $_POST['quantidade'];
$ingresso = $_POST['ingresso'];
$valor = $_POST['valor'];
$resultado = $_POST['resultado'];

$total = array_sum($resultado);
$numberi = number_format($resultado, 2, '.', '');
$number = str_replace(',','.', $numberi);


$pedido = preg_replace('/[^[:alnum:]-]/','',$_POST["idPedido"]);

//$data['token'] ='74FA269053B54E98B8C37791C1B1C39E';
$data['token'] ='BA9BF42D94F44ED8ACA1266516A2BDC5';
$data['email'] = 'pagseguro@afetur.com.br';
$data['currency'] = 'BRL';


$data['itemDescription1'] = 'Ingressos pedido: #'.$pedido;
$data['itemId1'] = '1';
$data['itemQuantity1'] = '1';
$data['itemAmount1'] = $number;


$data["reference"] = $pedido;

$url = 'https://ws.pagseguro.uol.com.br/v2/checkout';

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