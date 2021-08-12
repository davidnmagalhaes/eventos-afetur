<?php
session_start();

if((empty($_SESSION['iduser'])) || (empty($_SESSION['usuario'])) || (empty($_SESSION['nivel']))){       
            $_SESSION['loginErro'] = "มrea restrita";
            header("Location: index.php");
        }else{
            if($_SESSION['nivel'] != "3"){
                $_SESSION['loginErro'] = "มrea restrita";
                header("Location: index.php");
            }
			
        }

     require_once('config/conn.php');
	$ref = $_GET['ref_perm'];
    $id = $_GET['usuario_perm'];
	
    $result_usuario = "DELETE FROM evn_permissao WHERE usuario_perm='$id' AND ref_perm = '$ref'";
    
	if (mysqli_query($link, $result_usuario)) {
    header ("Location: paginassucesso/sucesso-exc-usuarios.php");
} else {
    echo "Erro ao excluir usuรกrio: " . mysqli_error($link);
}

mysqli_close($link);
	
	
?>