<?php 


include_once("config/conn.php");
$ref = $_POST['ref'];

if(isset($ref)):
		$query = "SELECT * FROM evn_pedidos ORDER BY id DESC";
		$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
		$row_eventos = mysqli_fetch_assoc($eventos);
		$cod = $row_eventos['id'];
		$cod += 1;
		
		$moeda = $_POST['moeda'];
		$origem = "Online";
		
		$qr = "SELECT * FROM evn_eventos WHERE ref='$ref'";
		$exibelogo = mysqli_query($link, $qr) or die(mysqli_error($link));
		$row_exibelogo = mysqli_fetch_assoc($exibelogo);
		$logo = $row_exibelogo['logo'];
		$emailcopia = $row_exibelogo['email_copia'];
		
		$host = $_SERVER['HTTP_HOST'];
		$host2 = $_SERVER['HTTP_HOST']."/eventos";
		
		
		
		$query = "SELECT * FROM evn_eventos WHERE ref='$ref'";
		$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
		$row_eventos = mysqli_fetch_assoc($eventos);
		
		$chavepaghiper = $row_eventos['appkeypaghiper'];
		
		// Variáveis dos ingressos
		$ingresso = $_POST['ingresso'];
		$valor = $_POST['valor'];
		$quantidade = $_POST['quantidade'];
		
		
		$nome = $_POST['nome'];
		$resultado = $_POST['resultado'];
		$email = $_POST['email'];
		$evento = $_POST['evento'];
		
		$campoadicional = $_POST['campoadicional'];
		$numberi = number_format($resultado, 2, '.', '');
		$number = str_replace(',','.', $numberi);
		$npedido = substr(uniqid(rand()), 0, 5);
		$ningresso = substr(uniqid(rand()), 0, 5);

		$tipotransacao = "Boleto";
		$totalboleto = $_POST['totalboleto'];
		$cpf = $_POST['cpf'];
		$telefone = $_POST['telefone'];

		$urlretorno = 'https://agenciaafetur.com.br/eventos/retorno_paghiper.php?ref='.$ref;
		
		$sql = "INSERT INTO evn_pedidos (descricao, status, nome, email, total_pedido, evento, ref, data_pedido, campo_adicional, npedido, tipo_transacao, moeda, origem) VALUES ('Pedido #', 1, '$nome[0]', '$email[0]', '$number', '$evento', '$ref', NOW(), '$campoadicional[0]', '$npedido', '$tipotransacao', '$moeda', '$origem');";

		foreach($ingresso as $key => $ing){

			if($quantidade[$key] != 0){
   
		
		$sql .= "INSERT INTO evn_pedidos_ing (ing, valor_ing, qtd_ing, ref_pedido) VALUES ('$ing', '$valor[$key]', '$quantidade[$key]', '$cod');";
			}
		}
		
		foreach($nome as $chave => $nm){
			$sql .= "INSERT INTO evn_inscritos (nome_inscrito, email_inscrito, cpadicional, pedido) VALUES ('$nm', '$email[$chave]', '$campoadicional[$chave]', '$cod');";

		}
		
		$link->multi_query($sql); 
		
		

// Código para emitir boleto no Paghiper
$qtdparcelas = $_POST['parcelas'];
$divideparcela = $totalboleto / $qtdparcelas;

$parcela = 0; // Não Alterar DEVE SEMPRE INICIAR EM 0 
$parcelaf = $qtdparcelas; // numero de parcelas que deseja o carne
$dataHoje = date('Y-m-d'); //não alterar, busca a data atual
$diavencimento = date('Y-m-d', strtotime("+5 days")); // Data do vencimento da primeira parcela, em formato Universal Y-M-D
while ($parcela < $parcelaf): // laço que calcula a quantidade de vezes que deve requisitar os boletos.
    if ($parcela > 0):
        $novovencimento = date('Y-m-d', strtotime('+ ' . $parcela . ' months', strtotime($diavencimento)));
    else:
        $novovencimento = $diavencimento;
    endif;
    $parcelan = $parcela + 1; // $parcelan serve para exibir corretamente o numero de parcelas do carne.
    $data1 = new DateTime($novovencimento);
    $data2 = new DateTime($dataHoje);

    $intervalo = $data1->diff($data2); // CALCULA A DIFERENÇA DE DATAS, PARA TRAZER O RESULTADOS EM DIAS CORRIDOS
    $vencimentoBoleto = $intervalo->days;

$data = array(
  'apiKey' => $chavepaghiper,
  'order_id' => $cod.' - Parcela '.$parcelan.' de '.$parcelaf, // código interno do lojista para identificar a transacao.
  'payer_email' => $email[0],
  'payer_name' => $nome[0], // nome completo ou razao social
  'payer_cpf_cnpj' => $cpf, // cpf ou cnpj
  'payer_phone' => $telefone, // fixou ou móvel
  //'payer_street' => 'Av Brigadeiro Faria Lima',
  //'payer_number' => '1461',
  //'payer_complement' => 'Torre Sul 4º Andar',
  //'payer_district' => 'Jardim Paulistano',
  //'payer_city' => 'São Paulo',
  //'payer_state' => 'SP', // apenas sigla do estado
  //'payer_zip_code' => '01452002',
  'notification_url' => $urlretorno,
  'discount_cents' => '0', // em centavos
  'shipping_price_cents' => '0', // em centavos
  //'shipping_methods' => 'PAC',
  'fixed_description' => true,
  'type_bank_slip' => 'boletoA4', // formato do boleto
  'days_due_date' => $vencimentoBoleto, // dias para vencimento do boleto
  'late_payment_fine' => '2',// Percentual de multa após vencimento.
  'per_day_interest' => true, // Juros após vencimento.
  'items' => array(
      array ('description' => 'Pedido: #'.$cod,
      'quantity' => '1',
'item_id' => '1',
'price_cents' => $divideparcela), // em centavos

),
);
$data_post = json_encode( $data );
$url = "http://api.paghiper.com/transaction/create/";
$mediaType = "application/json"; // formato da requisição
$charSet = "UTF-8";
$headers = array();
$headers[] = "Accept: ".$mediaType;
$headers[] = "Accept-Charset: ".$charSet;
$headers[] = "Accept-Encoding: ".$mediaType;
$headers[] = "Content-Type: ".$mediaType.";charset=".$charSet;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
$json = json_decode($result, true);
// captura o http code
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($httpCode == 201):
// CÓDIGO 201 SIGNIFICA QUE O BOLETO FOI GERADO COM SUCESSO
//echo $result;

// Exemplo de como capturar a resposta json
$transaction_id = $json['create_request']['transaction_id'];
$url_slip = $json['create_request']['bank_slip']['url_slip'];
$digitable_line = $json['create_request']['bank_slip']['digitable_line'];
$url_slip_pdf = $json['create_request']['bank_slip']['url_slip'];
$linkboleto = "<a href='".$url_slip_pdf."/pdf' target='_blank'><img src='https://".$host."/eventos/barcode.png' width='80'></a>";
echo "<a href='".$url_slip_pdf."/pdf' target='_blank'><strong>Visualizar PDF</strong></a>";
echo $resulta = file_get_contents($url_slip);
else:
//Esse trecho acessa a URL do boleto e exibe o conteudo na pagina, de acordo com a quantidade de parcelas, na hora da impressão ja gera a paginação.
     echo $result;   
	 echo "Infelizmente estamos com uma instabilidade em nossa emiss&atilde;o de boletos online, tente mais tarde ou ligue (85) 3048-1900. Se preferir poder&aacute; efetuar seu pagamento via Cart&atilde;o de Cr&eacute;dito. Tamb&acute;m sugerimos que tente por outro navegador. Obrigado!";
endif;

$parcela ++; // incrementa a contagem de parcelas, para que assim o laço se encerre na quantidade certa de parcelas 
endwhile; // fim do laço

endif;
?>

<?php
// Script para envio de e-mail referente ao pedido
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
			$mail->AddBCC($emailcopia);

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
																<p style="font-size: 22px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 26px; margin: 0;"><span style="font-size: 22px; color: #ffffff;"><strong><span style="font-size: 22px;">Parabéns! Seu pedido foi realizado...</span></strong></span></p>
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
																	<span style="font-size: 16px;">
																		
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
																				
																				<strong>Imprimir boleto:</strong><Br>
																				'.$linkboleto.'
																			
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
		// Fim script para envio de e-mail referente ao pedido

?>