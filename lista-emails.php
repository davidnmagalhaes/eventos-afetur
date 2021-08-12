<?php
include("valida_pagina.php");

$query = "SELECT * FROM evn_lista_email WHERE status_lista = '1' ORDER BY id_lista DESC ";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$totalRows_eventos = mysqli_num_rows($eventos);

?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Lista de e-mails - Afetur Eventos</title>
	    <?php include('head.php');?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="script/function-2.js"></script>

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
       
	   <?php
		require_once('nav-main.php');
	   ?>

	<div class="container content" style="min-height: 780px;">
			<h3 style="margin-top: 20px;"><i class="fas fa-envelope-open-text"></i> Listas de E-mails <?php if($_SESSION['nivel'] == 3){?><a href="cd-lista-email.php" class="btn btn-primary" role="button">Adicionar Lista</a><?php }?></h3> 
			<div class="row">
			
				<div class="col">
					<table class="table">
					  <thead class="thead-dark">
						<tr>
						  <th scope="col" style="text-align:center;">Nome da lista</th>
						  
									 
						  <th scope="col" style="text-align:center;"><i class="fas fa-list-alt"></i></th>
						  <?php if($_SESSION['nivel'] == 3){?>
						  <th scope="col" style="text-align:center;"><i class="fas fa-trash-alt"></i></th>
						  <?php }?>
						</tr>
					  </thead>
					  <tbody>
					  <?php while ($row_eventos = mysqli_fetch_array($eventos)){ ?>
						<tr>
						  <td contenteditable="true" data-old_value="<?php echo $row_eventos['nome_lista']; ?>" onBlur="saveInlineEdit(this,'nome_lista','<?php echo $row_eventos['id_lista']; ?>')" onClick="highlightEdit(this);" scope="row" align="center" style="text-align:center;"><?php echo $row_eventos['nome_lista']; ?> </td>

						  
						  <td align="center"><a title="Ver lista de e-mails" href="emails.php?id_lista=<?php echo $row_eventos['id_lista'];?>"><i class="fas fa-list-alt"></i></a></td>
						 <?php if($_SESSION['nivel'] == 3){?>
						 <td align="center"><a title="Excluir lista de e-mails" href="exc-lista.php?id_lista=<?php echo $row_eventos['id_lista'];?>" class="remove"><i class="fas fa-trash-alt"></i></a></td>
						 <?php } ?>
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


