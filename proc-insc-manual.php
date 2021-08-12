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

// VariÃ¡veis dos ingressos
		$ingresso = $_POST['ingresso'];
		$valor = $_POST['valor'];
		$quantidade = $_POST['quantidade'];
		$ref = $_POST['ref'];
		
		$nome = $_POST['nome'];
		$resultado = $_POST['resultado'];
		$email = $_POST['email'];
		$evento = $_POST['evento'];
		
		$campoadicional = $_POST['campoadicional'];
		$numberi = number_format($resultado, 2, '.', '');
		$number = str_replace(',','.', $numberi);
		$npedido = substr(uniqid(rand()), 0, 5);
		$ningresso = substr(uniqid(rand()), 0, 5);
		$moeda = $_POST['moeda'];
		$voucher = 1;
		
		$origem = "Manual";
		
	$ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_POST['nme'];
	
	$qr = "SELECT * FROM evn_eventos WHERE ref = '$ref'";
	$exibelog = mysqli_query($link, $qr) or die(mysqli_error($link));
	$row_exibelog = mysqli_fetch_assoc($exibelog);
	$item = $row_exibelog['nome_evento'];
	
		
		$query = "SELECT * FROM evn_pedidos ORDER BY id DESC";
		$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
		$row_eventos = mysqli_fetch_assoc($eventos);
		$cod = $row_eventos['id'];	
		$cod += 1;
		
		$tipotransacao = $_POST['tipopagamento'];
		
		$mensagem = $hora." - ".$nme." adicionou manualmente o pedido ".$cod." referente ao evento ".$item;
		
		$sql = "INSERT INTO evn_pedidos (descricao, status, nome, email, total_pedido, evento, ref, data_pedido, campo_adicional, npedido, tipo_transacao, moeda, origem, data_pagamento) VALUES ('Pedido #', 3, '$nome[0]', '$email[0]', '$number', '$evento', '$ref', NOW(), '$campoadicional[0]', '$npedido', '$tipotransacao', '$moeda', '$origem', '$data');";
		$sql .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem');";

		foreach($ingresso as $key => $ing){

			if($quantidade[$key] != 0){
		
		$sql .= "INSERT INTO evn_pedidos_ing (ing, valor_ing, qtd_ing, ref_pedido) VALUES ('$ing', '$valor[$key]', '$quantidade[$key]', '$cod');";
			}
		}
		
		foreach($nome as $chave => $nm){
			
			$sql .= "INSERT INTO evn_inscritos (voucher, nome_inscrito, email_inscrito, cpadicional, pedido) VALUES ('$voucher', '$nm', '$email[$chave]', '$campoadicional[$chave]', '$cod');";

		}
		
		if ($link->multi_query($sql) === TRUE) {
		header("Location: pagseguro/pedidos.php?ref=".$ref);
	} else {
		echo "Error: " . $sql . "<br>" . $link->error;
	}

	$link->close();
		

?>