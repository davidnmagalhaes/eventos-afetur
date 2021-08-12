<?php

session_start();

if((empty($_SESSION['iduser'])) || (empty($_SESSION['usuario'])) || (empty($_SESSION['nivel']))){       
            $_SESSION['loginErro'] = "Área restrita";
            header("Location: index.php");
        }else{
            if($_SESSION['nivel'] != "1" && $_SESSION['nivel'] != "2" && $_SESSION['nivel'] != "3"){
                $_SESSION['loginErro'] = "Área restrita";
                header("Location: index.php");
            }
        }

require_once('config/conn.php');

$query = "SELECT * FROM evn_eventos ORDER BY id_evento DESC";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);
$totalRows_eventos = mysqli_num_rows($eventos);


//$sql = "SELECT * FROM evn_ingressos LEFT JOIN evn_eventos ON evn_ingressos.ref_evento=evn_eventos.ref";
//$ingressos = mysqli_query($link, $sql) or die(mysqli_error($link));
//$row_ingressos = mysqli_fetch_assoc($ingressos);
//$totalRows_ingressos = mysqli_num_rows($ingressos);

?>

<!DOCTYPE html>
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
		
		
		
  </head>
   <body>
       
	   <?php
		require_once('nav-main.php');
	   ?>

	<div class="container">
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
						  <th scope="row" align="center"><?php echo $row_eventos['ref']; ?></th>
						  <td align="center"><?php echo $row_eventos['nome_evento']; ?></td>
						  <td align="center"><?php if($row_eventos['data_inicio'] == $row_eventos['data_final']){ echo date('d/m/Y', strtotime($row_eventos['data_inicio']));}else{echo date('d/m/Y', strtotime($row_eventos['data_inicio']))." at&eacute; ".date('d/m/Y', strtotime($row_eventos['data_final']));} ?></td>
						  <td align="center"><?php echo $row_eventos['local_nome']; ?></td>
						  <td align="center"><a href="evento_single.php?ref=<?php echo $row_eventos['ref'];?>" target="_blank">Ver</a></td>
						  <td><a href="edt-evento.php?ref=<?php echo $row_eventos['ref'];?>">Editar</a></td>
						  <td><a href="exc-evento.php?ref=<?php echo $row_eventos['ref'];?>">Excluir</a></td>
						</tr>
						<?php } while ($row_eventos = mysqli_fetch_assoc($eventos));?>
					  </tbody>
					</table>

				</div>
			</div>
	</div>  
	   
   </body>
</html>


