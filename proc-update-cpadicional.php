<?php 
include_once ('config/conn.php');

$id = $_POST['id_inscritos'];
 $ref = $_POST['ref'];
 $campoad = $_POST['cadd'];
 $cpinscrito = $_POST['cpinscrito'];
 
 $ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_POST['nme'];
	
	$qr = "SELECT * FROM evn_inscritos WHERE id_inscritos='$id'";
	$inscritos = mysqli_query($link, $qr) or die(mysqli_error($link));
	$row_inscritos = mysqli_fetch_assoc($inscritos);
	
	$qe = "SELECT * FROM evn_eventos WHERE ref='$ref'";
	$evento = mysqli_query($link, $qe) or die(mysqli_error($link));
	$row_evento = mysqli_fetch_assoc($evento);
	
	$mensagem = $hora." - ".$nme." mudou o clube de inscrito ".$row_inscritos['nome_inscrito']." de ".$cpinscrito." para ".$campoad.", ID: ".$id.", no evento ".$row_evento['nome_evento'];
	
	 $result_usuario = "UPDATE evn_inscritos SET cpadicional = '$campoad' WHERE id_inscritos = '$id';";
	$result_usuario .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";

	if ($link->multi_query($result_usuario) === TRUE) {
		header("Location: lista-inscritos.php?ref=".$ref."#".$id);
	} else {
		echo "Error: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();
?>