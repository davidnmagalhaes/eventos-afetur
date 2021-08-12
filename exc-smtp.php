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
    $ref = $_GET['id_smtp'];
	
	$ip = $_SERVER['REMOTE_ADDR']; 
			$data = date('Y-m-d'); 
			$hora = date('H:i:s');
			$nme = $_SESSION['nome'];
			
			$qs = "SELECT * FROM evn_user_smtp WHERE id_smtp='$ref'";
			$emails = mysqli_query($link, $qs) or die(mysqli_error($link));
			$row_emails = mysqli_fetch_assoc($emails);
			
			$mensagem = $hora." - ".$nme." excluiu o e-mail ".$row_emails['email_smtp']." do setor de e-mails remetentes";
			
			$result_usuario = "DELETE FROM evn_user_smtp WHERE id_smtp='$ref';";
			$result_usuario .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";

			if ($link->multi_query($result_usuario) === TRUE) {
				header ("Location: paginassucesso/sucesso-exc-smtp.php");
			} else {
				echo "Error: " . $result_usuario . "<br>" . $link->error;
			}
    
    
    
	
	
	
?>