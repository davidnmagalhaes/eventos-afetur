
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

if(isset($_POST)){ //Se existir POST executa
	
	$email = $_POST['emailsmtp'];
	$senha = $_POST['senhasmtp'];
	$smtp = $_POST['smtp'];
	
	$ip = $_SERVER['REMOTE_ADDR']; 
			$data = date('Y-m-d'); 
			$hora = date('H:i:s');
			$nme = $_SESSION['nome'];
			
			$mensagem = $hora." - ".$nme." adicionou um novo e-mail de remetente ao setor Marketing: ".$email;
			
			$result_usuario = "INSERT INTO evn_user_smtp (email_smtp, senha_smtp, smtp) VALUES ('$email', '$senha', '$smtp');";
			$result_usuario .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";

			if ($link->multi_query($result_usuario) === TRUE) {
				header("Location: paginassucesso/sucesso-cd-smtp.php");
			} else {
				echo "Error: " . $result_usuario . "<br>" . $link->error;
			}
	
}
?>