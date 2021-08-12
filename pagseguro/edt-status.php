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
            header("Location: ../index.php");
        }else{
            if($_SESSION['nivel'] != "1" && $_SESSION['nivel'] != "2" && $_SESSION['nivel'] != "3"){
                $_SESSION['loginErro'] = "Área restrita";
                header("Location: ../index.php");
            }
			
        }
	
include_once("../config/conn.php");

$id = $_GET['id'];


$sq = "SELECT * FROM evn_status_pedido WHERE id='$id';";
$editasq = mysqli_query($link, $sq) or die(mysqli_error($link));
$row_editasq = mysqli_fetch_assoc($editasq);
$totalRows_editasq = mysqli_num_rows($editasq);



?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Editar Status</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="../bootstrap/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="jquery.js"></script>
<link rel="stylesheet" href="../custom.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	

	<!--<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>-->
<script language="JavaScript" type="text/javascript">

$(document).ready(function(){
    $("a.remove").click(function(e){
        if(!confirm('Atenção! Você está prestes a excluir um ingresso, salve qualquer alteração antes de excluir este ingresso.')){
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
		require_once('nav-sec.php');
	   ?>

<div class="container content" style="margin-top:20px;">
<div class="row">
<div class="col">
 <h1>EDITAR STATUS</h1>
 <div class="table-responsive">
 
 
 <?php

 //$conn = new conecta();
 //$pedidos = $conn->listarPedidos();



 //foreach ($pedidos as $pedido){
 //echo ' <table class="table table-bordered"><tr ><th colspan="2" style="background: #000; color: #fff;" class="thead-dark"><strong>'.$pedido["descricao"].' '.$pedido["id"].' | '.date('d/m/Y', strtotime($pedido["data_pedido"])).'</strong></th> </tr><tr><td style="width: 30%"><strong>Status:</strong></td><td> '.$pedido["status"].'</td></tr> <tr><td><strong>Nome: </strong></td><td>'.$pedido["nome"].'</td></tr>  <tr><td><strong>E-mail: </strong></td><td>'.$pedido["email"].'</td></tr> <tr><td><strong>Evento: </strong></td><td>'.$pedido["evento"].'</td></tr> <tr><td><strong>Valor do pedido: </strong></td><td>'.$pedido["total_pedido"].'</td></tr><tr><td><strong>Forma Pagamento:</strong></td><td>'.$pedido["tipo_transacao"].'</td></tr></table>';
 //}
 
 ?> 

 </div>
 
 <div class="row">
				
					<form method="post" action="proc-edt-status.php">
						<table class="table-responsive">
						  <thead class="thead-dark">
							<tr>
							  <td scope="col" colspan="3"> <div class="alert alert-danger" role="alert"><strong>Respons&aacute;vel pela altera&ccedil;&atilde;o:</strong> <?php echo $_SESSION['nome'];?><br> <strong>Aten&ccedil;&atilde;o:</strong> Qualquer altera&ccedil;&atilde;o indevida neste status ser&aacute; de sua inteira responsabilidade.</div></td>
							  <input type="hidden" name="responsavel" id="responsavel" value="<?php echo $_SESSION['nome'];?>"/>
							</tr>
						  </thead>
						  
						  <tr>
							  <th scope="row" style="width: 40%; text-align:center;" >Status:</th>
							  <td width="350">
							  
							  <input type="text" class="form-control" name="status" id="status" value="<?php echo $row_editasq['status']; ?>"/>
							  
							  
							  </td>
							  <td><button class="btn btn-primary"  type="submit">Editar</button></td>
							  
							</tr>
						  
							<input type="hidden" name="id" id="id" value="<?php echo $row_editasq['id']; ?>"/>
						  <input name="nme" type="hidden" id="nme" value="<?php echo $_SESSION['nome'];?>">
						</table>
					</form>
					
				
			</div>
			
			
		</div>
 
 </div>
 </div>
 </div>
<?php include_once("../footer.php");?>
</body>
</html>