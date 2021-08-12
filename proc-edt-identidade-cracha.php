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
    $ref = $_POST['ref'];
	$cortitulo = $_POST['cortitulo'];
	$corfundo = $_POST['corfundo'];
	
	
	/*VariA?veis do upload de imagens*/
	$imagem = $_FILES['bgfoto']['name'];
	$temporario = $_FILES['bgfoto']['tmp_name'];
	$diretorio = "img-eventos/".date('d-m-y-h-i').$ref.$imagem;	
	
	/*VariA?veis do upload de imagens*/
	$image = $_FILES['bgrodape']['name'];
	$temp = $_FILES['bgrodape']['tmp_name'];
	$dir = "img-eventos/".date('d-m-y-h-i').$ref.$image;
	
if($imagem=="" && $image!=""){
    $result_usuario = "UPDATE evn_eventos SET cracha_rodape='$dir', cracha_cor_titulo='$cortitulo', cracha_cor_foto='$corfundo' WHERE ref='$ref';";
}elseif($image=="" && $imagem!=""){
	$result_usuario = "UPDATE evn_eventos SET cracha_background='$diretorio', cracha_cor_titulo='$cortitulo', cracha_cor_foto='$corfundo' WHERE ref='$ref';";
}else{
	$result_usuario = "UPDATE evn_eventos SET cracha_background='$diretorio', cracha_rodape='$dir', cracha_cor_titulo='$cortitulo', cracha_cor_foto='$corfundo' WHERE ref='$ref';";
}

	if ($link->multi_query($result_usuario) === TRUE) {
		move_uploaded_file($temporario,$diretorio);
		move_uploaded_file($temp,$dir);
		header("Location: paginassucesso/sucesso-edt-foto.php");
	} else {
		echo "Error: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();
	
?>