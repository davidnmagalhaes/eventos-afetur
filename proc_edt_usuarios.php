<?php


     require_once('config/conn.php');
    $nome = $_POST['nome'];
	$usuario = $_POST['usuario'];
	$senha = $_POST['senha'];
	$nivel = $_POST['nivel'];
	$permeventos = $_POST['permeventos'];

    $id = $_POST['id_user'];
	$ativoperm = 1;
	
	$senhasegura = md5($_POST['senha']);
	
    $check=mysqli_query($link,"select * from evn_usuarios where senha_user='$senha'");
	$checkrows=mysqli_num_rows($check);
	
	if($checkrows>0){
    $result_usuario = "UPDATE evn_usuarios SET usuario_user='$usuario', nome_user='$nome', nivel_user='$nivel' WHERE id_user='$id';";
    
	foreach($permeventos as $perm){
		
		
		
		
		$query = "SELECT * FROM evn_permissao WHERE ref_perm='$perm' AND usuario_perm = '$id'";
		$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
		$row_eventos = mysqli_fetch_assoc($eventos);
		$refperm = $row_eventos['ref_perm'];
		
		$qr = "SELECT * FROM evn_eventos WHERE ref='$perm'";
		$nmeventos = mysqli_query($link, $qr) or die(mysqli_error($link));
		$row_nmeventos = mysqli_fetch_assoc($nmeventos);
		$nameevento = $row_nmeventos['nome_evento'];
		
		if($perm != $refperm){
	$result_usuario .= "INSERT INTO evn_permissao (ref_perm, usuario_perm, nome_perm, ativo_perm) VALUES ('$perm', '$id', '$nameevento', '$ativoperm');";
		}
		
	}
	
	}else{
	$result_usuario = "UPDATE evn_usuarios SET usuario_user='$usuario', senha_user='$senhasegura', nome_user='$nome', nivel_user='$nivel' WHERE id_user='$id';";

	foreach($permeventos as $perm){
		
		
		
		
		$query = "SELECT * FROM evn_permissao WHERE ref_perm='$perm' AND usuario_perm = '$id'";
		$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
		$row_eventos = mysqli_fetch_assoc($eventos);
		$refperm = $row_eventos['ref_perm'];
		
		$qr = "SELECT * FROM evn_eventos WHERE ref='$perm'";
		$nmeventos = mysqli_query($link, $qr) or die(mysqli_error($link));
		$row_nmeventos = mysqli_fetch_assoc($nmeventos);
		$nameevento = $row_nmeventos['nome_evento'];
		
		if($perm != $refperm){
	$result_usuario .= "INSERT INTO evn_permissao (ref_perm, usuario_perm, nome_perm, ativo_perm) VALUES ('$perm', '$id', '$nameevento', '$ativoperm');";
		}
		
	}

	}
	
if ($link->multi_query($result_usuario) === TRUE) {
		
		header("Location: paginassucesso/sucesso-edt-usuarios.php");
	} else {
		echo "Error: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();
		
	
	
?>