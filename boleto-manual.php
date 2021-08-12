<?php 

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}
include_once("config/conn.php");
		
		// Variáveis dos ingressos
		$ingresso = $_POST['ingresso'];
		$valor = $_POST['valor'];
		$quantidade = $_POST['quantidade'];
		$ref = $_POST['ref'];
		
		$nome = $_POST['nome'];
		$resultado = $_POST['resultado'];
		$email = $_POST['email'];
		$evento = $_POST['evento'];
		$ref = $_POST['ref'];
		$campoadicional = $_POST['campoadicional'];
		$numberi = number_format($resultado, 2, '.', '');
		$number = str_replace(',','.', $numberi);
		$ningresso = substr(uniqid(rand()), 0, 5);
		$query = "SELECT * FROM evn_pedidos ORDER BY id DESC";
		$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
		$row_eventos = mysqli_fetch_assoc($eventos);
		$cod = $row_eventos['id'];
		$cod += 1;
		$tipotransacao = "Boleto";
		$totalboleto = $_POST['totalboleto'];
		$moeda = $_POST['moeda'];
		
		$origem = "Manual";
		
		$qr = "SELECT * FROM evn_eventos WHERE ref='$ref'";
		$exibelogo = mysqli_query($link, $qr) or die(mysqli_error($link));
		$row_exibelogo = mysqli_fetch_assoc($exibelogo);
		$logo = $row_exibelogo['logo'];
		$host = $_SERVER['HTTP_HOST'];
		
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
				<th width="197" rowspan="6" scope="row" style="padding: 5px;"><a href="http://www.'.$host.'/eventos/'.$logo.'"><img src="http://www.'.$host.'/eventos/'.$logo.'" width="300"/></a></th>
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

	?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PagHiper - Último passo para gerar o boleto bancário</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes"/>
        <link rel="shortcut icon" href="https://www.paghiper.com/img/icon/ico.gif" />
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
		<script language="javascript">    
         document.onkeydown = function () { 
           switch (event.keyCode) {
             case 116 :  
                event.returnValue = false;
                event.keyCode = 0;           
                return false;             
              case 82 : 
                if (event.ctrlKey) {  
                   event.returnValue = false;
                  event.keyCode = 0;             
                  return false;
           }
         }
     } 
     </script>
    </head>
    <body>
        <div id="header">
            <div class="page">
                <img src="https://www.paghiper.com/img/logo.gif" alt="PagHiper - Forma facil e segura de comprar na Internet" border="0"/>
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
                <legend>Forma de Pagamento</legend>
                <div>
                    <div class="col col-1 vertical-align-middle" style="padding: 15px">
                        <img src="https://www.paghiper.com/img/icon/boleto-bancario-ico-gray.jpg" alt="Boleto Bancário" />
                    </div>
                    <div class="col col-8 vertical-align-middle" >
                        <h3 style="margin:0 0 5px 0;">Boleto Bancário</h3>
                        <p style="margin: 0">
                            Seu pagamento será processado pelo PagHiper!  <strong></strong>.
                        </p>
                    </div>
                </div>
            </fieldset>
            <br />
            <br />
            <br />
            
            <fieldset>
                <legend>Lista de produtos</legend>
            <!--
                * INICIO DA TABELA ONDE APRESENTA A LISTAGEM DE PRODUTOS
            -->
			<form method="post" action="paghiper-manual.php">
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
						
						<?php foreach($ingresso as $key => $ingr){?>
						<?php if($quantidade[$key] > 0){ ?>
                        <tr>
                                <td><input type="hidden" name="ingresso[]" id="ingresso" value="<?php echo $ingr;?>"></td>
                                <td align="center"> <strong><input type="hidden" name="quantidade[]" id="quantidade" value="<?php echo $quantidade[$key];?>"></strong> </td>
                                <td align="center"><input type="hidden" name="valor[]" id="valor" value="<?php echo $valor[$key];?>"></td>
                                
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
                                        <td align="right">R$ <?php echo $number;?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tfoot>
                    
                                        
                </table>
            </div>
            </fieldset>
            <div>
                <br />
                <br />
                <br />
                
                <fieldset>
                    <legend>Identificação para finalizar a compra</legend>
                    
                    <div>
                        <div class="col col-5">
                            <label><strong>Nome </strong><span class="tx-red">*</span></label>
                            <div>
                                <input type="text" placeholder="Informe seu nome" readonly name="nomepagante" value="<?php echo $nome[0];?>" readonly class="ipt col-9" required/>
                            </div>
                        </div>
                        <div class="col col-5 pf">
                            <label><strong>CPF </strong><span class="tx-red">*</span></label>
                            <div>
                                <input type="text" name="cpf" placeholder="Informe seu CPF" class="ipt col-9 cpf" required/>
                            </div>
                        </div>
                       
                    </div>
                    
                    <br />
                    <div>
                        <div class="col col-5">
                            <label><strong>E-mail </strong><span class="tx-red">*</span></label>
                            <div>
                                <input type="email" name="emailpagante" readonly value="<?php echo $email[0];?>" placeholder="Informe seu E-mail" class="ipt col-9" required/>
                            </div>
                        </div>
                        <div class="col col-2">
                            <label><strong>Telefone </strong><span class="tx-red">*</span></label>
                            <div>
                                <input type="text" name="telefone" placeholder="Informe seu telefone" class="ipt col-9 telefone" required />
                            </div>
                        </div>
                    </div>
					<div>
                        
                        <div class="col col-2" style="margin-top: 15px;">
                            <label><strong>Parcelas </strong><span class="tx-red">*</span></label>
                            <div>
								<select name="parcelas" id="parcelas" class="ipt col-9">
									<option value="1">Boleto á vista</option>
									<option value="2">2 parcelas</option>
									<option value="3">3 parcelas</option>
									<option value="4">4 parcelas</option>
									<option value="5">5 parcelas</option>
									<option value="6">6 parcelas</option>
									<option value="7">7 parcelas</option>
									<option value="8">8 parcelas</option>
									<option value="9">9 parcelas</option>
									<option value="10">10 parcelas</option>
								</select>
                            </div>
                        </div>
						<div class="col col-2">
                            <label><strong>Primeiro vencimento </strong><span class="tx-red">*</span></label>
                            <div>
                                <input type="date" name="pvenc" class="ipt col-9" required />
                            </div>
                        </div>
                    </div>
                    <div class="grid-btn-pagamento text-right">
                        <input type="submit" value="Gerar Boleto!" />
                    </div>
                </fieldset>
                </form>
            </div>
        </div>
        
        <div id="rodape">
            <div class="page">
                <p>Todos os direitos reservados a PagHiper Serviços Online - CNPJ: 20.110.153-0001/07 | © 2017</p>
            </div>
        </div>
    </body>
</html>
