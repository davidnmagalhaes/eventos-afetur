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
?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Cadastro de SMTP - Afetur Eventos</title>
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
		
		
		
		
  </head>
   <body>
       <?php
		require_once('nav-main.php');
	   ?>

	<div class="container content">
			<form name="cdeventos" id="cdeventos" method="post" enctype="multipart/form-data" action="proc_cd_smtp.php">
				
				<div class="form-group">
				<h3 class="mg-top" style="margin-top: 20px;">Cadastro de E-mails - <strong>Remetente</strong></h3>
				<div class="row">
				<div class="col">
					<label for="emailsmtp">E-mail:</label>
					<input type="text" class="form-control" id="emailsmtp" name="emailsmtp" placeholder="Digite o e-mail remetente">

				</div>
				<div class="col">
					<label for="senhasmtp">Senha:</label>
					<input type="password" class="form-control" id="senhasmtp" name="senhasmtp">

				</div>
				</div>
				
				
				
				<div class="row">
				<div class="col">
					<label for="smtp">SMTP:</label>
					<input type="text" class="form-control" id="smtp" name="smtp" placeholder="Ex.: smtp.afetur.com.br">

				</div>
				
				</div>
				
					<button type="submit" id="cadastrar" class="btn btn-primary">CADASTRAR E-MAIL</button>
				</div>	
			</form>
	</div>  
	   <?php include_once("footer.php");?>
   </body>
</html>
