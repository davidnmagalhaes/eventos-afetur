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

     require_once('config/conn.php');
    $ref = $_GET['ref'];
	$ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nome = $_GET['nome'];
	
	$qr = "SELECT * FROM evn_eventos WHERE ref = '$ref'";
	$exibelog = mysqli_query($link, $qr) or die(mysqli_error($link));
	$row_exibelog = mysqli_fetch_assoc($exibelog);
	$item = $row_exibelog['nome_evento'];
	
	
	
	$mensagem = $nome." excluiu o evento ".$item;
    
    $sql = "DELETE FROM evn_eventos WHERE ref='$ref';";
    
	$sql .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nome', '$item', '$mensagem')";


if ($link->multi_query($sql) === TRUE) {
		header("Location: paginassucesso/sucesso-exc-evento.php");
	} else {
		echo "Erro: " . $sql . "<br>" . $link->error;
	}

	$link->close();
		
	
	
?>