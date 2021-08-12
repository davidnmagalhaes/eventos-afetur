<?php 
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

include_once("config/conn.php");

		$ref = $_POST['ref'];
		
		$query = "SELECT * FROM evn_eventos WHERE ref='$ref'";
		$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
		$row_eventos = mysqli_fetch_assoc($eventos);
		
		$chavepaypal = $row_eventos['clientidpaypal'];
		
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
		$ningresso = substr(uniqid(rand()), 0, 5);
		$cod = $_POST['cod'];
		$tipotransacao = "Paypal";
		$totalboleto = $_POST['totalboleto'];
		$moeda = $_POST['moeda'];
		
		$sql = "INSERT INTO evn_pedidos (descricao, status, nome, email, total_pedido, evento, ref, data_pedido, campo_adicional, npedido, tipo_transacao, moeda) VALUES ('Pedido #', 1, '$nome[0]', '$email[0]', '$number', '$evento', '$ref', NOW(), '$campoadicional[0]', '$npedido', '$tipotransacao', '$moeda');";

		foreach($ingresso as $key => $ing){

		if($quantidade[$key] != 0){
   
		$pedido = $ningresso++;
		$sql .= "INSERT INTO evn_pedidos_ing (ing, valor_ing, qtd_ing, ref_pedido, numero_inscrito) VALUES ('$ing', '$valor[$key]', '$quantidade[$key]', '$cod', '$pedido');";
			}
		}
		
		foreach($nome as $chave => $nm){
		$sql .= "INSERT INTO evn_inscritos (nome_inscrito, email_inscrito, cpadicional, pedido) VALUES ('$nm', '$email[$chave]', '$campoadicional[$chave]', '$cod');";

		}
		

		$link->multi_query($sql); 

		$link->close();
		
		// Script para envio de e-mail referente ao pedido
		require("phpmailer/class.phpmailer.php");

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
			//$mail->AddBCC('CopiaOculta@dominio.com.br', 'Copia Oculta');

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
				<th width="197" rowspan="6" scope="row" style="padding: 5px;"><img src="#" /></th>
				<td width="139" align="right" style="padding: 5px;"><strong>Data do pedido: </strong></td>
				<td width="242" style="padding: 5px;">17/05/2019</td>
			  </tr>
			  <tr style="background: #DAE3FC">
				<td align="right" style="padding: 5px;"><strong>Nome:</strong></td>
				<td style="padding: 5px;">'.$nome[0].'</td>
			  </tr>
			  <tr style="background: #DAE3FC">
				<td align="right" style="padding: 5px;"><strong>Total do pedido:</strong></td>
				<td style="padding: 5px;">R$ '.$number.'</td>
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
			</table>
			 ';
			//$mail->AltBody = 'Este é o corpo da mensagem de teste, em Texto Plano! \r\n 
			//<IMG src="http://seudominio.com.br/imagem.jpg" alt=5":)"  class="wp-smiley"> ';

			//$mail->AddAttachment("e:\home\login\web\documento.pdf", "novo_nome.pdf");

			$enviado = $mail->Send();

			$mail->ClearAllRecipients();
			$mail->ClearAttachments();
		// Fim script para envio de e-mail referente ao pedido

	?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Paypal - Pagamento seguro!</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes"/>
        <link rel="shortcut icon" href="https://www.paypalobjects.com/webstatic/developer/favicons/pp32.png" type="image/x-icon" />

        <link rel="stylesheet" href="https://www.paghiper.com/css/checkout.css" />
        <script src="https://www.paghiper.com/js/jquery-1.11.2.min.js"></script>
        <script src="https://www.paghiper.com/js/jquery-mask.js"></script>
        <script src="https://www.paghiper.com/js/config.js"></script>
        <script>
            //SCRIPT RESPONSÁVEL POR EXIBIR OU OCULTAR A PESSOA FISICA OU JURIDICA
            var Main = function(){
                var self = this;
                
                this.verificaPessoa = function(value){
                    if(value == 'pf'){
                        $('.pj').hide();
                        $('.pf').show();
                        $('.cpf').attr('required', 'required');
                        $('.cnpj').removeAttr('required');
                        $('.rsocial').removeAttr('required');
                    } else {
                        $('.pj').show();
                        $('.pf').hide();
                        $('.cpf').removeAttr('required');
                        $('.cnpj').attr('required', 'required');
                        $('.rsocial').attr('required', 'required');
                    }
                };
                
            };            
            var ctrl = new Main();
            
            $(function(){
                ctrl.verificaPessoa('pf');
            });
        </script>
		<style>
			fieldset .grid-btn-payment input {
    margin: 25px 0 0 0;
    padding: 15px 40px 15px 65px;
    font-weight: bold;
    background: #ff921f;
    background-size: 35px;
    text-align: right;
    display: inline-block;
}
		</style>
    </head>
    <body>
	<script
    src="https://www.paypal.com/sdk/js?client-id=<?php echo $chavepaypal;?>&currency=<?php switch($moeda){case "AU$": echo "AUD"; break; case "C$": echo "CAD"; break; case "€": echo "EUR"; break; case "¥": echo "JPY"; break; case "NT$": echo "TWD"; break; case "£": echo "GBP"; break; case "&#x20bd;": echo "RUB"; break; case "US$": echo "USD"; break; default: echo "BRL";}?>">
  </script>
        <div id="header">
            <div class="page">
                <img src="logo-paypal.jpg" alt="PagHiper - Forma facil e segura de comprar na Internet" border="0"/>
                <dl>
                    <dt></dt>
                    <dd></dd>
                </dl>
            </div>
        </div>
        <div class="page">
		
		
		  <br />
            <h1 style="margin-bottom: -5px;">Finalizar Compra - #Pedido <?php echo $cod;?></h1>
            <hr />
            <br />
            <br />
            
            
            <fieldset>
                <legend>Lista de produtos</legend>
            <!--
                * INICIO DA TABELA ONDE APRESENTA A LISTAGEM DE PRODUTOS
            -->
			
			<input type="hidden" name="totalboleto" id="totalboleto" value="<?php echo $totalboleto;?>">
			<input type="hidden" name="tipotransacao" id="tipotransacao" value="<?php echo $tipotransacao;?>">
			<input type="hidden" name="cod" id="cod" value="<?php echo $cod;?>">
			<input type="hidden" name="resultado" id="resultado" value="<?php echo $resultado;?>">
			<input type="hidden" name="ref" id="ref" value="<?php echo $ref;?>">
			<input type="hidden" name="evento" id="evento" value="<?php echo $evento;?>">
			<?php foreach($nome as $chave => $name){?>
			<input type="hidden" name="nome[]" id="nome" value="<?php echo $name;?>">
			<input type="hidden" name="email[]" id="email" value="<?php echo $email[$chave];?>">
			<input type="hidden" name="campoadicional[]" id="campoadicional" value="<?php echo $campoadicional[$chave];?>">
			<?php }?>
            <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                    <thead>
                        <tr>
                            <th width="55%" align="left">Nome do produto(s)</th>
                            <th width="5%">Quantidade</th>
                            <th>Preço Un.</th>
                            
                        </tr>
                    </thead>
                                        
                    <tbody>
                        <!-- AQUI SERÁ ONDE DEVERÁ LISTAR OS PRODUTOS -->
						<?php foreach($ingresso as $key => $ing){?>
						<?php if($quantidade[$key] > 0){ ?>
                        <tr>
                                <td><?php echo $ing;?></td>
                                <td align="center"> <strong><?php echo $quantidade[$key];?></strong> </td>
                                <td align="center"><?php echo $valor[$key];?></td>
                                
                        </tr>   
							<?php } ?>
						<?php } ?>
						
						
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2" align="right">
                                <!-- AQUI DEVERÁ APRESENTAR O TOTAL DA COMPRA -->
                                <table width="100%">
                                    
                                    
                                 
                                    
                                    <tr class="table-total">
                                        <td>Total:</td>
                                        <td align="right"><?php echo $moeda;?> <?php echo $number;?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tfoot>
                    
                                        
                </table>
            </div>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <!--Tipo do botão-->
    <input type="hidden" name="cmd" value="_xclick" />
 
    <!--Vendedor e URL de retorno, cancelamento e notificação-->
    <input type="hidden" name="business" value="paypal@afetur.com.br" />
    <input type="hidden" name="return" value="http://afetur.com.br/retorno" />
    <input type="hidden" name="cancel" value="http://afetur.com.br/cancelamento" />
    <input type="hidden" name="notify_url" value="http://afetur.com.br/notificacao" />
 
    <!--Internacionalização e localização da página de pagamento-->
    <input type="hidden" name="charset" value="utf-8" />
    <input type="hidden" name="lc" value="BR" />
    <input type="hidden" name="country_code" value="BR" />
    <input type="hidden" name="currency_code" value="BRL" />
 
    <!--Informações sobre o produto e seu valor-->
    <input type="hidden" name="amount" value="172.00" />
    <input type="hidden" name="item_name" value="Servico" />
    <input type="hidden" name="quantity" value="1" />
 
    

			<div class="grid-btn-payment text-center" id="paypal-button-container" style="margin:30px 0 0 0;">
                      
                    </div>
            </fieldset>
            
        </div>
		</form>
		<div id="paypal-button-container"></div>
		
		
 <div id="rodape">
            <div class="page">
                <p>Todos os direitos reservados a Afetur | © 2019</p>
            </div>
        </div>
    </body>
	
	
	<script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: <?php echo $number;?>
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        alert('Transaction completed by ' + details.payer.name.given_name);
        // Call your server to save the transaction
        return fetch('/paypal-transaction-complete', {
          method: 'post',
          headers: {
            'content-type': 'application/json'
          },
          body: JSON.stringify({
            orderID: data.orderID
          })
        });
      });
    }
  }).render('#paypal-button-container');
</script>
</html>