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
    $id = $_GET['id_lista'];
	
	$ip = $_SERVER['REMOTE_ADDR']; 
			$data = date('Y-m-d'); 
			$hora = date('H:i:s');
			$nme = $_SESSION['nome'];
			
			$qr = "SELECT * FROM evn_lista_email WHERE id_lista='$id'";
			$codref = mysqli_query($link, $qr) or die(mysqli_error($link));
			$row_codref = mysqli_fetch_assoc($codref);
			
			$mensagem = $hora." - ".$nme." excluiu a lista de e-mails: ".$row_codref['nome_lista'];

			$result_usuario = "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem');";

    
    $result_usuario .= "UPDATE evn_lista_email SET status_lista = '2' WHERE id_lista='$id';";
	$result_usuario .= "DELETE FROM evn_emails WHERE ref_email='$id';";
    
	if ($link->multi_query($result_usuario) === TRUE) {
		header("Location: lista-emails.php");
	} else {
		echo "Error: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();
	
	
?>