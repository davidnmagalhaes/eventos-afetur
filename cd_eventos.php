<?php
include("valida_pagina.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Cadastro de Eventos - Afetur Eventos</title>
	    <?php include("head.php");?>
		<script src="editor.js"></script>
		<link href="editor.css" type="text/css" rel="stylesheet"/>
		
		<style>
		
		.file-upload {
  background-color: #ffffff;
  width: 600px;
  margin: 0 auto;
  padding: 20px;
}

.file-upload-btn {
  width: 100%;
  margin: 0;
  color: #fff;
  background: #1f7cb2;
  border: none;
  padding: 10px;
  border-radius: 4px;
  border-bottom: 4px solid #343a40;
  transition: all .2s ease;
  outline: none;
  text-transform: uppercase;
  font-weight: 700;
}

.file-upload-btn:hover {
  background: #1AA059;
  color: #ffffff;
  transition: all .2s ease;
  cursor: pointer;
}

.file-upload-btn:active {
  border: 0;
  transition: all .2s ease;
}

.file-upload-content {
  display: none;
  text-align: center;
}

.file-upload-input {
  position: absolute;
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  outline: none;
  opacity: 0;
  cursor: pointer;
}

.image-upload-wrap {
  margin-top: 20px;
  border: 4px dashed #1f7cb2;
  position: relative;
}

.image-dropping,
.image-upload-wrap:hover {
  background-color: #bbe6ff;
  border: 4px dashed #ffffff;
}

.image-title-wrap {
  padding: 0 15px 15px 15px;
  color: #222;
}

.drag-text {
  text-align: center;
}

.drag-text h3 {
  font-weight: 100;
  text-transform: uppercase;
  color: #000;
  padding: 60px 0;
}


.file-upload-image {
  max-height: 200px;
  max-width: 200px;
  margin: auto;
  padding: 20px;
}

.remove-image {
  width: 200px;
  margin: 0;
  color: #fff;
  background: #cd4535;
  border: none;
  padding: 10px;
  border-radius: 4px;
  border-bottom: 4px solid #b02818;
  transition: all .2s ease;
  outline: none;
  text-transform: uppercase;
  font-weight: 700;
}

.remove-image:hover {
  background: #c13b2a;
  color: #ffffff;
  transition: all .2s ease;
  cursor: pointer;
}

.remove-image:active {
  border: 0;
  transition: all .2s ease;
}
.mg-top{margin-top: 20px;}
#exibiring{display:none;}
		</style>
		
		<script>
			function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function(e) {
      $('.image-upload-wrap').hide();

      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();

      $('.image-title').html(input.files[0].name);
    };

    reader.readAsDataURL(input.files[0]);

  } else {
    removeUpload();
  }
}

function removeUpload() {
  $('.file-upload-input').replaceWith($('.file-upload-input').clone());
  $('.file-upload-content').hide();
  $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
});



		</script>

  </head>
   <body>
       <?php
		require_once('nav-main.php');
	   ?>

	<div class="container content">
	<h2 style="color: #1f7cb2;border-bottom: 1px solid #333; padding: 7px"><strong><i class="fas fa-calendar-check" style="margin-right: 5px; color: #1f7cb2"></i> CRIE UM EVENTO</strong></h2>
			<form name="cdeventos" id="cdeventos" method="post" enctype="multipart/form-data" action="proc_cd_eventos.php">
				 <input name="nme" type="hidden" id="nme" value="<?php echo $_SESSION['nome'];?>">
				<div class="form-group">
				<h3 class="mg-top">1. Qual é o nome do evento?</h3>
				<div class="row">
				<div class="col">
					<label for="nomedoevento">Nome do Evento:</label>
					<input type="text" class="form-control" id="nome" name="nome" placeholder="Exemplo: 10ª Conferência">
				
					
					
				
				
				
				
				
				<script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<div class="file-upload">
  <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Adicionar capa ao evento</button>

  <div class="image-upload-wrap">
    <input class="file-upload-input" id="modelo" name="modelo" type='file' onchange="readURL(this);" accept="image/*" />
    <div class="drag-text">
      <h3>Arraste ou selecione uma imagem</h3>
	  <p><strong>Tamanho recomendado:</strong> 1080 x 400 pixels - JPG, PNG ou GIF</p>
    </div>
  </div>
  <div class="file-upload-content">
    <img class="file-upload-image" src="#" alt="your image" />
    <div class="image-title-wrap">
      <button type="button" onclick="removeUpload()" class="remove-image">Remover <span class="image-title">Enviar imagem</span></button>
    </div>
  </div>
</div>
				
				
				
				
				
				
				</div>
				</div>
				<h3 class="mg-top">2. Quando o evento vai acontecer?</h3>
				<div class="row">
					<div class="col">
					<label for="datainicial">Data de Início:</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroupPrepend2"><i class="far fa-calendar-alt"></i></span>
						</div>
						<input type="date" class="form-control" id="datainicial" name="datainicial">
					</div>
					</div>
					
					<div class="col">
					<label for="datainicial">Data de Término:</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroupPrepend2"><i class="far fa-calendar-alt"></i></span>
						</div>
						<input type="date" class="form-control" id="datafinal" name="datafinal">
					</div>
					</div>
					
					<div class="col">
					<label for="datainicial">Hora de Início:</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroupPrepend2"><i class="far fa-clock"></i></span>
						</div>
						<input type="time" class="form-control" id="horainicial" name="horainicial">
					</div>
					</div>
					
					<div class="col">
					<label for="datainicial">Hora de Término:</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroupPrepend2"><i class="far fa-clock"></i></span>
						</div>
						<input type="time" class="form-control" id="horafinal" name="horafinal">
					</div>
					</div>
					
					<div class="col">
					<label for="datainicial">Dias para Certificado:</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroupPrepend2"><i class="fas fa-calendar-day"></i></span>
						</div>
						<input type="number" class="form-control" id="diascheckin" name="diascheckin" >
					</div>
					</div>
					
				</div>
					<h3 class="mg-top">3. Ingressos</h3>
					
					<div class="row">
					<div class="col">
						<label for="nomedolocal">Moeda:</label>
						<select type="text" class="form-control" id="moeda" name="moeda" onchange="campoSelect(this.value)﻿" required>
							<option value="" selected>Selecione um tipo de moeda...</option>
						
							<option value="R$" >Real brasileiro</option>
							<option value="&euro;">Euro</option>
							<option value="US$">Dolár Americano</option>
							<option value="C$">Dolár Canadense</option>
							<option value="AU$">Dolár Australiano</option>
							<option value="&yen;">Moeda Japonesa (Yen)</option>
							<option value="NT$">Nova Tailandia</option>
							<option value="&pound;">Libra Esterlina</option>
							<option value="&#x20bd;">Rublo Russo</option>
						</select>
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<label for="nomedolocal">Quantidade de vezes que o boleto pode ser parcelado:</label>
						<select type="text" class="form-control" id="qtdboleto" name="qtdboleto"  required>
							
							<option value="1" >1 parcela</option>
							<option value="2" >2 parcelas</option>
							<option value="3" >3 parcelas</option>
							<option value="4" >4 parcelas</option>
							<option value="5" >5 parcelas</option>
							<option value="6" >6 parcelas</option>
							<option value="7" >7 parcelas</option>
							<option value="8" >8 parcelas</option>
							<option value="9" >9 parcelas</option>
							<option value="10" >10 parcelas</option>
							
						</select>
					</div>
					<div class="col">
						<label for="modalidade">Modalidade p/ boleto:</label>
						<input type="number" min="1" max="400" class="form-control" id="days_due_date" name="days_due_date"/>
					</div>
					</div>
					
					<div class="row" id="exibiring" style="display:none;">
					<div class="col">
					<div class="row" style="text-align:center; margin: 20px 0;">
						<div class="col">
							<button type="button" name="add" id="add" class="btn btn-success">Adicionar ingresso</button>
						</div>
					</div>
						<div class="form-group">
							<div name="add_name" id="add_name">
							<div class="table-responsive">
								
								<table class="table table-bordered" id="dynamic_field" >
									<tr >
										<td colspan="2">
											<label for="nomeingresso">Ingresso:</label>
											<input type="text" name="ingresso[]" placeholder="Ex.: Ingresso Conferência" class="form-control name_list" required/>
										</td>
										<td>
											<label for="valoringresso">Valor:</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="inputGroupPrepend2"><input style="width: 45px;background: transparent; border:0;"  id="simbolo" name="simbolo[]" class="simbolo" readonly></span>
												</div>
												<input type="text" class="form-control" id="valor" name="valor[]" placeholder="Ex.: 1.150,00" required>
											</div>
										</td>
										<td>
											<label for="valoringresso">Unidade:</label>
											<div class="input-group">
												
												<input type="number" class="form-control" id="unidade" name="unidade[]" required>
											</div>
										</td>
										
									</tr>
								</table>
								
							</div>
							</div>
						</div>
					</div>
					</div>
					
					<h3 class="mg-top">4. Onde o evento vai acontecer?</h3>
					<p>Ajude o público a chegar até o evento! Informe o endereço completo de onde ele irá acontecer.</p>
					
					
					
					<div class="row">
					<div class="col">
						<label for="nomedolocal">Nome do local:</label>
						<input type="text" class="form-control" id="nomelocal" name="nomelocal" placeholder="Exemplo: Afetur" required>
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<label for="cep">CEP:</label>
						<input type="text" class="form-control" id="cep" name="cep" placeholder="Exemplo: 60713-730" required>
					</div>
					</div>
					<div  id="endereco">
					<div class="row">
					<div class="col">
						<label for="rua">Av./Rua:</label>
						<input type="text" class="form-control" id="rua" name="rua" placeholder="Exemplo: Rua General Tertuliano" required>
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<label for="numero">Número:</label>
						<input type="text" class="form-control" id="numero" name="numero" placeholder="Exemplo: 137" required>
					</div>
					<div class="col">
						<label for="complemento">Complemento:</label>
						<input type="text" class="form-control" id="complemento" name="complemento" placeholder="Exemplo: Apto. 8, Bloco A">
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<label for="bairro">Bairro:</label>
						<input type="text" class="form-control" id="bairro" name="bairro" placeholder="Exemplo: Aldeota" >
					</div>
					<div class="col">
						<label for="cidade">Cidade:</label>
						<input type="text" class="form-control" id="cidade" name="cidade" placeholder="Exemplo: Fortaleza" required>
					</div>
					<div class="col">
						<label for="estado">Estado:</label>
						<input class="form-control" name="estado" id="estado">
	
					</div>
					<div class="col">
						<label for="estado">País:</label>
						<input class="form-control" name="pais" id="pais">
	
					</div>
					</div>
					</div>
					<h3 class="mg-top">5. Descrição do evento</h3>
					<p>Conte todos os detalhes do seu evento, como a programação e os diferenciais da sua produção!</p>
					
					<div class="row">
					<div class="col">
						<div class="form-group">
							<textarea class="form-control" id="descricaoevento" name="descricaoevento" rows="3"></textarea>
						</div>
					</div>
					</div>
					
					<h3 class="mg-top">6. Sobre o Organizador</h3>
					<p>Conte um pouco sobre você ou a sua empresa. É importante mostrar ao público quem está por trás do evento, dando mais credibilidade à sua produção.</p>

					
					
					<div class="row">
					<div class="col">
						<label for="nomedolocal">Nome do Organizador:</label>
						<input type="text" class="form-control" id="nomeorganizador" name="nomeorganizador" placeholder="Exemplo: Afetur" required>
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<div class="form-group">
							<textarea class="form-control" id="descricaoorganizador" name="descricaoorganizador" rows="3"></textarea>
						</div>
					</div>
					</div>
					
					<h3 class="mg-top">7. Campo adicional</h3>
					<p>Adicione um campo extra no evento para preenchimento dos convidados.</p>
					<div class="row">
					<div class="col">
						<label for="campoadicional">Campo adicional:</label>
						<input type="text" class="form-control" id="campoadicional" name="campoadicional" placeholder="Exemplo: Clube" required>
					</div>
					</div>
					
					
					
					<h3 class="mg-top">8. Configuração de Pagamento</h3>
					<p>Importante! Estas informações serão necessárias para o funcionamento do sistema de pagamento do evento. (Obs.: Eventos gratuitos não são necessários)</p>
					<div id="exibirpag" style="display:none;">
					<div class="row">
					<div class="col">
						<label for="emailpagseguro">E-mail Pagseguro:</label>
						<input type="text" class="form-control" id="emailpagseguro" name="emailpagseguro" value="<?php echo $row_editaevento['emailpagseguro']; ?>">

					</div>
					</div>
					<div class="row">
					<div class="col">
						<label for="tokenpagseguro">Token Pagseguro:</label>
						<input type="text" class="form-control" id="tokenpagseguro" name="tokenpagseguro">

					</div>
					<div class="col">
						<label for="appidpagseguro">AppId Pagseguro:</label>
						<input type="text" class="form-control" id="appidpagseguro" name="appidpagseguro">

					</div>
					
					<div class="col">
						<label for="appkeypagseguro">AppKey Pagseguro:</label>
						<input type="text" class="form-control" id="appkeypagseguro" name="appkeypagseguro">

					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<label for="appkeypagseguro">AppKey PagHiper:</label>
						<input type="text" class="form-control" id="appkeypaghiper" name="appkeypaghiper">

					</div>
					<div class="col">
						<label for="appkeypagseguro">Token PagHiper:</label>
						<input type="text" class="form-control" id="tokenpaghiper" name="tokenpaghiper">

					</div>
					</div>
					
					</div>
					
					<div id="exibirpaypal" style="display:none;">
					<div class="row">
					<div class="col">
						<label for="clientidpaypal">Client ID Paypal:</label>
						<input type="text" class="form-control" id="clientidpaypal" name="clientidpaypal">

					</div>
					</div>
					</div>
					
					<button type="submit" id="cadastrar" class="btn btn-primary">PUBLICAR EVENTO</button>
				</div>	
			</form>
	</div>  
	   <?php include_once("footer.php");?>
   </body>
</html>
<script>

function campoSelect(val){
document.getElementById("simbolo").value = val;
var simb = document.getElementById("simbolo").value;
if(simb == "Grátis"){document.getElementById("valor").value = 0;}
else if(simb == "R$"){document.getElementById("exibirpag").style.display = "block";}
else{document.getElementById("exibirpaypal").style.display = "block";}
document.getElementById("exibiring").style.display = "block";
}
</script>
<!--Script para busca de endereços por CEP-->
	<script type="text/javascript">

		$("#cep").focusout(function(){
			$.ajax({
				url: 'https://viacep.com.br/ws/'+$(this).val()+'/json/unicode/',
				dataType: 'json',
				success: function(resposta){
					$("#rua").val(resposta.logradouro);
					$("#complemento").val(resposta.complemento);
					$("#bairro").val(resposta.bairro);
					$("#cidade").val(resposta.localidade);
					$("#estado").val(resposta.uf);
					$("#numero").focus();
					document.getElementById("endereco").style.display = "block";
				}
			});
		});
	</script>

<script>
$(document).ready(function(){
	var i=1;
	$('#add').click(function(){
		i++;
		var teste = document.getElementById("simbolo").value;
		if(teste == "Grátis"){var zero = parseFloat(0);}
		$('#dynamic_field').append('<tr id="row'+i+'"><td><label for="nomeingresso">Ingresso:</label><input type="text" name="ingresso[]" placeholder="Ex.: Ingresso Conferência" class="form-control name_list" /></td><td><label for="valoringresso">Valor:</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend2"><input style="width: 45px;background: transparent; border:0;"  id="simb'+i+'" name="simbolo[]" class="simb" value="'+teste+'" readonly></span></div><input type="text" class="form-control" id="valor" name="valor[]" placeholder="Ex.: 1.150,00" value="'+zero+'"></div></td><td style="text-align:center"><br><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button> REMOVER</td></tr>');
	

	});

	
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
	
	
	
});
</script>