<?php 
require_once('config/conn.php');

$ref = $_GET['ref'];

$sql = "SELECT * FROM evn_eventos WHERE ref='$ref'";
$eventos = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);
$totalRows_eventos = mysqli_num_rows($eventos);

$sql = "SELECT * FROM evn_ingressos WHERE ref_evento='$ref'";
$ingressos = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_ingressos = mysqli_fetch_assoc($ingressos);
$totalRows_ingressos = mysqli_num_rows($ingressos);



?>

<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Cadastro de Eventos - Afetur Eventos</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="bootstrap/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="pagseguro/style.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	
	
		
</head>
<body style="background: #afb2c1;">

<div class="container-fluid" style="background:#392450;">
	<div class="container">
		<div class="row">
			<div class="col"></div>
			<div class="col"><a href="http://www.afetur.com.br" target="_blank"><img src="assets/logo-afetur.png" width="200" style="margin: 10px;"></a></div>
			<div class="col"></div>
		</div>
	</div>
</div>

   
   <form id="comprar" name="comprar"  method="post" action="teste-pagseguro/source/examples/checkout/createPaymentRequest.php">
		<input type="hidden" name="code" id="code" value="" />
	
		<div class="container" style="background: #fff; padding: 20px; margin-top: 20px; border-radius: 15px;">
		
		<div class="row">
		<div class="col">
		<img src="<?php echo $row_eventos['modelo_evento']; ?>" class="img-fluid" height="400" style="width:100%" align="center"/>
		<h3 style="margin: 15px 0;"><?php echo $row_eventos['nome_evento']; ?></h3>
		<input type="hidden" name="evento" id="evento" value="<?php echo $row_eventos['nome_evento']; ?>">
		<table class="table table-bordered"  >
		<tr>
		<td>
		<p><?php echo $row_eventos['descricao_evento']; ?></p>
		</td>
		</tr>
		</table>
		<p><i class="fas fa-calendar-alt" style="margin-right: 10px;"></i> <?php if($row_eventos['data_inicio'] == $row_eventos['data_final']){ echo date('d/m/Y', strtotime($row_eventos['data_inicio']));}else{echo date('d/m/Y', strtotime($row_eventos['data_inicio']))." at&eacute; ".date('d/m/Y', strtotime($row_eventos['data_final']));} ?> &agrave;s <?php if($row_eventos['hora_inicio'] == $row_eventos['hora_final']){ echo date('H:i', strtotime($row_eventos['hora_inicio']));}else{echo date('H:i', strtotime($row_eventos['hora_inicio']))." at&eacute; ".date('H:i', strtotime($row_eventos['hora_final']));} ?></p>
		<p><i class="fas fa-map-marker-alt" style="margin-right: 10px;"></i> <?php echo $row_eventos['local_nome']; ?> - <?php echo $row_eventos['local_logradouro']; ?>, <?php echo $row_eventos['local_numero']; ?>, <?php echo $row_eventos['local_complemento']; ?>, <?php echo $row_eventos['local_bairro']; ?>, <?php echo $row_eventos['local_cidade']; ?>, <?php echo $row_eventos['local_estado']; ?>, <?php echo $row_eventos['local_pais']; ?></p>
		<div class="table-responsive">
								
								<table class="table table-bordered">
								<?php do { ?>
									<tr >
										<td colspan="2">
											<label for="nomeingresso">Ingresso:</label>
											<input type="text" id="ingresso" name="ingresso[]" placeholder="Ex.: Ingresso ConferÃªncia" class="form-control name_list ing" value="<?php echo $row_ingressos['ingresso'];?>" readonly required />
										</td>
										<td>
											<label for="valoringresso">Valor:</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<input type="text" class="form-control" id="moeda" value="<?php echo $row_eventos['moeda']; ?>" style="width: 60px;" readonly />
												</div>
												<input type="text" class="form-control ing" id="valor" name="valor[]" placeholder="Ex.: 1.150,00" value="<?php echo $row_ingressos['valor'];?>" readonly required>
											</div>
										</td>
										<td >
											<label for="nomeingresso">Quantidade:</label>
											<input type="number" id="quantidade" name="quantidade[]" class="form-control name_list ing" onchange="calculaPg();exibePagamento()"  value="0" min="0" required />
										</td>
										<input name="idingresso[]" type="hidden" id="idingresso" value="<?php echo $row_ingressos['id_ingresso']; ?>">
										<input name="unidadeingresso[]" type="hidden" id="unidadeingresso" value="<?php echo $row_ingressos['unidade']; ?>">
										
									</tr>
									<!--<tr>
										<td colspan="2">
											<label for="nome">Nome completo:</label>
											<input type="text" id="nome" name="nome[]" placeholder="Nome do participante principal" onkeyup="javascript: doSomething(this)" class="form-control name_list" required />
										</td>
										<td colspan="2">
											<label for="email">E-mail:</label>
											<input type="email" id="email" name="email[]" placeholder="E-mail do participante principal" onkeyup="javascript: doSomething(this)" class="form-control name_list" required />
										</td>
									</tr>-->
								<?php } while ($row_ingressos = mysqli_fetch_assoc($ingressos));?>
								</table>
								
								
		</div>			
		</div>				
		</div>
		
		<div class="row">
			<div class="col">
			<h3 style="margin: 15px 0;">Dados de inscri&ccedil;&atilde;o</h3>
			<p>Preencha os nomes de cada participante de acordo com a quantidade de ingressos que ir&aacute; comprar. <br><strong>Obs.: O primeiro nome ser&aacute; o respons&aacute;vel pela cobran&ccedil;a.</strong></p>
				<div class="table-responsive">
				<div class="row" style="text-align:center; margin: 20px 0;">
						<div class="col">
							<button type="button" name="add" id="add" class="btn btn-success">Adicionar mais inscritos</button>
						</div>
					</div>
					<table class="table table-bordered" id="dynamic_field">
						<tr>
							<td colspan="2">
								<label for="nome">Nome completo:</label>
								<input type="text" id="nome" name="nome[]" placeholder="Nome do participante principal" onkeyup="javascript: doSomething(this)" class="form-control name_list" required />
							
							</td>
							<td>
								<label for="email">E-mail:</label>
								<input type="email" id="email" name="email[]" placeholder="E-mail do participante principal" onkeyup="javascript: doSomething(this)" class="form-control name_list" required />
							</td>
														<td>
								<label for="campoadicional"><?php echo $row_eventos['campo_adicional']; ?>:</label>
								<input type="text" id="campoadicional" name="campoadicional[]" onkeyup="javascript: doSomething(this)" class="form-control name_list" required />
							</td>
							<input type="hidden" id="cpadicional" name="cpadicional[]" value="<?php echo $row_eventos["campo_adicional"]; ?>">
						</tr>
						
						
					</table>
					
					
					
				</div>
			</div>
		
		</div>
		<div class="row">
			<div class="col">
									<h3 style="margin: 15px 0;">Forma de Pagamento</h3>
			<p>Selecione como deseja efetuar o pagamento dos ingressos para o evento selecionado.</p>

			</div>
		</div>
	<div class="row">

	<div class="col">
	</div>
	<div class="col">
	
	</div>
	<div class="col-5">
	

	<button style='display: none;float:left; margin-right: 15px;'  type='submit' id='inscreverboleto' onclick='return blu();' class='btn btn-primary btn-lg'>BOLETO</button> <button style='display:none;float:left; margin-right: 20px;'  type='submit' id='inscrevercartao' onclick='return bla();' class='btn btn-primary btn-lg'><i class='fas fa-credit-card' style='margin-right:5px;'></i> CART&Atilde;O DE CR&Eacute;DITO</button>
	<button style='display: none;float:left; margin-right: 20px;'  type='submit' id='inscrevergratis' onclick='return gratis();' class='btn btn-primary btn-lg'>Finalizar Inscri&ccedil;&atilde;o</button>
	<button style='display: none;float:left; margin-right: 20px;'  type='submit' id='inscreverpaypal' onclick='return paypal();' class='btn btn-primary btn-lg'><i class='fab fa-paypal' style='margin-right:5px;'></i> Pagar com Paypal</button>

	</div>
	
	</div>
	
		
		<input name="totalboleto" type="hidden" id="totalboleto">
		
		<input name="resultado" type="hidden" id="resultado">
		<input name="numum" type="hidden" id="numum">
		<input name="numdois" type="hidden" id="numdois">
		<input name="moeda" type="hidden" id="moeda" value="<?php echo $row_eventos['moeda']; ?>">
		<input name="ref" type="hidden" id="ref" value="<?php echo $row_eventos['ref']; ?>">
		
		
   </form>
   
<script>

function calculaPg(){	
var valor = document.getElementsByName("valor[]");
var quantid = document.getElementsByName("quantidade[]");
var nome = document.getElementsByName("nome[]");
var ingresso = document.getElementsByName("ingresso[]");
var testeu = [];
var valoru = [];


var somau = 0;
var calcula = 0;
 
 

for (var i=0; i<quantid.length; i++){
	
		testeu[i] = parseInt(quantid[i].value);
		
		valoru[i] = parseInt(valor[i].value) * parseInt(testeu[i]); 
		
		calcula += parseInt(valoru[i]);
		
		somau += parseInt(testeu[i]);
		
 document.getElementById("resultado").value = calcula;
}



var str = document.getElementById("resultado").value;

document.getElementById("totalboleto").value = str.replace(/[^\d]+/g,'');

}

function exibePagamento(){	
var result = document.getElementById("resultado").value;
var moeda = document.getElementById("moeda").value;
if(moeda == "R$" && result == 0){document.getElementById("inscrevergratis").style.display = "block";document.getElementById("inscreverboleto").style.display = "none"; document.getElementById("inscrevercartao").style.display = "none";}
else if(moeda == "R$" && result > 0){document.getElementById("inscreverboleto").style.display = "block"; document.getElementById("inscrevercartao").style.display = "block";document.getElementById("inscrevergratis").style.display = "none";}
else if(moeda == "R$" && result == 0){document.getElementById("inscreverboleto").style.display = "none"; document.getElementById("inscrevercartao").style.display = "none";document.getElementById("inscrevergratis").style.display = "display";}
else if(moeda != "R$" && result == 0){document.getElementById("inscreverboleto").style.display = "none"; document.getElementById("inscrevercartao").style.display = "none";document.getElementById("inscrevergratis").style.display = "none"; document.getElementById("inscreverpaypal").style.display = "none";}
else{document.getElementById("inscreverpaypal").style.display = "block"; document.getElementById("inscrevergratis").style.display = "none";document.getElementById("inscreverboleto").style.display = "none"; document.getElementById("inscrevercartao").style.display = "none";}
}

</script>
   

<script>

function bla(){
var valor = document.getElementsByName("valor[]");
var unid = document.getElementsByName("unidadeingresso[]");
var quantid = document.getElementsByName("quantidade[]");
var nome = document.getElementsByName("nome[]");
var ingresso = document.getElementsByName("ingresso[]");
var testeu = [];
var valoru = [];

var somau = 0;

for (var i=0; i<unid.length; i++){
		valoru[i] = parseInt(quantid[i].value) * parseInt(unid[i].value); 
		
		
		somau += parseInt(valoru[i]);
		
 }

contar = 0; 
 for(y = 0; y < nome.length; y++) 
		{ 
		contar++; 
		} 

if(contar != somau){
	alert('A quantidade de nomes \u00e9 diferente da quantidade de ingressos!');
	return false;
}else{
	

document.comprar.action="teste-pagseguro/source/examples/checkout/createPaymentRequest.php";
document.forms.comprar.submit();
}

}



function paypal(){
var valor = document.getElementsByName("valor[]");
var unid = document.getElementsByName("unidadeingresso[]");
var quantid = document.getElementsByName("quantidade[]");
var nome = document.getElementsByName("nome[]");
var ingresso = document.getElementsByName("ingresso[]");
var testeu = [];
var valoru = [];

var somau = 0;

for (var i=0; i<unid.length; i++){
		valoru[i] = parseInt(quantid[i].value) * parseInt(unid[i].value); 
		
		
		somau += parseInt(valoru[i]);
		
 }

contar = 0; 
 for(y = 0; y < nome.length; y++) 
		{ 
		contar++; 
		} 

if(contar != somau){
	alert('A quantidade de nomes \u00e9 diferente da quantidade de ingressos!');
	return false;
}else{
document.comprar.action="paypal.php";
document.forms.comprar.submit();
}
}



function blu(){
var valor = document.getElementsByName("valor[]");
var unid = document.getElementsByName("unidadeingresso[]");
var quantid = document.getElementsByName("quantidade[]");
var nome = document.getElementsByName("nome[]");
var ingresso = document.getElementsByName("ingresso[]");
var testeu = [];
var valoru = [];

var somau = 0;

for (var i=0; i<unid.length; i++){
		valoru[i] = parseInt(quantid[i].value) * parseInt(unid[i].value); 
		
		
		somau += parseInt(valoru[i]);
		
 }

contar = 0; 
 for(y = 0; y < nome.length; y++) 
		{ 
		contar++; 
		} 

if(contar != somau){
	alert('A quantidade de nomes \u00e9 diferente da quantidade de ingressos!');
	return false;
}else{
document.comprar.action="boleto.php";
document.forms.comprar.submit();
}
}


function gratis(){
var valor = document.getElementsByName("valor[]");
var unid = document.getElementsByName("unidadeingresso[]");
var quantid = document.getElementsByName("quantidade[]");
var nome = document.getElementsByName("nome[]");
var ingresso = document.getElementsByName("ingresso[]");
var testeu = [];
var valoru = [];

var somau = 0;

for (var i=0; i<unid.length; i++){
		valoru[i] = parseInt(quantid[i].value) * parseInt(unid[i].value); 
		
		
		somau += parseInt(valoru[i]);
		
 }

contar = 0; 
 for(y = 0; y < nome.length; y++) 
		{ 
		contar++; 
		} 

if(contar != somau){
	alert('A quantidade de nomes \u00e9 diferente da quantidade de ingressos!');
	return false;
}else{
document.comprar.action="inscricao-gratis.php";
document.forms.comprar.submit();
}
}



$(document).ready(function(){
	var i=1;
	$('#add').click(function(){
		i++;
		var cpadicional = document.getElementById("cpadicional").value;
		$('#dynamic_field').append('<tr id="row'+i+'"><td colspan="2"><label for="nome">Nome completo:</label><input type="text" id="nome" name="nome[]" placeholder="Nome do participante adicional" onkeyup="javascript: doSomething(this)" class="form-control name_list" required /></td><td><label for="email">E-mail:</label><input type="email" id="email" name="email[]" placeholder="E-mail do participante adicional" onkeyup="javascript: doSomething(this)" class="form-control name_list" required /></td><td><label for="campoadicional">'+cpadicional+':</label><input type="text" id="campoadicional" name="campoadicional[]" onkeyup="javascript: doSomething(this)" class="form-control name_list" required /></td><td style="text-align:center"><br><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button> REMOVER</td></tr>');
	

	});

	
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
	
	
	
});
</script>

</body>
</html>