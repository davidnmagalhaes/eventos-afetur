<?php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

	require_once('config/conn.php');
	
	$pesquisar = $_POST['pesquisar'];
	$result_cursos = "SELECT * FROM evn_eventos WHERE nome_evento LIKE '%$pesquisar%' OR local_nome LIKE '%$pesquisar%' OR ref LIKE '%$pesquisar%' LIMIT 5";
	$resultado_cursos = mysqli_query($link, $result_cursos);
	
	
?>


<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Pesquisar - Afetur Eventos</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="bootstrap/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		
		
		
  </head>
   <body>
       <?php
		require_once('nav-main.php');
	   ?>

	<div class="container" style="min-height: 780px;">
			<h3>Eventos</h3>
			<div class="row">
			
				<div class="col">
					<table class="table">
					  <thead class="thead-dark">
						<tr>
						  <th scope="col" style="text-align:center;">Código</th>
						  <th scope="col" style="text-align:center;">Evento</th>
						  <th scope="col" style="text-align:center;">Quando</th>
						  <th scope="col" style="text-align:center;">Onde</th>
						  <th scope="col" style="text-align:center;">Ver</th>
						  <th scope="col"></th>
						  <th scope="col"></th>
						</tr>
					  </thead>
					  <tbody>
					  <?php do { ?>
						<tr>
						  <th scope="row" align="center"><?php echo $rows_cursos['ref']; ?></th>
						  <td align="center"><?php echo $rows_cursos['nome_evento']; ?></td>
						  <td align="center"><?php if($rows_cursos['data_inicio'] == $rows_cursos['data_final']){ echo date('d/m/Y', strtotime($rows_cursos['data_inicio']));}else{echo date('d/m/Y', strtotime($rows_cursos['data_inicio']))." at&eacute; ".date('d/m/Y', strtotime($rows_cursos['data_final']));} ?></td>
						  <td align="center"><?php echo $rows_cursos['local_nome']; ?></td>
						  <td align="center"><a href="evento_single.php?ref=<?php echo $rows_cursos['ref'];?>" target="_blank">Ver</a></td>
						  <td><a href="edt-evento.php?ref=<?php echo $rows_cursos['ref'];?>">Editar</a></td>
						  <td><a href="exc-evento.php?ref=<?php echo $rows_cursos['ref'];?>">Excluir</a></td>
						</tr>
						<?php } while ($rows_cursos = mysqli_fetch_array($resultado_cursos));?>
					  </tbody>
					</table>

				</div>
			</div>
	</div>  
	   <?php include_once("footer.php");?>
   </body>
</html>