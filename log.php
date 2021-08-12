<?php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

session_start();

if((empty($_SESSION['iduser'])) || (empty($_SESSION['usuario'])) || (empty($_SESSION['nivel']))){       
            $_SESSION['loginErro'] = "Área restrita";
            header("Location: index.php");
        }else{
            if($_SESSION['nivel'] != "3" && $_SESSION['nivel'] != "4"){
                $_SESSION['loginErro'] = "Área restrita";
                header("Location: index.php");
            }
			
        }

require_once('config/conn.php');

$query = "SELECT * FROM evn_log ORDER BY id_log DESC ";
$logs = mysqli_query($link, $query) or die(mysqli_error($link));
$row_logs = mysqli_fetch_assoc($logs);
$totalRows_logs = mysqli_num_rows($logs);


//$sql = "SELECT * FROM evn_ingressos LEFT JOIN evn_eventos ON evn_ingressos.ref_evento=evn_eventos.ref";
//$ingressos = mysqli_query($link, $sql) or die(mysqli_error($link));
//$row_ingressos = mysqli_fetch_assoc($ingressos);
//$totalRows_ingressos = mysqli_num_rows($ingressos);

?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Logs - Afetur Eventos</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="bootstrap/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<link rel="stylesheet" href="custom.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	

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
			<h3 style="margin-top: 20px;">LOG's</h3> 
			<p>Aqui você consegue ver qualquer alteração realizada no sistema, e por quem fora feita.</p>
			<div class="row">
			
				<div class="col">
				<div class="table-responsive">
					<table class="table">
					  <thead class="thead-dark">
						<tr>
						  <th scope="col" style="text-align:center;">IP</th>
						   <th scope="col" style="text-align:center;">Data</th>
						    <th scope="col" style="text-align:center;">Quem</th>
							 <th scope="col" style="text-align:center;">Mensagem</th>
							  
									 
						  
						  
						</tr>
					  </thead>
					  <tbody>
					  <?php do { ?>
						<tr>
						  <td scope="row" style="text-align:center"><?php echo $row_logs['ip_log']; ?></td>
						  <td scope="row" style="text-align:center"><?php echo date('d/m/Y',strtotime($row_logs['data_log'])); ?></td>
						  <td scope="row" style="text-align:center"><?php echo $row_logs['nome_log']; ?></td>
						  <td scope="row" style="text-align:center"><?php echo $row_logs['mensagem_log']; ?></td>
						  
						</tr>
						<?php } while ($row_logs = mysqli_fetch_assoc($logs));?>
					  </tbody>
					</table>
</div>
				</div>
			</div>
	</div>  

	   <?php include_once("footer.php");?>
   </body>
</html>


