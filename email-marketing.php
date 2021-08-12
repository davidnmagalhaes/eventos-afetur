<?php
include("valida_pagina.php");

$ref = $_GET['ref'];

$query = "SELECT * FROM evn_eventos WHERE ref='$ref'";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);
$totalRows_eventos = mysqli_num_rows($eventos);

$qrsmtp = "SELECT * FROM evn_user_smtp";
$smtp = mysqli_query($link, $qrsmtp) or die(mysqli_error($link));
$row_smtp = mysqli_fetch_assoc($smtp);
$totalRows_smtp = mysqli_num_rows($smtp);

$qr = "SELECT * FROM evn_inscritos INNER JOIN evn_pedidos ON evn_inscritos.pedido = evn_pedidos.id GROUP BY evn_pedidos.ref";
$lista = mysqli_query($link, $qr) or die(mysqli_error($link));
$row_lista = mysqli_fetch_assoc($lista);
$totalRows_lista = mysqli_num_rows($lista);

$qs = "SELECT * FROM evn_lista_email WHERE status_lista = '1' ORDER BY id_lista DESC ";
$emails = mysqli_query($link, $qs) or die(mysqli_error($link));
$row_emails = mysqli_fetch_assoc($emails);

$host = $_SERVER['HTTP_HOST'];
?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>E-mail Marketing de Eventos - Afetur Eventos</title>
	    <?php include('head.php');?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="js/jquery-2.1.3.js"></script>
<style>
div#loader{
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0px;
	left:0px;
	background-color: #eee;
	background-image: url('img/load.gif');
	background-position: center center;
	background-repeat: no-repeat;
	background-size: cover;
	z-index: 9999;
}
</style>
	<!--<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>-->
<script language="JavaScript" type="text/javascript">

$(document).ready(function(){
    $("a.remove").click(function(e){
        if(!confirm('Tem certeza que deseja excluir?')){
            e.preventDefault();
            return false;
        }
        return true;
    });
});
</script>
		
  </head>
   <body>
       <div id="loader"></div>
	   <?php
		require_once('nav-main.php');
	   ?>
<form method="POST" action="enviar-email-teste.php" name="disparo">

	<!-- Campos ocultos -->
		<input type="hidden" name="ref" id="ref" value="<?php echo $row_eventos['ref'];?>"/>
		<input type="hidden" name="modelo_evento" id="modelo_evento" value="<?php echo $row_eventos['modelo_evento'];?>"/>
		<input type="hidden" name="organizador_nome" id="organizador_nome" value="<?php echo $row_eventos['organizador_nome'];?>"/>
		<input type="hidden" name="hora_inicio" id="hora_inicio" value="<?php echo $row_eventos['hora_inicio'];?>"/>
		<input type="hidden" name="nome_evento" id="nome_evento" value="<?php echo $row_eventos['nome_evento'];?>"/>
		<input type="hidden" name="dataevento" id="dataevento" value="<?php if($row_eventos['data_inicio'] == $row_eventos['data_final']){ echo date('d/m/Y', strtotime($row_eventos['data_inicio']));}else{echo date('d/m/Y', strtotime($row_eventos['data_inicio']))." at&eacute; ".date('d/m/Y', strtotime($row_eventos['data_final']));} ?>"/>
		<input type="hidden" name="localevento" id="localevento" value="<?php echo $row_eventos['local_nome']; ?>"/>
	<!-- Campos ocultor -->
	
	<div class="container content" style="min-height: 780px;">
		<h3><i class="fas fa-envelope-open-text"></i> Personalizar convite - Disparo de e-mails</h3>
		<div class="row" style="margin: 20px 20px 0 20px;">
			<div class="col">
				<div class="form-group">
					<label for="enviadopor">Enviado por:</label>
					<input type="text" class="form-control" id="enviadopor" name="enviadopor" placeholder="Nome do remetente">
				  </div>
			</div>
			<div class="col">
				<div class="form-group">
					<label for="responder">Responder a:</label>
					<select class="form-control" name="responder" id="responder">
						<?php do{?>
						<option value="<?php echo $row_smtp['id_smtp'];?>"><?php echo $row_smtp['email_smtp'];?></option>
						<?php } while ($row_smtp = mysqli_fetch_assoc($smtp));?>
					</select>
				  </div>
			</div>
		</div>
		<div class="row" style="margin: 0 20px 20px 20px;">
			<div class="col">
				<div class="form-group">
					<label for="assunto">Assunto:</label>
					<input type="text" class="form-control" id="assunto" name="assunto" placeholder="Digite o assunto deste e-mail">
				  </div>
			</div>
		</div>
		
		<div class="row" style="background: #b5b5b5; padding: 15px; border-radius: 20px; margin: 0 20px;">
			<div class="col" >
				<div style="width: 600px; min-height: 600px; background: #fff; margin: 0 auto; border-top: 3px solid #007eff;">
					<table border="0">
						<tr>
							<td width="150" style="padding: 20px;" align="center"><img src="email.png"/></td>
							<td width="450" style="padding: 20px; font-size: 18px;"><strong><?php echo $row_eventos['organizador_nome'];?></strong><br>compartilhou este evento com você.</td>
						</tr>
						<tr>
							<td colspan="2" width="600">
								<img src="<?php echo $row_eventos['modelo_evento'];?>" width="600"/>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding: 20px; font-size: 22px; color: #0097ff; font-weight: bold; text-align:left;"><?php echo $row_eventos['nome_evento'];?></td>
						</tr>
						<tr style="border-bottom: 1px solid #d4d4d4;">
							<td colspan="2" style="padding: 0 20px 20px 20px;">
								<strong>Organizado por:</strong> <?php echo $row_eventos['organizador_nome'];?><br>
								<strong>Data:</strong> <?php if($row_eventos['data_inicio'] == $row_eventos['data_final']){ echo date('d/m/Y', strtotime($row_eventos['data_inicio']));}else{echo date('d/m/Y', strtotime($row_eventos['data_inicio']))." at&eacute; ".date('d/m/Y', strtotime($row_eventos['data_final']));} ?> às <?php echo date('H:i',strtotime($row_eventos['hora_inicio']));?><br>
								<strong>Local: </strong> <?php echo $row_eventos['local_nome']; ?>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding: 15px;">
								<input type="text" class="form-control" id="saudacao" name="saudacao" placeholder="Saudação - Ex.: Olá,">
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding: 15px;">
								<textarea class="form-control" id="mensagem" name="mensagem" placeholder="Escreva sua mensagem personalizada..." style="min-height: 130px;"></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding: 15px;">
								<input type="text" class="form-control" id="despedida" name="despedida" placeholder="Despedida - Ex.: Atenciosamente,">
							</td>
						</tr>
						<tr style="border-bottom: 1px solid #d4d4d4;">
							<td colspan="2" style="padding: 0 20px 20px 20px;">
								
								<strong><?php echo $row_eventos['organizador_nome'];?></strong><br>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<a href="" style="width: 150px; height: 40px; background: #0097ff; margin:20px auto; border-radius: 10px; display:block; text-align:center; padding: 0 10px 10px 10px; line-height: 40px;text-decoration:none; color: #fff; font-weight: bold;">VER EVENTO</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		
		<div class="row" style="margin: 20px 20px;">
			<div class="col">
				<label for="emailteste">Enviar e-mail de teste:</label>
			</div>
			<div class="col col-7">
				<div class="form-group">
					
					<input type="text" class="form-control" id="emailteste" name="emailteste" placeholder="Digite um e-mail de teste">
				  </div>
			</div>
			<div class="col">
				<button class="btn btn-primary" type="submit" onclick="return enviarteste()">ENVIAR</button>
			</div>
		</div>
		
	</div>  
	
	
	<div class="container content" style="min-height: 300px;">
		
		<div class="row" style="margin: 20px 20px 0 20px;">
			
			<div class="col">
			<h3><i class="fas fa-user-plus"></i> Adicionar convidados - Manual</h3>
			<p>Cole ou digite os e-mails dos participantes separados por virgula (,) ou um abaixo do outro. Limite diário de 2000 convites.</p>
			<textarea class="form-control" id="participante" name="participantes" placeholder="Digite os participantes separados por (,) ou um abaixo do outro" style="min-height: 130px;"></textarea>
			<input type="hidden" name="participa" id="participa"/>
			
			</div>
		</div>
		<div class="row" style="margin: 20px 20px 0 20px;">
			<div class="col">
		<h3 style="margin-top: 20px;"><i class="fas fa-user-plus"></i> Adicionar convidados - Lista Inscritos</h3>
		<p>Escolha uma lista existente de eventos passados e em andamento.</p>
		<div class="form-group">
  
    <select class="form-control" id="listaconvidados" name="listaconvidados">
	<option selected></option>
	<?php do{?>
		
      <option value="<?php echo $row_lista['ref']; ?>"><?php echo $row_lista['evento']; ?></option>
      <?php } while ($row_lista = mysqli_fetch_assoc($lista));?>
	  
	 
    </select>
  </div>
		
			</div>
		</div>
		
		
		
		<div class="row" style="margin: 20px 20px 0 20px;">
			<div class="col">
		<h3 style="margin-top: 20px;"><i class="fas fa-user-plus"></i> Adicionar convidados - Lista Cadastrada</h3>
		<p>Escolha uma lista existente criada na página Lista de E-mails.</p>
		<div class="form-group">
  
    <select class="form-control" id="listacadastradas" name="listacadastradas">
	<option selected></option>
	  
	  <?php do{?>
		
      <option value="<?php echo $row_emails['id_lista']; ?>"><?php echo $row_emails['nome_lista']; ?></option>
      <?php } while ($row_emails = mysqli_fetch_assoc($emails));?>
    </select>
  </div>
		
			</div>
		</div>
		
		
		<div class="row" style="margin: 20px 20px 0 20px;">
			<div class="col" >
				<button class="btn btn-primary" type="submit" onclick="return disparar()"><i class="fas fa-paper-plane" style="margin-right: 10px;"></i> Disparar e-mails</button>
			</div>
		</div>
		
	</div>
	</form>
	   <?php include_once("footer.php");?>
   </body>
</html>

<script type="text/javascript">
		// Este evendo é acionado após o carregamento da página
		jQuery(window).load(function() {
			//Após a leitura da pagina o evento fadeOut do loader é acionado, esta com delay para ser perceptivo em ambiente fora do servidor.
			jQuery("#loader").delay(2000).fadeOut("slow");
		});
	</script>

<script>
function disparar(){
	var participante = document.getElementById("participante").value;
	var resultado = participante.split("\n");
	var participa = document.getElementById("participa");
	participa.value = resultado;
	
	document.disparo.action="disparar-emails.php";
	document.forms.disparo.submit();
}
function enviarteste(){
	document.disparo.action="enviar-email-teste.php";
	document.forms.disparo.submit();
}
</script>
