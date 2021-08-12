<?php 
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

include_once ('config/conn.php');

$id = $_GET['id_inscrito'];
$ref = $_GET['ref'];
$ativacertificado = 1;
 
 $sqlev = "SELECT * FROM evn_eventos WHERE ref = '$ref';";
$eventos = mysqli_query($link, $sqlev) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);
 
 $verifica=mysqli_query($link,"select * from evn_datas_checkin where id_inscrito='$id'");
 $verificarows=mysqli_num_rows($verifica);
 
 if($verificarows >= $row_eventos['dias_checkin']){
	$sqlcert = "UPDATE evn_inscritos SET certificado='$ativacertificado' WHERE id_inscritos='$id'"; 
	$cert = mysqli_query($link, $sqlcert) or die(mysqli_error($link));
	header("Location: lista-inscritos.php?ref=".$ref);
 }else{
	 header("Location: lista-inscritos.php?ref=".$ref);
 }
?>