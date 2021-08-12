<?php 
include("../valida_pagina.php");

$id = $_GET['id'];

$sql = "SELECT * FROM evn_pedidos WHERE id = '$id' ORDER BY id DESC";
$editasql = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_editasql = mysqli_fetch_assoc($editasql);
$totalRows_editasql = mysqli_num_rows($editasql);


$ref = $row_editasql['ref'];

$evento = "SELECT * FROM evn_eventos WHERE ref = '$ref'";
$editaevento = mysqli_query($link, $evento) or die(mysqli_error($link));
$row_editaevento = mysqli_fetch_assoc($editaevento);
$totalRows_editaevento = mysqli_num_rows($editaevento);

$tabelabd = $row_editaevento['tabela_bd'];
$colunabd = $row_editaevento['coluna_bd'];
$valuebd = $row_editaevento['value_bd'];

$sq = "SELECT evn_status_pedido.status as status,evn_status_pedido.id as idst, evn_pedidos.status as idstatus, evn_pedidos.id as idpedido FROM evn_pedidos INNER JOIN evn_status_pedido ON evn_pedidos.status=evn_status_pedido.id WHERE evn_pedidos.id = '$id' ORDER BY evn_pedidos.id DESC";
$editasq = mysqli_query($link, $sq) or die(mysqli_error($link));
$row_editasq = mysqli_fetch_assoc($editasq);
$totalRows_editasq = mysqli_num_rows($editasq);

$listast= "SELECT * FROM evn_status_pedido";
$editalistast = mysqli_query($link, $listast) or die(mysqli_error($link));
$row_editalistast = mysqli_fetch_assoc($editalistast);
$totalRows_editalistast = mysqli_num_rows($editalistast);

$ingressos = "SELECT * FROM evn_pedidos_ing WHERE ref_pedido = '$id';";
$editaingressos = mysqli_query($link, $ingressos) or die(mysqli_error($link));
$row_editaingressos = mysqli_fetch_assoc($editaingressos);
$totalRows_editaingressos = mysqli_num_rows($editaingressos);

if($tabelabd == "" || $colunabd == ""){
}else{

//Segunda Conexão - Integração
$local2 = $row_editaevento['host_bd'];
$usuario2 = $row_editaevento['usuario_bd'];
$senha2 = $row_editaevento['password_bd'];
$banco2 = $row_editaevento['banco_bd'];
$link2 = mysqli_connect($local2, $usuario2, $senha2, $banco2);
 
if (!$link2) {
    echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
//Segunda Conexão - Integração

$qr = "SELECT * FROM ".$tabelabd;
$adicional = mysqli_query($link2, $qr) or die(mysqli_error($link2));
$row_adicional = mysqli_fetch_assoc($adicional);
$totalRows_adicional = mysqli_num_rows($adicional);
}

header("Content-type: text/html; charset=utf-8");

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Editar Pedido</title>
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
		include($path.'nav-main.php');
	   ?>

<div class="container content" style="margin-top:20px;">
<div class="row">
<div class="col">
 <h1>EDITAR PEDIDO #<?php echo $row_editasql['id']; ?> </h1>
 <div class="table-responsive">
 
 
 <?php

 //$conn = new conecta();
 //$pedidos = $conn->listarPedidos();



 //foreach ($pedidos as $pedido){
 //echo ' <table class="table table-bordered"><tr ><th colspan="2" style="background: #000; color: #fff;" class="thead-dark"><strong>'.$pedido["descricao"].' '.$pedido["id"].' | '.date('d/m/Y', strtotime($pedido["data_pedido"])).'</strong></th> </tr><tr><td style="width: 30%"><strong>Status:</strong></td><td> '.$pedido["status"].'</td></tr> <tr><td><strong>Nome: </strong></td><td>'.$pedido["nome"].'</td></tr>  <tr><td><strong>E-mail: </strong></td><td>'.$pedido["email"].'</td></tr> <tr><td><strong>Evento: </strong></td><td>'.$pedido["evento"].'</td></tr> <tr><td><strong>Valor do pedido: </strong></td><td>'.$pedido["total_pedido"].'</td></tr><tr><td><strong>Forma Pagamento:</strong></td><td>'.$pedido["tipo_transacao"].'</td></tr></table>';
 //}
 
 ?> 

 </div>
 <form method="post" action="proc-edt-pedido-pendente.php">
 <div class="row">
				
					
						<table class="table">
						  <thead class="thead-dark">
							<tr>
							  <td scope="col" colspan="2"> <div class="alert alert-danger" role="alert"><strong>Respons&aacute;vel pela altera&ccedil;&atilde;o:</strong> <?php echo $_SESSION['nome'];?><br> <strong>Aten&ccedil;&atilde;o:</strong> Qualquer altera&ccedil;&atilde;o indevida neste pedido ser&aacute; de sua inteira responsabilidade.</div></td>
							  <input type="hidden" name="responsavel" id="responsavel" value="<?php echo $_SESSION['nome'];?>"/>
							</tr>
						  </thead>
						  <tbody>
						  <tr>
							  <th scope="row" style="width: 20%;">Status pedido:</th>
							  <td>
							  <select class="form-control" name="status" id="status">
							  <option value="<?php echo $row_editasq['idstatus']; ?>" selected><?php echo $row_editasq['status']; ?></option>
							  <?php do{ ?>
							  <option value="<?php echo $row_editalistast['id']; ?>"><?php echo $row_editalistast['status']; ?></option>
							  <?php } while ($row_editalistast = mysqli_fetch_assoc($editalistast));?>
							  </select>
							  </td>
							  
							</tr>
						  <tr>
							  <th scope="row" style="width: 20%;">Data pedido:</th>
							  <td><?php echo date('d/m/Y', strtotime($row_editasql['data_pedido'])); ?></td>
							  
							</tr>
							<tr>
							  <th scope="row" style="width: 20%;">Nome do Respons&aacute;vel:</th>
							  <td><input type="text" id="nome" name="nome" class="form-control" value="<?php echo $row_editasql['nome']; ?>"></td>
							  
							</tr>
							<tr>
							  <th scope="row">E-mail do respons&aacute;vel:</th>
							  <td><input type="email" id="email" name="email" class="form-control" value="<?php echo $row_editasql['email']; ?>"/></td>
							  
							</tr>
							<tr>
							  <th scope="row">Total do pedido:</th>
							  <td><?php echo $row_editasql['moeda']." ".str_replace(".",",",$row_editasql['total_pedido']); ?></td>
							  
							</tr>
							<tr>
							  <th scope="row">Tipo de pagamento:</th>
							  <td><?php echo $row_editasql['tipo_transacao']; ?></td>
							  
							</tr>
							<tr>
							  <th scope="row">Evento:</th>
							  <td><a target="_blank" href="<?php $_SERVER['HTTP_HOST'];?>/eventos/evento_single.php?ref=<?php echo $row_editasql['ref']; ?>"><?php echo $row_editasql['evento']; ?></a></td>
							  
							</tr>
							<tr>
							   
							  <?php if($row_editaevento['tabela_bd'] != ""){?>
							  <th scope="row"><?php echo $row_editaevento['campo_adicional']; ?>:</th>
							<td>
								<select id="cpadicional" name="cpadicional" class="form-control">
								
								
								<?php 
								if(is_numeric($row_editasql['campo_adicional'])){
									$s = "SELECT * FROM ".$tabelabd." WHERE ".$valuebd."=".$row_editasql['campo_adicional'];
								$editas = mysqli_query($link, $s) or die(mysqli_error($link));
								$row_editas = mysqli_fetch_assoc($editas);
								
								echo "<option value='".$row_editas[$valuebd]."'>".$row_editas[$colunabd]."</option>";
									
								
								}else{
								echo "<option>".$row_editasql['campo_adicional']."</option>";
								}?>
								
								
									<?php do{ ?>
									
									<option value="<?php echo $row_adicional[$valuebd];?>"><?php echo $row_adicional[$colunabd];?></option>
									<?php } while ($row_adicional = mysqli_fetch_assoc($adicional));?>
								</select>
							</td>
							  
							
							<?php }else{?>
							<th scope="row"><?php echo $row_editaevento['campo_adicional']; ?>:</th>
							<td>
							<input type="text" id="cpadicional" name="cpadicional" value="<?php echo $row_editasql['campo_adicional']; ?>" class="form-control"/>							
							</td>
							<?php }?>
							  
							  
							</tr>
							<tr>
							  <th scope="row">Ingresso comprado:</th>
							  <td>
							  <?php do{ ?>
							  <table>
							  <tr>
							  <td width="250">
								<?php echo $row_editaingressos['ing'];?>
							  </td>
							  <td>
							  <?php if($_SESSION['nivel'] == 5){?>
							  <a href="exc-ing.php?id_order_ing=<?php echo $row_editaingressos['id_order_ing'];?>&id=<?php echo $row_editasql['id']; ?>&nme=<?php echo $_SESSION['nome'];?>" class="btn btn-danger remove" role="button">Excluir</a>
							  <?php } ?>
							  </td>
							  </tr>
							  </table>
								<?php } while ($row_editaingressos = mysqli_fetch_assoc($editaingressos));?>
							  </td>
							  
							</tr>
							
						  </tbody>
						</table>
					
					<input type="hidden" name="id" id="id" value="<?php echo $row_editasql['id']; ?>"/>
				<input name="nme" type="hidden" id="nme" value="<?php echo $_SESSION['nome'];?>">
			</div>
			
			<div class="row" style="margin-bottom: 30px;">
				<div class="col" style="text-align:center;">
				<button class="btn btn-primary" type="submit" style="width: 200px;">Editar pedido</button>
				</div>
			</div>
		</div>
		
		</form>
 
 </div>
 </div>
 </div>
<?php include_once("../footer.php");?>
</body>
</html>