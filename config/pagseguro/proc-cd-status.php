
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
			$now = time(); // Checking the time now when home page starts.

        if ($now > $_SESSION['expire']) {
            session_destroy();
            $_SESSION['loginErro'] = "Sessão expirou";
            header("Location: ../index.php");
        }
        }

require_once('../config/conn.php');

if(isset($_POST)){ //Se existir POST executa
	
	$status = $_POST['status'];
	
	
    $result_usuario = "INSERT INTO evn_status_pedido (status) VALUES ('$status')";
    $resultado_usuario = mysqli_query($link, $result_usuario);
    
	header("Location: status-pedidos.php");
}
?>