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
    $ref = $_GET['id_inscrito'];
    
    $result_usuario = "DELETE FROM evn_inscritos WHERE id_inscritos='$ref'";
    
	if (mysqli_query($link, $result_usuario)) {
    header ("Location: inscritos.php");
} else {
    echo "Erro ao excluir inscrito: " . mysqli_error($link);
}

mysqli_close($link);
	
	
?>