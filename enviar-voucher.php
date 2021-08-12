<?php
include("valida_pagina.php");

// Script para envio de e-mail referente ao pedido
		require("phpmailer/class.phpmailer.php");
		require("config/conn.php");
			
			$id = $_GET['id'];
			
			
			$inscrito = "SELECT * FROM evn_inscritos WHERE id_inscritos = '$id'";
			$editainscrito = mysqli_query($link, $inscrito) or die(mysqli_error($link));
			$row_editainscrito = mysqli_fetch_assoc($editainscrito);
			 
			
			$ref = $_GET['pedido'];
			
			$pedido = "SELECT * FROM evn_pedidos WHERE id = '$ref'";
			$editapedido = mysqli_query($link, $pedido) or die(mysqli_error($link));
			$row_editapedido = mysqli_fetch_assoc($editapedido);
			
			
			
			$codevento = $row_editapedido['ref'];
			
			$evento = "SELECT * FROM evn_eventos WHERE ref = '$codevento'";
			$editaevento = mysqli_query($link, $evento) or die(mysqli_error($link));
			$row_editaevento = mysqli_fetch_assoc($editaevento);
			$nomeevento = $row_editaevento['nome_evento'];

			$tabelabd = $row_editaevento['tabela_bd'];
			$colunabd = $row_editaevento['coluna_bd'];
			$valuebd = $row_editaevento['value_bd'];

			$inscr = "SELECT * FROM evn_inscritos WHERE pedido = '$ref'";
	$editainscr = mysqli_query($link, $inscr) or die(mysqli_error($link));
	$row_editainscr = mysqli_fetch_assoc($editainscr);

/*if($tabelabd == "" || $colunabd == ""){
	
/*}else{

$local2 = $row_editacampoad['host_bd'];
$usuario2 = $row_editacampoad['usuario_bd'];
$senha2 = $row_editacampoad['password_bd'];
$banco2 = $row_editacampoad['banco_bd'];
$tabela2 = $row_editacampoad['tabela_bd'];
$link2 = mysqli_connect($local2, $usuario2, $senha2, $banco2);
 
if (!$link2) {
    echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$inscr = "SELECT * FROM ".$tabela2." INNER JOIN ".$tabelabd." ON evn_inscritos.cpadicional = ".$tabelabd.".".$valuebd." WHERE evn_inscritos.pedido = '$ref'";
$editainscr = mysqli_query($link, $inscr) or die(mysqli_error($link));
$row_editainscr = mysqli_fetch_assoc($editainscr);
}*/
	
			
			
			$ingresso = "SELECT * FROM evn_pedidos_ing WHERE ref_pedido = '$ref'";
			$editaingresso = mysqli_query($link, $ingresso) or die(mysqli_error($link));
			$row_editaingresso = mysqli_fetch_assoc($editaingresso);
			
				 
			$ingre = "";
			do{
				$ingre .= "<li>".$row_editaingresso['qtd_ing']."x ".$row_editaingresso['ing']."</li>"; 
			} while ($row_editaingresso = mysqli_fetch_assoc($editaingresso));
			
			if($tabelabd == "" || $colunabd == ""){
			$insc = "";
			do{
				$insc .= "<li>".$row_editainscr['nome_inscrito']." <strong>(".$row_editainscr['cpadicional'].")</strong></li>"; 
			} while ($row_editainscr = mysqli_fetch_assoc($editainscr));
			}else{
			$insc = "";
			do{
				$insc .= "<li>".$row_editainscr['nome_inscrito']." <strong>(".$row_editainscr[$colunabd].")</strong></li>"; 
			} while ($row_editainscr = mysqli_fetch_assoc($editainscr));
			}
			
			
			$ip = $_SERVER['REMOTE_ADDR']; 
			$data = date('Y-m-d'); 
			$hora = date('H:i:s');
			$nme = $_SESSION['nome'];
			$mensagem = $hora." - ".$nme." enviou o voucher do inscrito ".$row_editainscrito['nome_inscrito'];
			
			$result_usuario = "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";

			if ($link->multi_query($result_usuario) === TRUE) {
				
			} else {
				echo "Error: " . $result_usuario . "<br>" . $link->error;
			}

			$link->close();
			
			
			$mail = new PHPMailer();

			$mail->IsSMTP(); // Define que a mensagem será SMTP
			$mail->Host = "smtplw.com.br"; // Endereço do servidor SMTP
			$mail->SMTPAuth = true; // Autenticação
			$mail->Username = 'afeturmail'; // Usuário do servidor SMTP
			$mail->Password = 'oWMIkPYV6054'; // Senha da caixa postal utilizada


			$mail->From = "contato@afetur.com.br"; 
			$mail->FromName = "Afetur Turismo";

			$mail->AddAddress($row_editainscrito['email_inscrito']);
			$mail->AddCC('murilo@afetur.com.br'); 
			$mail->AddCC('jaiane@afetur.com.br'); 
			//$mail->AddBCC('CopiaOculta@dominio.com.br', 'Copia Oculta');
			$mail->SMTPDebug  = 1;
			$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
			$mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)

			$mail->Subject  = "Voucher - ".$nomeevento; // Assunto da mensagem
			$mail->Body = '<div style="margin: 0 auto; width: 800px;">
<table width="800"  style="font-family: calibri; border: 2px solid #fff; ">
  <tr >
    <th colspan="2" scope="row" style=" font-size: 24px; padding: 3px; background:#36C; color: #fff;">Voucher | '.$nomeevento.'</th>
  </tr>
  <tr >
    <td width="282" height="36" align="right" style="padding: 3px; background: #CCE4FF;"><strong>Pedido: </strong></td>
    <td width="504" style="padding: 3px ; background: #CCE4FF;"># '.$row_editainscrito['pedido'].'</td>
  </tr>
  <tr >
    <td width="282" height="36" align="right" style="padding: 3px; background: #CCE4FF;"><strong>Data do evento: </strong></td>
    <td width="504" style="padding: 3px ; background: #CCE4FF;">'.date('d/m/Y',strtotime($row_editaevento['data_inicio'])).'</td>
  </tr>
  <tr >
    <td width="282" height="36" align="right" style="padding: 3px; background: #CCE4FF;"><strong>Local do evento: </strong></td>
    <td width="504" style="padding: 3px ; background: #CCE4FF;">'.$row_editaevento['local_nome'].'</td>
  </tr>
  <tr >
    <td width="282" height="36" align="right" style="padding: 3px; background: #CCE4FF;"><strong>Endereço do evento: </strong></td>
    <td width="504" style="padding: 3px ; background: #CCE4FF;">'.$row_editaevento['local_logradouro'].', '.$row_editaevento['local_numero'].', '.$row_editaevento['local_complemento'].', '.$row_editaevento['local_bairro'].', '.$row_editaevento['local_cidade'].', '.$row_editaevento['local_estado'].', '.$row_editaevento['local_pais'].', '.$row_editaevento['local_cep'].'</td>
  </tr>
  <tr>
    <td align="right" height="36" style="padding: 3px; background: #CCE4FF;"><strong>Nome do Responsável:</strong></td>
    <td style="padding: 3px; background: #CCE4FF;">'.$row_editapedido['nome'].'</td>
  </tr>
  <tr>
    <td align="right" height="36" style="padding: 3px; background: #CCE4FF;"><strong>E-mail do Responsável:</strong></td>
    <td style="padding: 3px; background: #CCE4FF;">'.$row_editapedido['email'].'</td>
  </tr>
  <tr>
    <td align="right" height="36" style="padding: 3px; background: #CCE4FF;"><strong>Nome do inscrito:</strong></td>
    <td style="padding: 3px; background: #CCE4FF;">'.$row_editainscrito['nome_inscrito'].'</td>
  </tr>
  <tr>
    <td align="right" height="36" style="padding: 3px; background: #CCE4FF;"><strong>E-mail do Inscrito:</strong></td>
    <td style="padding: 3px; background: #CCE4FF;">'.$row_editainscrito['email_inscrito'].'</td>
  </tr>
  
  <tr>
    <td align="right" height="36" style="padding: 3px; background: #CCE4FF;"><strong>Valor total: </strong></td>
    <td style="padding: 3px; background: #CCE4FF;">'.$row_editapedido['moeda']." ".$row_editapedido['total_pedido'].'</td>
  </tr>
  <tr>
    <td align="right" height="36" style="padding: 3px; background: #CCE4FF;"><strong>Ingresso(s):</strong></td>
    <td style="padding: 3px; background: #CCE4FF;"><ul>'.
	$ingre
			.'</ul></td>
  </tr>
  <tr>
    <td align="right" height="36" style="padding: 3px; background: #CCE4FF;"><strong>Inscrito(s):</strong></td>
    <td style="padding: 3px; background: #CCE4FF;"><ul>'.$insc.'</ul></td>
  </tr>
  <tr>
    <td height="36" colspan="2" align="center" style="padding: 3px; background: #CCE4FF;"><img src="https://afetur.com.br/eventos/afetur.png" width="100"/><br>
      <p>Rua General Tertuliano Potiguara, 1064, Aldeota, Fortaleza, CE<br>
      (85) 3048-1900      </p></td>
    </tr>
	<tr >
    <th colspan="2" scope="row" style=" font-size: 14px; padding: 3px; color: #000;">* Este é o comprovante de seu ingresso. Faça a impressão e apresente-o no dia do evento.</th>
  </tr>
  <tr >
</table>
</div>

			 ';
			//$mail->AltBody = 'Este é o corpo da mensagem de teste, em Texto Plano! \r\n 
			//<IMG src="http://seudominio.com.br/imagem.jpg" alt=5":)"  class="wp-smiley"> ';

			//$mail->AddAttachment("e:\home\login\web\documento.pdf", "novo_nome.pdf");

			$enviado = $mail->Send();

			$mail->ClearAllRecipients();
			$mail->ClearAttachments();
			
			if ($enviado) {
			echo "<script>javascript:alert('Voucher enviado com sucesso! Em instantes o inscrito receberá um e-mail.');javascript:window.location='lista-inscritos.php?ref=".$codevento."#".$id."'</script>";

			} else {
			echo "Não foi possível enviar o e-mail.
			 
			";
			echo "Informações do erro: 
			" . $mail->ErrorInfo;
			}
		// Fim script para envio de e-mail referente ao pedido
?>