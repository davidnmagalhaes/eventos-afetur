<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

		require("phpmailer/vendor/autoload.php");

			$mail = new PHPMailer(true);

			$mail->IsSMTP(); // Define que a mensagem será SMTP
			$mail->Host = "smtplw.com.br"; // Endereço do servidor SMTP
			$mail->SMTPAuth = true; // Autenticação
			$mail->Username = 'afeturmail'; // Usuário do servidor SMTP
			$mail->Password = 'oWMIkPYV6054'; // Senha da caixa postal utilizada
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                 // Habilita criptografia TLS | 'ssl' também é possível
			$mail->Port = 587;   

			$mail->From = "contato@afetur.com.br"; 
			$mail->FromName = "Afetur Turismo";

			$mail->AddAddress($email[0], $nome[0]);
			$mail->AddAddress($email[0]);
			$mail->AddCC('contato@afetur.com.br', 'Pedido'); 
			//$mail->AddBCC('CopiaOculta@dominio.com.br', 'Copia Oculta');

			$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
			$mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)

			$mail->Subject  = "Inscrição em ".$evento; // Assunto da mensagem
			$mail->Body = '

			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
			<head>
			<body style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #FFFFFF;">
			
				<table class="nl-container" style="table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF; width: 100%;" cellpadding="0" cellspacing="0" role="presentation" width="100%" bgcolor="#FFFFFF" valign="top">
					<tbody>
						<tr style="vertical-align: top;" valign="top">
							<td style="word-break: break-word; vertical-align: top;" valign="top">
			
								<div style="background-color:#0a69ac;">
									<div class="block-grid " style="Margin: 0 auto; min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
										<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
			
											<div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;">
												<div style="width:100% !important;">
			
														<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:0px;padding-left:10px;">
															<div style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
																<p style="font-size: 22px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 26px; margin: 0;"><span style="font-size: 22px; color: #ffffff;"><strong><span style="font-size: 22px;">Parabéns! Sua inscrição foi realizada...</span></strong></span></p>
															</div>
														</div>
			
												</div>
											</div>
			
										</div>
									</div>
								</div>
								<div style="background-color:#EDEDED;">
									<div class="block-grid " style="Margin: 0 auto; min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
										<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
			
											<div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;">
												<div style="width:100% !important; padding: 15px">
			
														<div class="img-container center fullwidth fixedwidth" align="center">
			
			<a href="#" target="_blank" style="outline:none" tabindex="-1"> <img class="center fullwidth fixedwidth" align="center" border="0" src="https://'.$host2.'/'.$logo.'" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 264px; display: block;" width="264"></a>
			
														</div>
			
												</div>
											</div>
			
										</div>
									</div>
								</div>
								<div style="background-color:transparent;">
									<div class="block-grid " style="Margin: 0 auto; min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
										<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
			
											<div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;">
												<div style="width:100% !important;">
			
														<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:0px;padding-left:10px;">
															<div style="line-height: 1.2; font-size: 12px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: #555555; mso-line-height-alt: 14px;">
																<p style="font-size: 24px; line-height: 1.2; word-break: break-word; text-align: center; font-family: arial, helvetica, sans-serif; mso-line-height-alt: 29px; margin: 0;"><span style="font-size: 24px;"><strong><span style="font-size: 24px;">Veja os detalhes de seu pedido:</span></strong></span></p>
															</div>
														</div>
			
														<div style="color:#777777;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;">
															<div style="line-height: 1.2; font-size: 12px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: #777777; mso-line-height-alt: 14px;">
																<p style="text-align:center;font-size: 16px; line-height: 1.2; font-family: arial, helvetica, sans-serif; word-break: break-word; mso-line-height-alt: 19px; margin: 0;">
																	<span style="font-size: 16px;"><Br>
																				<strong>Atenção:</strong><br>
																				Esta é uma inscrição gratuita, podendo ser analisada pelos organizadores do evento para sua aprovação.<br><br>
																		
																				<strong>Nº do pedido:</strong><br>
																				#'.$cod.'<br><br>
																			
																				<strong>Data do pedido:</strong><br>
																				'.date('d/m/Y').'<br><br>
																			
																				<strong>Nome do Responsável:</strong><br>
																				'.$nome[0].'<br><br>
																			
																				<strong>Total do pedido:</strong><br>
																				R$ '.number_format($number,2,",",".").'<br><br>
																			
																				<strong>Forma de Pagamento:</strong><br>
																				'.$tipotransacao.'<br><br>
																			
																				<strong>Evento:</strong><br>
																				'.$evento.'<br><br>
																			
																				<strong>Inscritos:</strong><br>
																				'.implode( ', ' , array_filter($nome)).'<br><br>
																				
																			
																	</span>
																</p>
															</div>
														</div>
			
												</div>
											</div>
			
										</div>
									</div>
								</div>
								<div style="background-color:#444444;">
									<div class="block-grid " style="Margin: 0 auto; min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
										<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
											<div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;">
												<div style="width:100% !important;">
			
														<table class="social_icons" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; display:flex; justify-content:center" valign="top">
															<tbody>
																<tr style="vertical-align: top;" valign="top">
																	<td style="word-break: break-word; vertical-align: top; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;" valign="top">
																		<table class="social_table" align="center" cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-tspace: 0; mso-table-rspace: 0; mso-table-bspace: 0; mso-table-lspace: 0;" valign="top">
																			<tbody>
																				<tr style="vertical-align: top; display: inline-block; text-align: center;" align="center" valign="top">
																					<td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 3px; padding-left: 3px;" valign="top"><a href target="_blank" style="margin:0 auto"><img width="100" src="https://'.$host.'/eventos/afetur2.png" alt="Afetur Turismo" title="Afetur Turismo" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;"></a></td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
															</tbody>
														</table>
			
												</div>
											</div>
			
										</div>
									</div>
								</div>
			
							</td>
						</tr>
					</tbody>
				</table>
			
			</body>
			</html>




			 ';
			//$mail->AltBody = 'Este é o corpo da mensagem de teste, em Texto Plano! \r\n 
			//<IMG src="http://seudominio.com.br/imagem.jpg" alt=5":)"  class="wp-smiley"> ';

			//$mail->AddAttachment("e:\home\login\web\documento.pdf", "novo_nome.pdf");

			$enviado = $mail->Send();

			$mail->ClearAllRecipients();
			$mail->ClearAttachments();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Confirmação de Inscrição - Afetur Eventos</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
body {
	font-family: 'Varela Round', sans-serif;
}
.modal-confirm {		
	color: #636363;
	width: 325px;
	font-size: 14px;
}
.modal-confirm .modal-content {
	padding: 20px;
	border-radius: 5px;
	border: none;
}
.modal-confirm .modal-header {
	border-bottom: none;   
	position: relative;
}
.modal-confirm h4 {
	text-align: center;
	font-size: 26px;
	margin: 30px 0 -15px;
}
.modal-confirm .form-control, .modal-confirm .btn {
	min-height: 40px;
	border-radius: 3px; 
}
.modal-confirm .close {
	position: absolute;
	top: -5px;
	right: -5px;
}	
.modal-confirm .modal-footer {
	border: none;
	text-align: center;
	border-radius: 5px;
	font-size: 13px;
}	
.modal-confirm .icon-box {
	color: #fff;		
	position: absolute;
	margin: 0 auto;
	left: 0;
	right: 0;
	top: -70px;
	width: 95px;
	height: 95px;
	border-radius: 50%;
	z-index: 9;
	background: #82ce34;
	padding: 15px;
	text-align: center;
	box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
}
.modal-confirm .icon-box i {
	font-size: 58px;
	position: relative;
	top: 3px;
}
.modal-confirm.modal-dialog {
	margin-top: 80px;
}
.modal-confirm .btn {
	color: #fff;
	border-radius: 4px;
	background: #82ce34;
	text-decoration: none;
	transition: all 0.4s;
	line-height: normal;
	border: none;
}
.modal-confirm .btn:hover, .modal-confirm .btn:focus {
	background: #6fb32b;
	outline: none;
}
.trigger-btn {
	display: inline-block;
	margin: 100px auto;
}
</style>
</head>
<body>
<div class="text-center">
	<!-- Button HTML (to Trigger Modal) -->
	<a href="#myModal" class="trigger-btn" data-toggle="modal">Click to Open Confirm Modal</a>
</div>

<!-- Modal HTML -->
<div id="myModal" class="modal fade" data-backdrop="static">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">&#xE876;</i>
				</div>				
				<h4 class="modal-title w-100">Parabéns!</h4>	
			</div>
			<div class="modal-body">
				<p class="text-center">Sua inscrição foi realizada com sucesso!</p>
              <p class="text-center">Você receberá um e-mail com as informações da inscrição.</p>
			</div>
			<div class="modal-footer">
				<a href="evento_single.php?ref=<?php echo $ref;?>" class="btn btn-success btn-block" data-dismiss="modal">Voltar para o evento</a>
			</div>
		</div>
	</div>
</div>     
</body>
</html>