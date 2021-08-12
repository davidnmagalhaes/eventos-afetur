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

include_once ('config/conn.php');


 $id = $_POST['id_evento'];
 $ref = $_POST['ref'];
 $online = $_POST['option'];

$ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_POST['nme'];
	$mensagem = $hora." - ".$nme." editou o evento ".$ref.":";
	if($online == 1){
	$mensagem .= "<br>Habilitou o evento ".$ref;
	}else{
	$mensagem .= "<br>Desabilitou o evento ".$ref;
	}

 $result_usuario = "UPDATE evn_eventos SET ativo = '$online' WHERE ref = '$ref';";
 $result_usuario .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";

 
 if ($link->multi_query($result_usuario) === TRUE) {
		header("Location: eventos.php");
	} else {
		echo "Error: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();
 
 
 ?>