<?php
include("valida_pagina.php");

$ref = $_GET['ref'];

$sql = "SELECT * FROM evn_eventos WHERE ref = '$ref'";
$editaevento = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_editaevento = mysqli_fetch_assoc($editaevento);
$totalRows_editaevento = mysqli_num_rows($editaevento);
?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Editar Capa do Evento - Afetur Eventos</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="bootstrap/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<!--Ajax botão adicionar campos-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<!--Editor de Textos-->
		<script src="editor.js"></script>
		<link href="editor.css" type="text/css" rel="stylesheet"/>
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
			<form name="cdeventos" id="cdeventos" method="post" enctype="multipart/form-data" action="proc-edt-foto.php">
				<input name="ref" type="hidden" id="ref" value="<?php echo $row_editaevento['ref']; ?>">
				 <input name="nme" type="hidden" id="nme" value="<?php echo $_SESSION['nome'];?>">
				<div class="form-group">
				<h3 class="mg-top">Editando imagem do evento #<?php echo $row_editaevento['ref'];?> | <?php echo $row_editaevento['nome_evento'];?></h3>
				<div class="row">
				<div class="col">
				
					
					
				
				
				
				
				
				<script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<div class="file-upload">
  <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Adicionar imagem ao evento</button>

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
				
					<div class="row">
						<div class="col" align="center">  <button type="submit" id="cadastrar" class="btn btn-primary" >ATUALIZAR IMAGEM</button></div>
					</div>
					
				</div>	
			</form>
	</div>  
	   
   </body>
</html>
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
		$('#dynamic_field').append('<tr id="row'+i+'"><td><label for="nomeingresso">Ingresso:</label><input type="text" name="ingresso[]" placeholder="Ex.: Ingresso Conferência" class="form-control name_list" /></td><td><label for="valoringresso">Valor:</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend2">R$</span></div><input type="text" class="form-control" id="valor" name="valor[]" placeholder="Ex.: 1.150,00"></div></td><td style="text-align:center"><br><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button> REMOVER</td></tr>');
	

	});

	
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
	
	
	
});
</script>