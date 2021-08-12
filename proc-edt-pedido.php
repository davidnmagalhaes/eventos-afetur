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
	
	$ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_POST['nme'];
	
	$qr = "SELECT evn_pedidos.evento as evento, evn_pedidos.status as statuspedido, evn_status_pedido.status as status  FROM evn_pedidos INNER JOIN evn_status_pedido ON evn_pedidos.status = evn_status_pedido.id WHERE evn_pedidos.id= '$id'";
	$exibelog = mysqli_query($link, $qr) or die(mysqli_error($link));
	$row_exibelog = mysqli_fetch_assoc($exibelog);
	$item = $row_exibelog['evento'];
	
	
	
	$mensagem = $hora." - ".$nme." editou o pedido ".$id.":";
	if($row_exibelog['statuspedido'] != $status){
	$mensagem .= "<br>Status foi alterado de ".$row_exibelog['status']." para ".$status.":<br>";
	}
	
	
    $result_usuario = "UPDATE evn_pedidos SET status='$status', nome='$nome', email='$email', campo_adicional='$cpadicional' WHERE id='$id';";
    
	
		$result_usuario .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";


if ($link->multi_query($result_usuario) === TRUE) {
		header("Location: pedidos.php");
	} else {
		echo "Erro: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();

    
	
	
?>