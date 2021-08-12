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
    $id = $_GET['id_order_ing'];
	$idpedido = $_GET['id'];
    $host = $_SERVER['HTTP_HOST'];
    $result_usuario = "DELETE FROM evn_pedidos_ing WHERE id_order_ing='$id'";
    
	if (mysqli_query($link, $result_usuario)) {
    header ("Location: /pedidos.php?id=".$idpedido);
} else {
    echo "Erro ao excluir ingresso: " . mysqli_error($link);
}

mysqli_close($link);
	
	
?>