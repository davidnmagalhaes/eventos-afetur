<?php
include("valida_pagina.php");

if($_SESSION['funcao'] == 1){
$query = "SELECT * FROM evn_eventos ORDER BY data_inicio desc";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$totalRows_eventos = mysqli_num_rows($eventos);
	}else{
$query = "SELECT * FROM evn_permissao INNER JOIN evn_eventos ON evn_permissao.ref_perm = evn_eventos.ref WHERE evn_permissao.usuario_perm = '$user' ORDER BY evn_eventos.data_inicio DESC";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$totalRows_eventos = mysqli_num_rows($eventos);
	}
?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Inscritos - Afetur Eventos</title>
	    <?php include("head.php");?>
		
  </head>
   <body>
       
	   <?php
		require_once('nav-main.php');
	   ?>

	<div class="container content" style="min-height: 780px;">
			<h3 style="margin-top:20px;"><i class="fas fa-list-alt"></i> Inscritos</h3>
			<div class="row">
			
				<div class="col">
					<table class="table">
					  <thead class="thead-dark">
						<tr>
						  <th scope="col" style="text-align:center;">Evento</th>
						  <th scope="col" style="text-align:center;"><i class="fas fa-eye"></i></th>
						</tr>
					  </thead>
					  <tbody>
					  <?php while ($row_eventos = mysqli_fetch_array($eventos)){ ?>
						<tr>
						  <td align="center"><?php echo $row_eventos['nome_evento']; ?></td>
						  <td align="center"><a href="lista-inscritos.php?ref=<?php echo $row_eventos['ref'];?>"><i class="fas fa-eye"></i></a></td>
						</tr>
						<?php } ?>
					  </tbody>
					</table>

				</div>
			</div>
	</div>  
	   <?php include_once("footer.php");?>
   </body>
</html>


