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
	
	$ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_POST['nme'];
	$mensagem = $hora." - ".$nme." editou a foto de capa do evento ".$ref;
	
	/*VariA?veis do upload de imagens*/
	$imagem = $_FILES['modelo']['name'];
	$temporario = $_FILES['modelo']['tmp_name'];
	
	if($imagem == NULL){
	$diretorio = "img-eventos/avatar.jpg";	
	}else{
	$diretorio = "img-eventos/".date('D-M-Y').$ref.$imagem;	
	}
	

    $result_usuario = "UPDATE evn_eventos SET modelo_evento='$diretorio' WHERE ref='$ref';";
	$result_usuario .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";

	if ($link->multi_query($result_usuario) === TRUE) {
		  move_uploaded_file($temporario,$diretorio);
		header("Location: paginassucesso/sucesso-edt-foto.php");
	} else {
		echo "Error: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();
	
?>