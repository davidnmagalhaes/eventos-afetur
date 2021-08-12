<?php
include_once("config/conn.php");

$ref = $_GET['ref'];

$sql = "SELECT * FROM evn_eventos WHERE ref = '$ref'";
$pegachave = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_pegachave = mysqli_fetch_assoc($pegachave);

$token = $row_pegachave['tokenpaghiper'];
$appkeypaghiper = $row_pegachave['appkeypaghiper'];

$data = array (
  'transaction_id' => $_POST['transaction_id'],
  'notification_id' => $_POST['notification_id'],
  'apiKey' => $appkeypaghiper, // aqui voce insere sua ApiKey
  'token' => $token,  // aqui voce insere seu token
);

$data;

$data_post = json_encode( $data );
$url = "https://api.paghiper.com/transaction/notification/";
$mediaType = "application/json"; // formato da requisição
$charSet = "UTF-8";
$headers = array();
$headers[] = "Accept: ".$mediaType;
$headers[] = "Accept-Charset: ".$charSet;
$headers[] = "Accept-Encoding: ".$mediaType;
$headers[] = "Content-Type: ".$mediaType.";charset=".$charSet;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
$json = json_decode($result, true);

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$npedido = $json['status_request']['order_id'];
$pd = explode(' ',$npedido);

$order =  $pd[0]; //pedido
$first = $pd[3]; //parcela
$last = $pd[5]; //parcela final
$datapgto = date('Y-m-d');

//var_dump($json);
	if($json['status_request']['result'] == 'success'):

					if($json['status_request']['status'] == 'pending'):

					// aqui voce ira colocar o codigo PHP que deseja executar assim que o boleto é gerado, caso ja salve os dados na hora de criar o boleto nao precisa executar nada aqui

					elseif($json['status_request']['status'] == 'paid'):
					
					//Codigo que sera executado assim que ocorrer a alteração de status para pago e primeira parcela for igual a última.
					$vouch = "UPDATE evn_inscritos SET voucher='1' WHERE pedido='$order';";
					$vouch .= "UPDATE evn_pedidos SET status='3', data_pagamento='$datapgto' WHERE id='$order';";
					mysqli_multi_query($link, $vouch);
			
					
					
					elseif($json['status_request']['status'] == 'completed'):
					
					//Codigo que sera executado assim que ocorrer a alteração de status para completo e primeira parcela for igual a última.
					$vou = "UPDATE evn_inscritos SET voucher='1' WHERE pedido='$order';";
					$vou .= "UPDATE evn_pedidos SET status='3' WHERE id='$order';";
					mysqli_multi_query($link, $vou);
					
					

					elseif($json['status_request']['status'] == 'canceled'):
					
					//Quando ocorre o cancelamento, seja ele manual ou automatico.
					$result_usuario = "UPDATE evn_pedidos SET status='11' WHERE id='$order';";
	
					$resultado_usuario = mysqli_query($link, $result_usuario);
					
					else:
					
				
					
					endif;

	else:
					
		// no caso de não encontrar a notificação		
					
	endif;
?>