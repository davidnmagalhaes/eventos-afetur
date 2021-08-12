<?php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

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

// Script para envio de e-mail referente ao pedido
		require("phpmailer/class.phpmailer.php");
		require("config/conn.php");
			
			$ref = $_POST['ref'];
			$enviadopor = $_POST['enviadopor'];
			$responder = $_POST['responder'];
			$assunto = $_POST['assunto'];
			$saudacao = $_POST['saudacao'];
			$mensagem = $_POST['mensagem'];
			$despedida = $_POST['despedida'];
			$emailteste = $_POST['emailteste'];
			$modeloevento = $_POST['modelo_evento'];
			$organizadornome = $_POST['organizador_nome'];
			$nomeevento = $_POST['nome_evento'];
			$dataevento = $_POST['dataevento'];
			$horainicio = date('H:i', strtotime($_POST['hora_inicio']));
			$localevento = $_POST['localevento'];
			$saudacao = $_POST['saudacao'];
			$mensagem = nl2br($_POST['mensagem']);
			$despedida = $_POST['despedida'];
			$host = $_SERVER['HTTP_HOST'];
			
			$ip = $_SERVER['REMOTE_ADDR']; 
			$data = date('Y-m-d'); 
			$hora = date('H:i:s');
			$nme = $_SESSION['nome'];
			
			$msg = $hora." - ".$nme." enviou um e-mail de teste referente ao evento ".$ref." para  o e-mail: ".$emailteste;

			$result_usuario = "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$msg')";

			if ($link->multi_query($result_usuario) === TRUE) {
				
			} else {
				echo "Error: " . $result_usuario . "<br>" . $link->error;
			}

			

			
			$qr = "SELECT * FROM evn_user_smtp WHERE id_smtp='$responder'";
			$smtp = mysqli_query($link, $qr) or die(mysqli_error($link));
			$row_smtp = mysqli_fetch_assoc($smtp);
			
			$mail = new PHPMailer();

			$mail->IsSMTP(); // Define que a mensagem será SMTP
			$mail->Host = $row_smtp['smtp']; // Endereço do servidor SMTP
			$mail->SMTPAuth = true; // Autenticação
			$mail->Username = $row_smtp['email_smtp']; // Usuário do servidor SMTP
			$mail->Password = $row_smtp['senha_smtp']; // Senha da caixa postal utilizada
			$mail->SMTPSecure = 'tls';                 // Habilita criptografia TLS | 'ssl' também é possível
			$mail->Port = 587;   

			$mail->From = 'contato@afetur.com.br'; 
			$mail->FromName = $enviadopor;

			$mail->AddAddress($emailteste, $enviadopor);
			//$mail->AddAddress($emailteste);
			//$mail->AddCC('social@afetur.com.br', 'Pedido'); 
			$mail->AddBCC('social@afetur.com.br', 'E-mail de teste');

			$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
			$mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)

			$mail->Subject  = $assunto; // Assunto da mensagem
			$mail->Body = '
<table border="0" cellpadding="0" cellspacing="0" width="600" style="border-top: 3px solid #007eff; border-left: 1px solid #d4d4d4; border-right: 1px solid #d4d4d4; border-bottom: 3px solid #007eff">
						<tr>
							<td width="150" style="padding: 20px;" align="center"><img src="https://'.$host.'/eventos/email.png"/></td>
							<td width="450" style="padding: 20px; font-size: 18px;font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji""><strong>'.$enviadopor.'</strong><br>compartilhou este evento com você.</td>
						</tr>
						<tr>
							<td colspan="2" width="600">
								<img src="https://'.$host.'/eventos/'.$modeloevento.'" width="600"/>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding: 20px; font-size: 22px; color: #0097ff; font-weight: bold; text-align:left; font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji">'.$nomeevento.'</td>
						</tr>
						<tr style="border-bottom: 1px solid #d4d4d4;">
							<td colspan="2" style="border-bottom: 1px solid #d4d4d4;padding: 0 20px 20px 20px;font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji"">
								<strong>Organizado por:</strong> '.$organizadornome.'<br>
								<strong>Data:</strong> '.$dataevento.' às '.$horainicio.'<br>
								<strong>Local: </strong> '.$localevento.'
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding: 20px 20px 15px 20px;font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji"">
								'.$saudacao.'
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding: 0 20px 15px 20px;font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji"">
								'.$mensagem.'
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding: 0 20px 15px 20px;font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji"">
								 '.$despedida.'
							</td>
						</tr>
						<tr style="border-bottom: 1px solid #d4d4d4;">
							<td colspan="2" style="border-bottom: 1px solid #d4d4d4;padding: 0 20px 20px 20px;font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji"">
								
								<strong>'.$organizadornome.'</strong><br>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding: 20px;" align="center">
								<a href="https://'.$host.'/eventos/evento_single.php?ref='.$ref.'"><img src="https://'.$host.'/eventos/bt-ver-evento.png"/></a>							
							</td>
						</tr>
					</table>


			 ';
			//$mail->AltBody = 'Este é o corpo da mensagem de teste, em Texto Plano! \r\n 
			//<IMG src="http://seudominio.com.br/imagem.jpg" alt=5":)"  class="wp-smiley"> ';

			//$mail->AddAttachment("e:\home\login\web\documento.pdf", "novo_nome.pdf");

			$enviado = $mail->Send();

			$mail->ClearAllRecipients();
			$mail->ClearAttachments();
			
			if ($enviado) {
			header("Location: paginassucesso/sucesso-email-teste-email-mkt.php?ref=".$ref);
			} else {
			echo "Não foi possível enviar o e-mail.
			 
			";
			echo "Informações do erro: 
			" . $mail->ErrorInfo;
			}
		// Fim script para envio de e-mail referente ao pedido
?>