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
    $ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_GET['nme'];
	$id = $_GET['id'];
	
	$qe = "SELECT * FROM evn_status_pedido WHERE id= '$id'";
	$exiberef = mysqli_query($link, $qe) or die(mysqli_error($link));
	$row_exiberef = mysqli_fetch_assoc($exiberef);
	
	$mensagem = $hora." - ".$nme." excluiu o status ".$row_exiberef['status'];
    
    $result_usuario = "DELETE FROM evn_status_pedido WHERE id='$id';";
    $result_usuario .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";

    
	
	if ($link->multi_query($result_usuario) === TRUE) {
		header("Location: ../paginassucesso/sucesso-exc-status.php");
	} else {
		echo "Erro: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();
	
	
?>