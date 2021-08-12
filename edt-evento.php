<?php 
include("valida_pagina.php");

$ref = $_GET['ref'];

$sql = "SELECT * FROM evn_eventos WHERE ref = '$ref'";
$editaevento = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_editaevento = mysqli_fetch_assoc($editaevento);
$totalRows_editaevento = mysqli_num_rows($editaevento);

$query = "SELECT * FROM evn_ingressos WHERE ref_evento = '$ref'";
$editaingresso = mysqli_query($link, $query) or die(mysqli_error($link));
$row_editaingresso = mysqli_fetch_assoc($editaingresso);
$totalRows_editaingresso = mysqli_num_rows($editaingresso);

?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Editar Evento - Afetur Eventos</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<!--Ajax botão adicionar campos-->
	
		<!--Editor de Textos-->
		
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>

    <script src="js/summernote-pt-BR.js"></script>
    <script src="js/summernote-ext-elfinder.js"></script>


		<link rel="stylesheet" href="custom.css">
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
			<form name="cdeventos" id="cdeventos" method="post" enctype="multipart/form-data" action="proc_edt_eventos.php">
				<input name="ref" type="hidden" id="ref" value="<?php echo $row_editaevento['ref']; ?>">
				<input name="nme" type="hidden" id="nme" value="<?php echo $_SESSION['nome'];?>">

				<div class="card">
				<h5 class="card-header">1. Qual é o nome do evento?</h5>
				<div class="card-body">
					<div class="row">
						<div class="col">
							<label for="nomedoevento">Nome do Evento:</label>
							<input type="text" class="form-control" id="nome" name="nome" placeholder="Exemplo: 10ª Conferência" value="<?php echo $row_editaevento['nome_evento']; ?>">
						</div>
					</div>
					<div class="row" style="margin-top: 15px">
						<div class="col">
							<label for="nomedoevento">E-mail de cópia (CC):</label>
							<input type="email" class="form-control" id="emailcopia" name="emailcopia" value="<?php echo $row_editaevento['email_copia']; ?>">
						</div>
					</div>
				</div>
				</div>

				<div class="card" style="margin-top: 20px">
				<h5 class="card-header">2. Quando o evento vai acontecer?</h5>
				<div class="card-body">
					<div class="row">
						<div class="col">
							<label for="datainicial">Data de Início:</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroupPrepend2"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input type="date" class="form-control" id="datainicial" name="datainicial" value="<?php echo $row_editaevento['data_inicio']; ?>">
							</div>
						</div>
						
						<div class="col">
							<label for="datainicial">Data de Término:</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroupPrepend2"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input type="date" class="form-control" id="datafinal" name="datafinal" value="<?php echo $row_editaevento['data_final']; ?>">
							</div>
						</div>
						
						<div class="col">
							<label for="datainicial">Hora de Início:</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroupPrepend2"><i class="far fa-clock"></i></span>
								</div>
								<input type="time" class="form-control" id="horainicial" name="horainicial" value="<?php echo $row_editaevento['hora_inicio']; ?>">
							</div>
						</div>
						
						<div class="col">
							<label for="datainicial">Hora de Término:</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroupPrepend2"><i class="far fa-clock"></i></span>
								</div>
								<input type="time" class="form-control" id="horafinal" name="horafinal" value="<?php echo $row_editaevento['hora_final']; ?>">
							</div>
						</div>
						
						<div class="col">
							<label for="datainicial">Dias para Certificado:</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroupPrepend2"><i class="fas fa-calendar-day"></i></span>
								</div>
								<input type="number" class="form-control" id="diascheckin" name="diascheckin" value="<?php echo $row_editaevento['dias_checkin']; ?>">
							</div>
						</div>
						
					</div>
				</div>
				</div>

				<div class="card" style="margin-top:20px">
				<h5 class="card-header">3. Ingressos</h5>
				<div class="card-body">
				<div class="row">
					<div class="col">
						<label for="nomedolocal">Moeda:</label>
						<select type="text" class="form-control" id="moeda" name="moeda" onchange="campoSelect(this.value)﻿"  required>
							<option selected disabled>Selecione caso queira mudar a moeda...</option>
							<option value="R$" <?php if($row_editaevento['moeda']=="R$"){echo "selected";} ?>>Real brasileiro</option>
							<option value="&euro;" <?php if($row_editaevento['moeda']=="&euro;"){echo "selected";} ?>>Euro</option>
							<option value="US$" <?php if($row_editaevento['moeda']=="US$"){echo "selected";} ?>>Dolár Americano</option>
							<option value="C$" <?php if($row_editaevento['moeda']=="C$"){echo "selected";} ?>>Dolár Canadense</option>
							<option value="AU$" <?php if($row_editaevento['moeda']=="AU$"){echo "selected";} ?>>Dolár Australiano</option>
							<option value="&yen;" <?php if($row_editaevento['moeda']=="&yen"){echo "selected";} ?>>Moeda Japonesa (Yen)</option>
							<option value="NT$" <?php if($row_editaevento['moeda']=="NT$"){echo "selected";} ?>>Nova Tailandia</option>
							<option value="&pound;" <?php if($row_editaevento['moeda']=="&pound;"){echo "selected";} ?>>Libra Esterlina</option>
							<option value="&#x20bd;" <?php if($row_editaevento['moeda']=="&#x20bd;"){echo "selected";} ?>>Rublo Russo</option>
						</select>
					</div>
					
					<div class="col">
						<label for="nomedolocal">Parcelas de Boleto:</label>
						<select type="text" class="form-control" id="qtdboleto" name="qtdboleto"  required>
							<option value="<?php echo $row_editaevento['qtdboleto']; ?>" ><?php echo $row_editaevento['qtdboleto']; ?> parcela</option>
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
					</div>
					
					<div class="row" id="exibiring">
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
								<?php do { ?>
									<tr >
										<td colspan="2">
											<label for="nomeingresso">Ingresso:</label>
											<input type="text" name="ingresso[]" placeholder="Ex.: Ingresso Conferência" class="form-control name_list" required value="<?php echo $row_editaingresso['ingresso']; ?>"/>
											<input type="hidden" name="refing[]" value="<?php echo $row_editaingresso['ref_ingresso']; ?>"/>
										</td>
										<td>
											<label for="valoringresso">Valor:</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="inputGroupPrepend2"><input style="width: 35px;background: transparent; border:0;"  id="simbolo" name="simbolo[]" class="simbolo" value="<?php echo $row_editaevento['moeda']; ?>" readonly></span>
												</div>
												<input type="text" class="form-control" id="valor" name="valor[]" placeholder="Ex.: 1.150,00" required value="<?php echo str_replace(".",",",$row_editaingresso['valor']); ?>">
											</div>
										</td>
										<td>
											<label for="valoringresso">Unidade:</label>
											<div class="input-group">
												
												<input type="number" class="form-control" id="unidade" name="unidade[]" required value="<?php echo str_replace(".",",",$row_editaingresso['unidade']); ?>">
											</div>
										</td>

									</tr>
									<?php } while ($row_editaingresso = mysqli_fetch_assoc($editaingresso));?>
								</table>
								
							</div>
							</div>
						</div>
					</div>
					</div>
				</div>
				</div>

				<div class="card" style="margin-top:20px;">
				<h5 class="card-header">4. Onde o evento vai acontecer?</h5>
				<div class="card-body">
					<p>Ajude o público a chegar até o evento! Informe o endereço completo de onde ele irá acontecer.</p>
					<div class="row">
					<div class="col">
						<label for="nomedolocal">Nome do local:</label>
						<input type="text" class="form-control" id="nomelocal" name="nomelocal" placeholder="Exemplo: Afetur" required value="<?php echo $row_editaevento['local_nome']; ?>">
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<label for="cep">CEP:</label>
						<input type="text" class="form-control" id="cep" name="cep" placeholder="Exemplo: 60713-730" required value="<?php echo $row_editaevento['local_cep']; ?>">
					</div>
					</div>
					<div  id="endereco">
					<div class="row">
					<div class="col">
						<label for="rua">Av./Rua:</label>
						<input type="text" class="form-control" id="rua" name="rua" placeholder="Exemplo: Rua General Tertuliano" required value="<?php echo $row_editaevento['local_logradouro']; ?>">
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<label for="numero">Número:</label>
						<input type="text" class="form-control" id="numero" name="numero" placeholder="Exemplo: 137" required value="<?php echo $row_editaevento['local_numero']; ?>">
					</div>
					<div class="col">
						<label for="complemento">Complemento:</label>
						<input type="text" class="form-control" id="complemento" name="complemento" placeholder="Exemplo: Apto. 8, Bloco A" value="<?php echo $row_editaevento['local_complemento']; ?>">
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<label for="bairro">Bairro:</label>
						<input type="text" class="form-control" id="bairro" name="bairro" placeholder="Exemplo: Aldeota" value="<?php echo $row_editaevento['local_bairro']; ?>">
					</div>
					<div class="col">
						<label for="cidade">Cidade:</label>
						<input type="text" class="form-control" id="cidade" name="cidade" placeholder="Exemplo: Fortaleza" required value="<?php echo $row_editaevento['local_cidade']; ?>">
					</div>
					<div class="col">
						<label for="estado">Estado:</label>
						<input class="form-control" name="estado" id="estado" value="<?php echo $row_editaevento['local_estado']; ?>">
	
					</div>
					<div class="col">
						<label for="estado">País:</label>
						<input class="form-control" name="pais" id="pais" value="<?php echo $row_editaevento['local_pais']; ?>">
	
					</div>
					</div>
					</div>
				</div>
				</div>

				<div class="card" style="margin-top:20px;">
				<h5 class="card-header">5. Descrição do evento</h5>
				<div class="card-body">
					<p>Conte todos os detalhes do seu evento, como a programação e os diferenciais da sua produção!</p>
					<div class="row">
					<div class="col">
						<div class="form-group">
							<textarea id="summernote" name="descricaoevento"><?php echo $row_editaevento['descricao_evento']; ?></textarea>
							<script>

						$('#summernote').summernote({
								toolbar: [
						['style', ['style']],
						['font', ['bold', 'underline', 'clear', 'fontsize', 'fontsizeunit', 'strikethrough', 'superscript', 'subscript']],
						['fontname', ['fontname']],
						['color', ['color', 'forecolor', 'backcolor']],
						['para', ['ul', 'ol', 'paragraph', 'style', 'height']],
						['table', ['table']],
						['insert', ['link', 'picture', 'video']],
						['view', ['fullscreen', 'codeview', 'help', 'undo', 'redo']],
						],

								callbacks: {
									onImageUpload: function(files) {
										for(let i=0; i < files.length; i++) {
											$.upload(files[i]);
										}
									}
								},
								height: 200,
								lang: 'pt-BR',
								placeholder: 'Digite seu conteúdo aqui...',

							});

							$.upload = function (file) {
								let out = new FormData();
								out.append('file', file, file.name);

								$.ajax({
									method: 'POST',
									url: 'envia-img-summernote.php',
									contentType: false,
									cache: false,
									processData: false,
									data: out,
									success: function (img) {
										$('#summernote').summernote('insertImage', img);
									},
									error: function (jqXHR, textStatus, errorThrown) {
										console.error(textStatus + " " + errorThrown);
									}
								});
							};


						</script>
						</div>
					</div>
					</div>
				</div>
				</div>

				<div class="card" style="margin-top: 20px">
				<h5 class="card-header">6. Campo adicional</h5>
				<div class="card-body">
					<p>Adicione um campo extra no evento para preenchimento dos convidados. O formulário padrão permite que você digite nome e e-mail, portanto com esta opção você pode adicionar um terceiro campo.</p>
					<div class="row">
					<div class="col">
						<label for="campoadicional">Campo adicional:</label>
						<input type="text" class="form-control" id="campoadicional" name="campoadicional" placeholder="Exemplo: Clube" value="<?php echo $row_editaevento['campo_adicional']; ?>" required>
					</div>
					</div>
				</div>
				</div>

				<div class="card" style="margin-top: 20px">
				<h5 class="card-header">7. <strong>INTEGRAÇÃO</strong> - Víncular Campo adicional a uma lista</h5>
				<div class="card-body">
					<div class="alert alert-danger" role="alert">
						<strong>Importante!</strong> Se você não é um usuário avançado deixe em branco. Preencha apenas com informações verídicas.
					</div>
					<div class="row">
						<div class="col">
							Host (BD):
							<input type="text" name="hostbd" class="form-control" value="<?php echo $row_editaevento['host_bd']; ?>">
						</div>
						<div class="col">
							Usuário (BD):
							<input type="text" name="usuariobd" class="form-control" value="<?php echo $row_editaevento['usuario_bd']; ?>">
						</div>
						<div class="col">
							Senha (BD):
							<input type="password" name="passbd" class="form-control" value="<?php echo $row_editaevento['password_bd']; ?>">
						</div>
						<div class="col">
							Banco de Dados:
							<input type="text" name="bancobd" class="form-control" value="<?php echo $row_editaevento['banco_bd']; ?>">
						</div>
					</div>
					
					<div class="row">
						<div class="col">
							Tabela (BD):
							<input type="text" name="tabelabd" class="form-control" value="<?php echo $row_editaevento['tabela_bd']; ?>">
						</div>
						<div class="col">
							Text (BD):
							<input type="text" name="colunabd" class="form-control" value="<?php echo $row_editaevento['coluna_bd']; ?>">
						</div>
						<div class="col">
							Value (BD):
							<input type="text" name="valuebd" class="form-control" value="<?php echo $row_editaevento['value_bd']; ?>">
						</div>
					</div>
				</div>
				</div>

				<div class="card" style="margin-top: 20px;">
				<h5 class="card-header">8. Configuração de Pagamento</h5>
				<div class="card-body">
					<div class="alert alert-danger" role="alert">
					<strong>Importante!</strong> Estas informações serão necessárias para o funcionamento do sistema de pagamento do evento. (Obs.: Eventos gratuitos não são necessários)
					</div>
					<div class="alert alert-info" role="alert">
						<h2>Pagseguro</h2>
						<div class="row">
						<div class="col">
							<label for="emailpagseguro">E-mail Pagseguro:</label>
							<input type="text" class="form-control" id="emailpagseguro" name="emailpagseguro" value="<?php echo $row_editaevento['emailpagseguro']; ?>">

						</div>
						</div>
						<div class="row">
						<div class="col">
							<label for="tokenpagseguro">Token Pagseguro:</label>
							<input type="text" class="form-control" id="tokenpagseguro" name="tokenpagseguro" value="<?php echo $row_editaevento['tokenpagseguro']; ?>">

						</div>
						<div class="col">
							<label for="appidpagseguro">AppId Pagseguro:</label>
							<input type="text" class="form-control" id="appidpagseguro" name="appidpagseguro" value="<?php echo $row_editaevento['appidpagseguro']; ?>">

						</div>
						
						<div class="col">
							<label for="appkeypagseguro">AppKey Pagseguro:</label>
							<input type="text" class="form-control" id="appkeypagseguro" name="appkeypagseguro" value="<?php echo $row_editaevento['appkeypagseguro']; ?>">

						</div>
						</div>
					</div>

					<div class="alert alert-info" role="alert">
						<h2>Paghiper</h2>
						<div class="row">
						<div class="col">
							<label for="appkeypagseguro">AppKey PagHiper:</label>
							<input type="text" class="form-control" id="appkeypaghiper" name="appkeypaghiper" value="<?php echo $row_editaevento['appkeypaghiper']; ?>">

						</div>
						<div class="col">
							<label for="appkeypagseguro">Token PagHiper:</label>
							<input type="text" class="form-control" id="tokenpaghiper" name="tokenpaghiper" value="<?php echo $row_editaevento['tokenpaghiper']; ?>">

						</div>
						</div>
					</div>
					<div class="alert alert-info" role="alert">
						<h2>Paypal</h2>
						<div class="row">
						<div class="col">
							<label for="clientidpaypal">Client ID Paypal:</label>
							<input type="text" class="form-control" id="clientidpaypal" name="clientidpaypal" value="<?php echo $row_editaevento['clientidpaypal']; ?>">

						</div>
						</div>
					</div>
					
				</div>
				</div>

				<div class="row">
					<div class="col" style="display:flex; justify-content:center; margin-top: 10px">
						<input type="hidden" name="id_evento" id="id_evento" value="<?php echo $row_editaevento['id_evento']; ?>">
						<button type="submit" id="cadastrar" class="btn btn-primary">ATUALIZAR EVENTO</button>
					</div>
				</div>	
			</form>
	</div>  
	   
   </body>
</html>
<script>

window.addEventListener('load',function campoSelect(val){
document.getElementById("simbolo").value = val;
var simb = document.getElementById("simbolo").value;
if(simb == "Grátis"){document.getElementById("valor").value = 0;}
else if(simb == "R$"){document.getElementById("exibirpag").style.display = "block";}
else{document.getElementById("exibirpaypal").style.display = "block";}
document.getElementById("exibiring").style.display = "block";
});
</script>

<script>


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
		
		$('#dynamic_field').append('<tr id="row'+i+'"><td><label for="nomeingresso">Ingresso:</label><input type="text" name="ingresso2[]" placeholder="Ex.: Ingresso Conferência" class="form-control name_list" /></td><td><label for="valoringresso">Valor:</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend2"><input style="width: 20px;background: transparent; border:0;"  id="simb'+i+'" name="simbolo2[]" class="simb" value="'+teste+'" readonly></span></div><input type="text" class="form-control" id="valor" name="valor2[]" placeholder="Ex.: 1.150,00"></div></td><td><label for="valoringresso">Unidade:</label><div class="input-group"><input type="number" class="form-control" id="unidade" name="unidade2[]" placeholder="Ex.: 1.150,00"></div></td><td style="text-align:center"><br><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button> REMOVER</td></tr>');
	

	});

	
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
	
	
	
});
</script>