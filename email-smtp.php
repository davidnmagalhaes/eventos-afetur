<?php
include("valida_pagina.php");

$query = "SELECT * FROM evn_user_smtp ORDER BY id_smtp DESC";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);
$totalRows_eventos = mysqli_num_rows($eventos);

?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>E-mail SMTP - Afetur Eventos</title>
	    <?php include('head.php');?>

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
       
	   <?php
		require_once('nav-main.php');
	   ?>

	<div class="container content" style="min-height: 780px;">
			<h3 style="margin-top: 20px;">E-mail Remetente <a href="cd-smtp.php" class="btn btn-primary" role="button">Adicionar usuário</a></h3> 
			<div class="row">
			
				<div class="col">
					<table class="table">
					  <thead class="thead-dark">
						<tr>
						  <th scope="col" style="text-align:center;">E-mail</th>
						  <th scope="col" style="text-align:center;">SMTP</th>
									 
						  <th scope="col" style="text-align:center;"><i class="fas fa-wrench"></i></th>
						  <th scope="col" style="text-align:center;"><i class="fas fa-trash-alt"></i></th>
						  
						</tr>
					  </thead>
					  <tbody>
					  <?php do { ?>
						<tr>
						  <th scope="row" style="text-align:center"><?php echo $row_eventos['email_smtp']; ?></th>
						  <td align="center"><?php echo $row_eventos['smtp']; ?></td>
						  <td align="center"><a title="Editar evento" href="edt-smtp.php?id_smtp=<?php echo $row_eventos['id_smtp'];?>"><i class="fas fa-wrench"></i></a></td>
						  <td align="center"><a title="Excluir evento" href="exc-smtp.php?id_smtp=<?php echo $row_eventos['id_smtp'];?>" class="remove"><i class="fas fa-trash-alt"></i></a></td>
						</tr>
						<?php } while ($row_eventos = mysqli_fetch_assoc($eventos));?>
					  </tbody>
					</table>

				</div>
			</div>
	</div>  

	   <?php include_once("footer.php");?>
   </body>
</html>


