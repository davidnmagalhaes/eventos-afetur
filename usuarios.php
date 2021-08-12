<?php

include("valida_pagina.php");

$query = "SELECT * FROM evn_usuario ORDER BY nome ASC";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$totalRows_eventos = mysqli_num_rows($eventos);

?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Usuários - Sistema de Eventos Afetur</title>
		<?php include("head.php");?>
		
  </head>
   <body>
       
	   <?php
		require_once('nav-main.php');
	   ?>

	<div class="container content" style="min-height: 780px;">
			<h3 style="margin-top: 20px;"><i class="far fa-user" style="margin: 0 10px"></i> Usuários <a href="cd-usuarios.php" class="btn btn-primary" role="button"><i class="fas fa-plus-circle"></i> Adicionar</a></h3> 
			<div class="row">
				<div class="col">
				<div class="table-responsive">
					<table class="table" id="table">
					  <thead class="thead-dark">
						<tr>
						  	<th scope="col" style="text-align:center;">Nome</th>
						  	<th scope="col" style="text-align:center;">Usuário</th>
							<th scope="col" style="text-align:center;">Nível</th>	  
						  	
						  	<th scope="col" style="text-align:center;"></th>
						   
						</tr>
					  </thead>
					  <tbody>
					  <?php while ($row_eventos = mysqli_fetch_array($eventos)){ ?>
						<tr>
						  <th scope="row" style="text-align:center"><?php echo $row_eventos['nome']; ?></th>
						  <td align="center"><?php echo $row_eventos['email']; ?></td>
						  <td align="center"><?php if($row_eventos['funcao'] == 1){echo "Master";}else{echo "Padrão com Permissão";} ?></td>
						  
						  <td align="center"><a class="btn btn-primary" style="margin-right: 5px" title="Editar evento" href="edt-usuarios.php?id_user=<?php echo $row_eventos['cod_usuario'];?>"><i class="fas fa-wrench"></i></a><button class="btn btn-danger delete" id="del_<?php echo $row_eventos['cod_usuario'];?>"><i class="fas fa-trash-alt"></i></button><!--<a title="Excluir evento" href="exc-usuario.php?id_user=<?php //echo $row_eventos['cod_usuario'];?>" class="remove"><i class="fas fa-trash-alt"></i></a>--></td>
						</tr>
						<?php } ?>
					  </tbody>
					</table>
				</div>
				</div>
			</div>
	</div>  


	<script>
$(document).ready(function(){

// Delete 
$('.delete').click(function(){
  var el = this;
  var id = this.id;
  var splitid = id.split("_");

  // Delete id
  var deleteid = splitid[1];

  // AJAX Request
  $.ajax({
	url: 'exc-usuario.php',
	type: 'POST',
	data: { id:deleteid },
	success: function(response){

	  if(response == 1){
	// Remove row from HTML Table
	$(el).closest('tr').css('background','tomato');
	$(el).closest('tr').css('color','#fff');
	$(el).closest('tr').fadeOut(800,function(){
	   $(this).remove();
	});
	 }else{
	alert('ID Inválido.');
	 }

   }
  });

});

});
</script>

	   <?php include_once("footer.php");?>
   </body>
</html>


