
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

if(isset($_POST)){ //Se existir POST executa
	
	$nome = $_POST['nome'];
	$usuario = $_POST['usuario'];
	$senha = md5($_POST['senha']);
	$nivel = $_POST['nivel'];
	$permeventos = $_POST['permeventos'];
	
	$query = "SELECT * FROM evn_usuarios ORDER BY id_user DESC";
	$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
	$row_eventos = mysqli_fetch_assoc($eventos);
	$totalRows_eventos = mysqli_num_rows($eventos);
	$iduser = $row_eventos['id_user'];
	$iduser += 1;
	
	$ativo = 1;
	$ativoperm = 1;
	
	$ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_SESSION['nome'];
			
	$mensagem = $hora." - ".$nme." adicionou o usuário: ".$usuario." - com nível: ".$nivel;

	$result_usuario = "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem');";

    $result_usuario .= "INSERT INTO evn_usuarios (nome_user, usuario_user, senha_user, nivel_user, ativo) VALUES ('$nome', '$usuario', '$senha', '$nivel', '$ativo');";
    
	foreach($permeventos as $refevento){
	
	$query = "SELECT * FROM evn_eventos WHERE ref='$refevento'";
	$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
	$row_eventos = mysqli_fetch_assoc($eventos);
	$nameevento = $row_eventos['nome_evento'];
	
	$result_usuario .= "INSERT INTO evn_permissao (ref_perm, usuario_perm, nome_perm, ativo_perm) VALUES ('$refevento', '$iduser', '$nameevento', '$ativoperm');";
	}

	if ($link->multi_query($result_usuario) === TRUE) {
		echo "Evento criado com sucesso!";
		header("Location: paginassucesso/sucesso-cd-usuarios.php");
	} else {
		echo "Error: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();
		}
		
?>