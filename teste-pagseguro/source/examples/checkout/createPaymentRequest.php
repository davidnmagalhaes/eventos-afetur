<?php //

/*
 * ***********************************************************************
 Copyright [2011] [PagSeguro Internet Ltda.]

 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
 * ***********************************************************************
 */
 
 
 

require_once "../../PagSeguroLibrary/PagSeguroLibrary.php";


/***
 * Provides for user a option to configure their credentials without changes in PagSeguroConfigWrapper.php file.
 */ 
class PagSeguroConfigWrapper
{
    public static function getConfig()
    {
		$ref = $_POST['ref'];
		
		$local = "localhost";
		$usuario = "u366622768_eventos";
		$senha = "Emmgd2180";
		$banco = "u366622768_eventos";
		$link = mysqli_connect($local, $usuario, $senha, $banco);
		 
		if (!$link) {
			echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
			echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
			echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
			exit;
		}
		
		$query = "SELECT * FROM evn_eventos WHERE ref='$ref'";
		$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
		$row_eventos = mysqli_fetch_assoc($eventos);
	
		
        $PagSeguroConfig = array();

        $PagSeguroConfig['environment'] = "production"; // production, sandbox

        $PagSeguroConfig['credentials'] = array();
        $PagSeguroConfig['credentials']['email'] = $row_eventos['emailpagseguro'];
        $PagSeguroConfig['credentials']['token']['production'] = $row_eventos['tokenpagseguro'];
        //$PagSeguroConfig['credentials']['token']['sandbox'] = "74FA269053B54E98B8C37791C1B1C39E";
        $PagSeguroConfig['credentials']['appId']['production'] = $row_eventos['appidpagseguro'];
        //$PagSeguroConfig['credentials']['appId']['sandbox'] = "app4124819992";
        $PagSeguroConfig['credentials']['appKey']['production'] = $row_eventos['appkeypagseguro'];
        //$PagSeguroConfig['credentials']['appKey']['sandbox'] = "DB997C172B2B64CEE4EDCF98819B029B";

        $PagSeguroConfig['application'] = array();
        $PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

        $PagSeguroConfig['log'] = array();
        $PagSeguroConfig['log']['active'] = false;
        // Informe o path completo (relativo ao path da lib) para o arquivo, ex.: ../PagSeguroLibrary/logs.txt
        $PagSeguroConfig['log']['fileLocation'] = "";

        return $PagSeguroConfig;
    }
}

/**
 * Class with a main method to illustrate the usage of the domain class PagSeguroPaymentRequest
 */
class CreatePaymentRequest
{

    public static function main()
    {
		$host = $_SERVER['HTTP_HOST'];
		$ref = $_POST['ref'];
		//Conexão com o banco de dados
		$local = "localhost";
		$usuario = "u366622768_eventos";
		$senha = "Emmgd2180";
		$banco = "u366622768_eventos";
		$link = mysqli_connect($local, $usuario, $senha, $banco);
		 
		if (!$link) {
			echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
			echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
			echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
			exit;
		}
		
		$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
		$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
		$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
		$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
		$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
		$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
		$symbian = strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
		$windowsphone = strpos($_SERVER['HTTP_USER_AGENT'],"Windows Phone");

		if ($iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian || $windowsphone == true) {
		   $dispositivo = "Mobile";
		 }

		else { $dispositivo = "Computador";} 
		
		// Variáveis dos ingressos
		$ingresso = $_POST['ingresso'];
		$valor = $_POST['valor'];
		$quantidade = $_POST['quantidade'];
		$ref = $_POST['ref'];
		
		$origem = "Online";
		
		$vrl = 0;
		foreach($valor as $kg => $vr){
			$vrl += $quantidade[$kg] * $valor[$kg];
		}
		$price = number_format($vrl, 2, '.', '');
		$nome = $_POST['nome'];
		
		$email = $_POST['email'];
		$evento = $_POST['evento'];
		$ref = $_POST['ref'];
		$campoadicional = $_POST['campoadicional'];
		
		
		
		$npedido = substr(uniqid(rand()), 0, 5);
		$ningresso = substr(uniqid(rand()), 0, 5);
		
		$query = "SELECT * FROM evn_pedidos ORDER BY id DESC";
		$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
		$row_eventos = mysqli_fetch_assoc($eventos);
		$cod = $row_eventos['id'];
		$cod += 1;
		
		$qr = "SELECT * FROM evn_eventos WHERE ref='$ref'";
		$exibelogo = mysqli_query($link, $qr) or die(mysqli_error($link));
		$row_exibelogo = mysqli_fetch_assoc($exibelogo);
		$logo = $row_exibelogo['logo'];
		$emailcopia = $row_exibelogo['email_copia'];
		$host = $_SERVER['HTTP_HOST'];
		$voucher = 1;
		
		
		$tipotransacao = "Pagseguro";
		$moeda = $_POST['moeda'];
		
		
        // Instantiate a new payment request
        $paymentRequest = new PagSeguroPaymentRequest();

        // Set the currency
        $paymentRequest->setCurrency("BRL");

        // Add an item for this payment request
		
		$sql = "INSERT INTO evn_pedidos (descricao, status, nome, email, total_pedido, evento, ref, data_pedido, campo_adicional, npedido, tipo_transacao, moeda, dispositivo, origem) VALUES ('Pedido #', 1, '$nome[0]', '$email[0]', '$price', '$evento', '$ref', NOW(), '$campoadicional[0]', '$npedido', '$tipotransacao', '$moeda', '$dispositivo', '$origem');";

		foreach($ingresso as $ke => $ingre){

			if($quantidade[$ke] != 0 && $valor[$ke] != 0){
        $paymentRequest->addItem((string)$ke, $ingre, $quantidade[$ke], $valor[$ke]);
		
			}
			
			
		}
		
		foreach($ingresso as $key => $ing){

			if($quantidade[$key] != 0){
		
		$sql .= "INSERT INTO evn_pedidos_ing (ing, valor_ing, qtd_ing, ref_pedido) VALUES ('$ing', '$valor[$key]', '$quantidade[$key]', '$cod');";
			}
		}
		
		foreach($nome as $chave => $nm){
			$sql .= "INSERT INTO evn_inscritos (voucher, nome_inscrito, email_inscrito, cpadicional, pedido) VALUES ('$voucher','$nm', '$email[$chave]', '$campoadicional[$chave]', '$cod');";

		}
		

		$link->multi_query($sql); 

		$link->close();
		
		// Script para envio de e-mail referente ao pedido
		require("../../../../phpmailer/class.phpmailer.php");

			$mail = new PHPMailer();

			$mail->IsSMTP(); // Define que a mensagem será SMTP
			$mail->Host = "smtp.afetur.com.br"; // Endereço do servidor SMTP
			$mail->SMTPAuth = true; // Autenticação
			$mail->Username = 'contato@afetur.com.br'; // Usuário do servidor SMTP
			$mail->Password = 'Afetur159753@'; // Senha da caixa postal utilizada

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
				<table width="600"  style="font-family: calibri">
			  <tr  >
				<th colspan="3" scope="row" style="padding: 5px; color: #369"><h1>Parabéns! Seu pedido foi realizado...</h1></th>
			  </tr>
			  <tr  >
				<th colspan="3" scope="row" style="background: #369; color: #fff; padding: 5px;"><strong>Número do pedido:</strong> #'.$cod.'</th>
			  </tr>
			  <tr style="background: #DAE3FC; ">
				<th width="197" rowspan="6" scope="row" style="padding: 5px;"><a href="http://www.'.$host.'/eventos/'.$logo.'"><img src="http://www.'.$host.'/eventos/'.$logo.'" width="300"/></a></th>
				<td width="139" align="right" style="padding: 5px;"><strong>Data do pedido: </strong></td>
				<td width="242" style="padding: 5px;">'.date('d/m/Y').'</td>
			  </tr>
			  <tr style="background: #DAE3FC">
				<td align="right" style="padding: 5px;"><strong>Nome:</strong></td>
				<td style="padding: 5px;">'.$nome[0].'</td>
			  </tr>
			  <tr style="background: #DAE3FC">
				<td align="right" style="padding: 5px;"><strong>Total do pedido:</strong></td>
				<td style="padding: 5px;">R$ '.$price.'</td>
			  </tr>
			  <tr style="background: #DAE3FC">
				<td align="right" style="padding: 5px;"><strong>Pagamento:</strong></td>
				<td style="padding: 5px;">'.$tipotransacao.'</td>
			  </tr>
			  <tr style="background: #DAE3FC">
				<td align="right" style="padding: 5px;"><strong>Evento:</strong></td>
				<td style="padding: 5px;">'.$evento.'</td>
			  </tr>
			  
			  <tr style="background: #DAE3FC">
				<td align="right" style="padding: 5px;"><strong>Inscritos:</strong></td>
				<td style="padding: 5px;">'.implode( ', ' , array_filter($nome)).'</td>
			  </tr>
			  
			  <tr>
    <td height="36" colspan="3" align="center" style="padding: 3px; background: #CCE4FF;"><img src="http://www.'.$host.'/eventos/afetur.png" width="100"/><br>
      <p>Rua General Tertuliano Potiguara, 1064, Aldeota, Fortaleza, CE<br>
      (85) 3048-1900      </p></td>
    </tr>
	<tr >
    <th colspan="2" scope="row" style=" font-size: 14px; padding: 3px; color: #000;">* Este é o comprovante de seu ingresso. Faça a impressão e apresente-o no dia do evento.</th>
  </tr>
			</table>
			 ';
			//$mail->AltBody = 'Este é o corpo da mensagem de teste, em Texto Plano! \r\n 
			//<IMG src="http://seudominio.com.br/imagem.jpg" alt=5":)"  class="wp-smiley"> ';

			//$mail->AddAttachment("e:\home\login\web\documento.pdf", "novo_nome.pdf");

			$enviado = $mail->Send();

			$mail->ClearAllRecipients();
			$mail->ClearAttachments();
		// Fim script para envio de e-mail referente ao pedido
		

        // Set a reference code for this payment request. It is useful to identify this payment
        // in future notifications.
        $paymentRequest->setReference($cod);

        // Set shipping information for this payment request
        $sedexCode = PagSeguroShippingType::getCodeByType('SEDEX');
        $paymentRequest->setShippingType($sedexCode);
       /* $paymentRequest->setShippingAddress(
            '01452002',
            'Av. Brig. Faria Lima',
            '1384',
            'apto. 114',
            'Jardim Paulistano',
            'São Paulo',
            'SP',
            'BRA'
        );*/

        // Set your customer information.
        $paymentRequest->setSender(
            $nome[0],
            $email[0],
            '',//DDD
            '',//Telefone
            'CPF',
            ''//CPF ex. 156.009.442-76
        );

        // Set the url used by PagSeguro to redirect user after checkout process ends
        $paymentRequest->setRedirectUrl("http://www.afetur.com.br");

        // Add checkout metadata information
        //$paymentRequest->addMetadata('PASSENGER_CPF', '15600944276', 1);
       // $paymentRequest->addMetadata('GAME_NAME', 'DOTA');
        //$paymentRequest->addMetadata('PASSENGER_PASSPORT', '23456', 1);

        // Another way to set checkout parameters
       $paymentRequest->addParameter('notificationURL', 'http://afetur.com.br/eventos/pagseguro/notificacao.php');
        //$paymentRequest->addParameter('senderBornDate', '07/05/1981');
        //$paymentRequest->addIndexedParameter('itemId', '0003', 3);
        //$paymentRequest->addIndexedParameter('itemDescription', 'Notebook Preto', 3);
        //$paymentRequest->addIndexedParameter('itemQuantity', '1', 3);
        //$paymentRequest->addIndexedParameter('itemAmount', '200.00', 3);

        // Add discount per payment method
        //$paymentRequest->addPaymentMethodConfig('CREDIT_CARD', 1.00, 'DISCOUNT_PERCENT');
        //$paymentRequest->addPaymentMethodConfig('EFT', 2.90, 'DISCOUNT_PERCENT');
        //$paymentRequest->addPaymentMethodConfig('BOLETO', 10.00, 'DISCOUNT_PERCENT');
        //$paymentRequest->addPaymentMethodConfig('DEPOSIT', 3.45, 'DISCOUNT_PERCENT');
        //$paymentRequest->addPaymentMethodConfig('BALANCE', 0.01, 'DISCOUNT_PERCENT');

        // Add installment without addition per payment method
        $paymentRequest->addPaymentMethodConfig('CREDIT_CARD', 2, 'MAX_INSTALLMENTS_NO_INTEREST');

        // Add installment limit per payment method
        //$paymentRequest->addPaymentMethodConfig('CREDIT_CARD', 6, 'MAX_INSTALLMENTS_LIMIT');

        // Add and remove a group and payment methods
        $paymentRequest->acceptPaymentMethodGroup('CREDIT_CARD', 'DEBITO_ITAU');      
        $paymentRequest->excludePaymentMethodGroup('BOLETO', 'BOLETO');

        try {

            /*
             * #### Credentials #####
             * Replace the parameters below with your credentials
             * You can also get your credentials from a config file. See an example:
             * $credentials = new PagSeguroAccountCredentials("vendedor@lojamodelo.com.br",
             * "E231B2C9BCC8474DA2E260B6C8CF60D3");
             */

            // seller authentication
            $credentials = PagSeguroConfig::getAccountCredentials();

            // application authentication
            //$credentials = PagSeguroConfig::getApplicationCredentials();

            //$credentials->setAuthorizationCode("E231B2C9BCC8474DA2E260B6C8CF60D3");

            // Register this payment request in PagSeguro to obtain the payment URL to redirect your customer.
            $url = $paymentRequest->register($credentials);

            self::printPaymentUrl($url);

        } catch (PagSeguroServiceException $e) {
            die($e->getMessage());
        }
    
	}
    public static function printPaymentUrl($url)
    {
        if ($url) {
            header('Location: '.$url.'');
			
			
        }
    }
}

CreatePaymentRequest::main();

