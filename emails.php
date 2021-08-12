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
            if($_SESSION['nivel'] != "3"){
                $_SESSION['loginErro'] = "Área restrita";
                header("Location: index.php");
            }
			
        }

require_once('config/conn.php');

$id = $_GET['id_lista'];

$query = "SELECT * FROM evn_emails INNER JOIN evn_lista_email ON evn_lista_email.id_lista = evn_emails.ref_email WHERE evn_emails.ref_email = '$id' GROUP BY evn_emails.email ORDER BY evn_emails.email ASC ";
$emails = mysqli_query($link, $query) or die(mysqli_error($link));
$row_emails = mysqli_fetch_assoc($emails);
$totalRows_emails = mysqli_num_rows($emails);


//$sql = "SELECT * FROM evn_ingressos LEFT JOIN evn_eventos ON evn_ingressos.ref_evento=evn_eventos.ref";
//$ingressos = mysqli_query($link, $sql) or die(mysqli_error($link));
//$row_ingressos = mysqli_fetch_assoc($ingressos);
//$totalRows_ingressos = mysqli_num_rows($ingressos);

?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>E-mails - Afetur Eventos</title>
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
			<h3 style="margin-top: 20px;">E-mails da lista <strong><?php echo $row_emails['nome_lista']; ?></strong> <a href="cd-email.php?id_lista=<?php echo $row_emails['id_lista']; ?>" class="btn btn-primary" role="button">Inserir e-mail na lista</a> <a class="btn btn-success" href="exportar-email.php?id_lista=<?php echo $row_emails['id_lista'];?>" role="button"><i class="fas fa-file-excel"></i> Exportar</a></h3> 
			<div class="row">
			
				<div class="col">
				<div class="alert alert-primary" role="alert">
				 <?php echo "<strong>Total de e-mails:</strong> ".$totalRows_emails; ?>
				</div>
					<table class="table">
					  <thead class="thead-dark">
						<tr>
						  <th scope="col" style="text-align:center;">E-mail</th>
						  
									 
						  
						  <th scope="col" style="text-align:center;"><i class="fas fa-trash-alt"></i></th>
						  
						</tr>
					  </thead>
					  <tbody>
					  <?php do { ?>
						<tr>
						  <th scope="row" style="text-align:center"><?php echo $row_emails['email']; ?></th>
						  
						  <td align="center"><a title="Excluir evento" href="exc-lista.php?id_lista=<?php echo $row_eventos['id_lista'];?>" class="remove"><i class="fas fa-trash-alt"></i></a></td>
						</tr>
						<?php } while ($row_emails = mysqli_fetch_assoc($emails));?>
					  </tbody>
					</table>

				</div>
			</div>
	</div>  

	   <?php include_once("footer.php");?>
   </body>
</html>


