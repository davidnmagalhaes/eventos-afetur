<?php

     require_once('../config/conn.php');
    $status = $_POST['status'];
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$cpadicional = $_POST['cpadicional'];

    $id = $_POST['id'];
	
	$ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_POST['nme'];
	
	$qr = "SELECT evn_pedidos.ref, evn_pedidos.campo_adicional, evn_pedidos.email, evn_pedidos.nome, evn_pedidos.evento, evn_pedidos.status as statuspedido, evn_status_pedido.status as status  FROM evn_pedidos INNER JOIN evn_status_pedido ON evn_pedidos.status = evn_status_pedido.id WHERE evn_pedidos.id= '$id'";
	$exibelog = mysqli_query($link, $qr) or die(mysqli_error($link));
	$row_exibelog = mysqli_fetch_assoc($exibelog);
	$item = $row_exibelog['evento'];
	$ref = $row_exibelog['ref'];
	
	$qy = "SELECT * FROM evn_status_pedido WHERE id= '$status'";
	$exibestatus = mysqli_query($link, $qy) or die(mysqli_error($link));
	$row_exibestatus = mysqli_fetch_assoc($exibestatus);
	
	$qe = "SELECT * FROM evn_eventos WHERE ref= '$ref'";
	$exiberef = mysqli_query($link, $qe) or die(mysqli_error($link));
	$row_exiberef = mysqli_fetch_assoc($exiberef);
	
	$mensagem = $hora." - ".$nme." editou o pedido ".$id.":";
	if($row_exibelog['statuspedido'] != $status){
	$mensagem .= "<br>Status foi alterado de ".$row_exibelog['status']." para ".$row_exibestatus['status']."<br>";
	}
	if($row_exibelog['nome'] != $nome){
	$mensagem .= "<br>Nome foi alterado de ".$row_exibelog['nome']." para ".$nome."<br>";
	}
	if($row_exibelog['email'] != $email){
	$mensagem .= "<br>E-mail foi alterado de ".$row_exibelog['email']." para ".$email."<br>";
	}
	if($row_exibelog['campo_adicional'] != $cpadicional){
	$mensagem .= "<br>".$row_exiberef['campo_adicional']." foi alterado de ".$row_exibelog['campo_adicional']." para ".$cpadicional."<br>";
	}
	
	$datapgto = date('Y-m-d');

	if($status == 3 || $status == 14 || $status == 4){
	$result_usuario = "UPDATE evn_pedidos SET status='$status', nome='$nome', email='$email', campo_adicional='$cpadicional', data_pagamento='$datapgto' WHERE id='$id';";

	}else{
    $result_usuario = "UPDATE evn_pedidos SET status='$status', nome='$nome', email='$email', campo_adicional='$cpadicional' WHERE id='$id';";

	}
	
    $result_usuario .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";
    
	if ($link->multi_query($result_usuario) === TRUE) {
		header("Location: ../paginassucesso/sucesso-edt-pedido-pendente.php?ref=".$ref);
	} else {
		echo "Erro: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();

	
	
?>