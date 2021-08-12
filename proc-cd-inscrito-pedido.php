
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
$id = preg_replace('/[^[:alnum:]_]/', '', $_POST["pedidoparticipa"]);

	$check=mysqli_query($link,"select id from evn_pedidos where id='$id'");
	$checkrows=mysqli_num_rows($check);
	
	
	if($checkrows>0){
	
	$nome = $_POST['nomeparticipa'];
	$email = $_POST['emailparticipa'];
	$cpad = $_POST['cpadparticipa'];
	
	$ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_POST['nme'];
	
	$qr = "SELECT evn_pedidos.campo_adicional as cpadicional, evn_eventos.campo_adicional as cpad FROM evn_pedidos INNER JOIN evn_eventos ON evn_pedidos.ref = evn_eventos.ref WHERE evn_pedidos.ref='$ref'";
	$ingressos = mysqli_query($link, $qr) or die(mysqli_error($link));
	$row_ingressos = mysqli_fetch_assoc($ingressos);
	
	$mensagem = $hora." - ".$nme." adicionou um inscrito ao pedido ".$id.":";
	$mensagem .= "<br>Nome do participante: ".$nome.";";
	$mensagem .= "<br>E-mail do participante: ".$email.";";
	$mensagem .= "<br>".$row_ingressos['cpad']." do participante: ".$cpad.";";
	
    $result_usuario = "INSERT INTO evn_inscritos (nome_inscrito, email_inscrito, pedido, cpadicional) VALUES ('$nome', '$email', '$id', '$cpad');";

	$result_usuario .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";

	if ($link->multi_query($result_usuario) === TRUE) {
		header("Location: paginassucesso/sucesso-cd-inscrito-pedido.php?pedido=".$ref);
	} else {
		echo "Error: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();
	}
?>