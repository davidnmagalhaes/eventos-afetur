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
    $email = $_POST['emailsmtp'];
	$senha = $_POST['senhasmtp'];
	$smtp = $_POST['smtp'];

    $id = $_POST['id_smtp'];
	
	$ip = $_SERVER['REMOTE_ADDR']; 
			$data = date('Y-m-d'); 
			$hora = date('H:i:s');
			$nme = $_SESSION['nome'];
			
			$mensagem = $hora." - ".$nme." editou o e-mail de remetente: ".$email;
			$mensagem .= "<br>SMTP: ".$smtp;

			$result_usuario = "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem');";

			$result_usuario .= "UPDATE evn_user_smtp SET email_smtp='$email', senha_smtp='$senha', smtp='$smtp' WHERE id_smtp='$id'";

    
if ($link->multi_query($result_usuario) === TRUE) {
				header ("Location: paginassucesso/sucesso-edt-smtp.php");
			} else {
				echo "Error: " . $result_usuario . "<br>" . $link->error;
			}
	

?>