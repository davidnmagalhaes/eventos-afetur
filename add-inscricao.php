<?php
include("valida_pagina.php");

$ref = $_GET['ref'];

$sql = "SELECT * FROM evn_eventos WHERE ref='$ref'";
$eventos = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);
$totalRows_eventos = mysqli_num_rows($eventos);

$tabelabd = $row_eventos['tabela_bd'];
$colunabd = $row_eventos['coluna_bd'];
$valuebd = $row_eventos['value_bd'];

$sql = "SELECT * FROM evn_ingressos WHERE ref_evento='$ref'";
$ingressos = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_ingressos = mysqli_fetch_assoc($ingressos);
$totalRows_ingressos = mysqli_num_rows($ingressos);

$codigo = "SELECT * FROM evn_pedidos order by id DESC";
$codigo = $link->query($codigo);
$row = $codigo->fetch_assoc();
$cod = $row['id'];

//Segunda Conexão - Integração
$local2 = $row_eventos['host_bd'];
$usuario2 = $row_eventos['usuario_bd'];
$senha2 = $row_eventos['password_bd'];
$banco2 = $row_eventos['banco_bd'];
$link2 = mysqli_connect($local2, $usuario2, $senha2, $banco2);
 
if (!$link2) {
    echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
//Segunda Conexão - Integração

if($tabelabd == "" || $colunabd == ""){

}else{
	$qr = "SELECT * FROM ".$tabelabd." ORDER BY ".$colunabd." ASC";
$adicional = mysqli_query($link2, $qr) or die(mysqli_error($link));
$row_adicional = mysqli_fetch_assoc($adicional);
$totalRows_adicional = mysqli_num_rows($adicional);

$q = "SELECT * FROM ".$tabelabd." ORDER BY ".$colunabd." ASC";
$add = mysqli_query($link2, $q) or die(mysqli_error($link));
$row_add = mysqli_fetch_assoc($add);
$totalRows_add = mysqli_num_rows($add);
}

?>

<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Adicionar Inscrição Manual - Afetur Eventos</title>
	    <?php include('head.php');?>
			
		
  </head>
   <body>
       
	   <?php
		require_once('nav-main.php');
	   ?>

	 <form id="comprar" name="comprar"  method="post" >
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
		<p><i class="fas fa-calendar-alt" style="margin-right: 10px;"></i> <?php if($row_eventos['data_inicio'] == $row_eventos['data_final']){ echo date('d/m/Y', strtotime($row_eventos['data_inicio']));}else{echo date('d/m/Y', strtotime($row_eventos['data_inicio']))." at&eacute; ".date('d/m/Y', strtotime($row_eventos['data_final']));} ?></p>
		<p><i class="fas fa-map-marker-alt" style="margin-right: 10px;"></i> <?php echo $row_eventos['local_nome']; ?> - <?php echo $row_eventos['local_logradouro']; ?>, <?php echo $row_eventos['local_numero']; ?>, <?php echo $row_eventos['local_complemento']; ?>, <?php echo $row_eventos['local_bairro']; ?>, <?php echo $row_eventos['local_cidade']; ?>, <?php echo $row_eventos['local_estado']; ?></p>
		<div class="table-responsive">
								
								<table class="table table-bordered">
								<?php do { ?>
									<tr >
										<td colspan="2">
											<label for="nomeingresso">Ingresso:</label>
											<input type="text" id="ingresso" name="ingresso[]" placeholder="Ex.: Ingresso ConferÃªncia" class="form-control name_list ing" value="<?php echo $row_ingressos['ingresso'];?>" readonly required />
										</td>
										<td>
											<label for="valoringresso">Valor unitário:</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="inputGroupPrepend2"><input style="width: 20px;background: transparent; border:0;"  id="simbolo" name="simbolo[]" class="simbolo" value="<?php echo $row_eventos['moeda']; ?>" readonly></span>
												</div>
												<input type="text" class="form-control ing" id="valor" name="valor[]" placeholder="Ex.: 1.150,00" value="<?php echo $row_ingressos['valor'];?>" required>
											</div>
										</td>
										<td >
											<label for="nomeingresso">Quantidade:</label>
											<input type="number" id="quantidade" name="quantidade[]" class="form-control name_list ing" onchange="calculaPg();" onblur="adiciona()" value="0" min="0" required />
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
			<p>Preencha os nomes de cada participante de acordo com a quantidade de ingressos pagos.</p>
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
														<?php if($row_eventos['tabela_bd'] == ""){?>
							<td>
								<label for="campoadicional"><?php echo $row_eventos['campo_adicional']; ?>:</label>
								<input type="text" id="campoadicional" name="campoadicional[]" onkeyup="javascript: doSomething(this)" class="form-control name_list" required />
							</td>
							
							<?php }else{?>
							<td>
								<label for="campoadicional"><?php echo $row_eventos['campo_adicional']; ?>:</label>
								<select id="campoadicional" name="campoadicional[]" class="form-control">
									<?php do{ ?>
									<option value="<?php echo $row_adicional[$valuebd];?>"><?php echo $row_adicional[$colunabd];?></option>
									<?php } while ($row_adicional = mysqli_fetch_assoc($adicional));?>
								</select>
							</td>
							<?php }?>
							<input type="hidden" id="cpadicional" name="cpadicional[]" value="<?php echo $row_eventos["campo_adicional"]; ?>">
						
							
						</tr>
						
						
					</table>
					
					
					
				</div>
			</div>
		
		</div>
		<div class="row">
			<div class="col">
									<h3 style="margin: 15px 0;">Forma de Pagamento</h3>
			<p>Selecione a forma de pagamento escolhida pelo participante.</p>
			<table class="table table-bordered" >
				<tr>
					<td colspan="2">
						<select class="form-control" name="tipopagamento">
						  <option value="Dinheiro">Dinheiro</option>
						  <option value="Boleto Manual">Boleto Manual</option>
						  <option value="Cartão de Crédito">Cartão de Crédito</option>
						  <option value="Cartão de Débito">Cartão de Débito</option>
						  <option value="Transferência">Transferência</option>
						  <option value="Cheque">Cheque</option>
						  <option value="Paypal">Paypal</option>
						  <option value="1x Cartão + Boletos">1x Cartão + Boletos</option>
						  <option value="1x Cartão + Dinheiro">1x Cartão + Dinheiro</option>
						</select>	
					</td>
				</tr>
			</table>


			</div>
		</div>
	<div class="row">

	<div class="col">
	</div>
	<div class="col">

		<button type="submit" id="inscrever" onclick="return blu()" class="btn btn-primary btn-lg" >GERAR BOLETO</button>

	</div>
	<div class="col">
	<button type="submit" id="inscrever" onclick="return bla()" class="btn btn-primary btn-lg" >INSERIR MANUAL</button>
	</div>
	</div>
	
		
		<input name="totalboleto" type="hidden" id="totalboleto">
		<input name="adicional" type="hidden" id="adicional" value="<?php echo $row_eventos['tabela_bd']; ?>">
		<?php if($tabelabd == "" || $colunabd == ""){?>
			<input name="opcoesadicional" type="hidden" id="opcoesadicional" value="<?php echo "<input type='text' id='campoadicional' name='campoadicional[]' class='form-control name_list' required />";?>">
		<?php }else{?>
			<input name="opcoesadicional" type="hidden" id="opcoesadicional" value="<?php echo "<select class='form-control' id='campoadicional' name='campoadicional[]'>"; do{echo "<option value='".$row_add[$valuebd]."'>".$row_add[$colunabd]."</option>";} while ($row_add = mysqli_fetch_assoc($add)); echo '</select>';?>">
		<?php } ?>
		<input name="cod" type="hidden" id="cod" value="<?php echo $cod+1; ?>">
		<input name="resultado" type="hidden" id="resultado">
		<input name="qt" type="hidden" id="qt">
		<input name="numum" type="hidden" id="numum">
		<input name="numdois" type="hidden" id="numdois">
		<input name="moeda" type="hidden" id="moeda" value="<?php echo $row_eventos['moeda']; ?>">
		<input name="ref" type="hidden" id="ref" value="<?php echo $row_eventos['ref']; ?>">
		<input name="nme" type="hidden" id="nme" value="<?php echo $_SESSION['nome'];?>">
		
		
   </form>
   


<script>


function calculaPg(){	
var valor = document.getElementsByName("valor[]");
var quantid = document.getElementsByName("quantidade[]");
var qt = document.getElementsByName("qt");
var nome = document.getElementsByName("nome[]");
var ingresso = document.getElementsByName("ingresso[]");
var testeu = [];
var valoru = [];


var somau = 0;
var calcula = 0;
 
 

for (var i=0; i<quantid.length; i++){
	
		testeu[i] = parseInt(quantid[i].value);
		
		valoru[i] = parseFloat(valor[i].value) * parseInt(testeu[i]); 
		
		calcula += parseFloat(valoru[i]);
		
		somau += parseInt(testeu[i]);
		
 document.getElementById("resultado").value = calcula.toFixed(2);
 document.getElementById("qt").value = somau;
}



var str = document.getElementById("resultado").value;

document.getElementById("totalboleto").value = str.replace(/[^\d]+/g,'');

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
	

document.comprar.action="proc-insc-manual.php";
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
document.comprar.action="boleto-manual.php";
document.forms.comprar.submit();
}
}



$(document).ready(function(){
	var i=1;
	$('#add').click(function(){
		i++;
		var cpadicional = document.getElementById("cpadicional").value;
		var adicional = document.getElementById("adicional").value;
		var opcoesadicional = document.getElementById("opcoesadicional").value;
		$('#dynamic_field').append('<tr id="row'+i+'"><td colspan="2"><label for="nome">Nome completo:</label><input type="text" id="nome" name="nome[]" placeholder="Nome do participante adicional" onkeyup="javascript: doSomething(this)" class="form-control name_list" required /></td><td><label for="email">E-mail:</label><input type="email" id="email" name="email[]" placeholder="E-mail do participante adicional" onkeyup="javascript: doSomething(this)" class="form-control name_list" required /></td><td><label for="campoadicional">'+cpadicional+':</label>'+opcoesadicional+'</td><td style="text-align:center"><br><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button> REMOVER</td></tr>');
	

	});

	
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
	
	
	
});
</script>

</body>
</html>

