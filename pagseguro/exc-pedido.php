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
    $id = $_GET['id'];
    
    $result_usuario = "DELETE FROM evn_pedidos WHERE id='$id'";
    
	if (mysqli_query($link, $result_usuario)) {
    header ("Location: pedidos.php");
} else {
    echo "Erro ao excluir pedido: " . mysqli_error($link);
}

mysqli_close($link);
	
	
?>