<?php
session_start();

if((empty($_SESSION['iduser'])) || (empty($_SESSION['usuario'])) || (empty($_SESSION['nivel']))){       
            $_SESSION['loginErro'] = "Área restrita";
            header("Location: index.php");
        }else{
            if($_SESSION['nivel'] != "3"){
                $_SESSION['loginErro'] = "Área restrita";
                header("Location: index.php");
            }
			
        }

include_once("config/conn.php");

$ip = $_SERVER['REMOTE_ADDR']; 
$data = date('Y-m-d'); 
$hora = date('H:i:s');
$nme = $_SESSION['nome'];

$column = $_REQUEST["column"];
$value = $_REQUEST["value"];
$idinsc = $_REQUEST["id"];

$qe = "SELECT * FROM evn_pedidos INNER JOIN evn_inscritos ON evn_inscritos.pedido = evn_pedidos.id WHERE evn_inscritos.id_inscritos='$idinsc'";
$evento = mysqli_query($link, $qe) or die(mysqli_error($link));
$row_evento = mysqli_fetch_assoc($evento);

$mensagem = $hora." - ".$nme." editou dados do inscrito de número ".$idinsc." referente ao pedido ".$row_evento['pedido']."<br>Mudou ".$column." para ".$value;

$sql = "UPDATE evn_inscritos set ".$_REQUEST["column"]."='".$_REQUEST["value"]."' WHERE  id_inscritos='".$_REQUEST["id"]."';";
$sql .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";

if ($link->multi_query($sql) === TRUE) {
		
	} else {
		echo "Error: " . $sql . "<br>" . $link->error;
	}

	$link->close();

?>