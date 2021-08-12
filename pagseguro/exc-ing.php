<?php
session_start();

if((empty($_SESSION['iduser'])) || (empty($_SESSION['usuario'])) || (empty($_SESSION['nivel']))){       
            $_SESSION['loginErro'] = "Área restrita";
            header("Location: index.php");
        }else{
            if($_SESSION['nivel'] != "3"){
                $_SESSION['loginErro'] = "Área restrita";
                header("Location: ../index.php");
            }
			
        }

     require_once('../config/conn.php');
    $id = $_GET['id_order_ing'];
	$idpedido = $_GET['id'];
    $host = $_SERVER['HTTP_HOST'];
	
	$ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_GET['nme'];
	
    $result_usuario = "DELETE FROM evn_pedidos_ing WHERE id_order_ing='$id';";
	 $result_usuario .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";

	if ($link->multi_query($result_usuario) === TRUE) {
		header("Location: /pedidos.php?id=".$idpedido);
	} else {
		echo "Erro: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();
   
	
?>