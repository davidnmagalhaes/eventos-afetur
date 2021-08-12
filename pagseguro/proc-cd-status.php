
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

if(isset($_POST)){ //Se existir POST executa
	
	$status = $_POST['status'];
	
	$ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_POST['nme'];
	$mensagem = $hora." - ".$nme." adicionou o status ".$status." ao sistema";
	
    $result_usuario = "INSERT INTO evn_status_pedido (status) VALUES ('$status');";
    $result_usuario .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";

    
	if ($link->multi_query($result_usuario) === TRUE) {
		header("Location: ../paginassucesso/sucesso-cd-status.php");
	} else {
		echo "Erro: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();
}
?>