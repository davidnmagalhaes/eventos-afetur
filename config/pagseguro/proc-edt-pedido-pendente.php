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
    $status = $_POST['status'];
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$cpadicional = $_POST['cpadicional'];

    $id = $_POST['id'];
	
	
    $result_usuario = "UPDATE evn_pedidos SET status='$status', nome='$nome', email='$email', campo_adicional='$cpadicional' WHERE id='$id';";
    
    
	mysqli_query($link, $result_usuario);
    header ("Location: pedidos-pendentes.php");


mysqli_close($link);
	
	
?>