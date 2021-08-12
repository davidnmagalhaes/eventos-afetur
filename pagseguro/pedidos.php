<?php 
include("../valida_pagina.php");

$base = basename(__DIR__);

$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//Selecionar todos os cursos da tabela
$result_curso = "SELECT * FROM evn_pedidos WHERE status = 3 AND ref = '$ref'";
$resultado_curso = mysqli_query($link, $result_curso);

//Contar o total de cursos
$total_cursos = mysqli_num_rows($resultado_curso);

//Seta a quantidade de cursos por pagina
$quantidade_pg = 6;

//calcular o número de pagina necessárias para apresentar os cursos
$num_pagina = ceil($total_cursos/$quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

$ref = $_GET['ref'];

//Selecionar os cursos a serem apresentado na página
$result_cursos = "SELECT evn_pedidos.moeda as moeda, evn_pedidos.ref as ref, evn_pedidos.data_pedido as datapedido, evn_pedidos.tipo_transacao as tipotransacao, evn_pedidos.id as idpedido, evn_status_pedido.status as status, evn_status_pedido.id as idstatus, evn_pedidos.nome as nome, evn_pedidos.email as email, evn_pedidos.total_pedido as totalpedido, evn_pedidos.evento as evento FROM evn_pedidos INNER JOIN evn_status_pedido ON evn_pedidos.status = evn_status_pedido.id WHERE evn_pedidos.status = 3 AND evn_pedidos.ref='$ref' ORDER BY evn_pedidos.id DESC limit $incio, $quantidade_pg";
$resultado_cursos = mysqli_query($link, $result_cursos);
$total_cursos = mysqli_num_rows($resultado_cursos);


$protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pedidos</title>
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


		include($path.'nav-main.php');
	   ?>

<div class="container content" style="margin-top:20px;">
<div class="row">
<div class="col">
 <h1>PEDIDOS <strong>PAGOS</strong> </h1>
 <form action="pesquisar-pedido-pago.php" method="post">
 <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text"><i class="fas fa-search"></i></div>
        </div>
        <input type="text" name="pesquisar" id="pesquisar" class="form-control" id="inlineFormInputGroupUsername" placeholder="Digite o número, nome ou e-mail do pedido..." autofocus>
		<button class="btn btn-primary" type="submit" style="margin-left: 20px;">Pesquisar</button>
 </div>
 <input name="nme" type="hidden" id="nme" value="<?php echo $_SESSION['nome'];?>">
 </form>
 </div>
</div>
 
 
 <?php

 //$conn = new conecta();
 //$pedidos = $conn->listarPedidos();



 //foreach ($pedidos as $pedido){
 //echo ' <table class="table table-bordered"><tr ><th colspan="2" style="background: #000; color: #fff;" class="thead-dark"><strong>'.$pedido["descricao"].' '.$pedido["id"].' | '.date('d/m/Y', strtotime($pedido["data_pedido"])).'</strong></th> </tr><tr><td style="width: 30%"><strong>Status:</strong></td><td> '.$pedido["status"].'</td></tr> <tr><td><strong>Nome: </strong></td><td>'.$pedido["nome"].'</td></tr>  <tr><td><strong>E-mail: </strong></td><td>'.$pedido["email"].'</td></tr> <tr><td><strong>Evento: </strong></td><td>'.$pedido["evento"].'</td></tr> <tr><td><strong>Valor do pedido: </strong></td><td>'.$pedido["total_pedido"].'</td></tr><tr><td><strong>Forma Pagamento:</strong></td><td>'.$pedido["tipo_transacao"].'</td></tr></table>';
 //}
 
 ?> 


 
 <div class="row" style="margin:10px !important;">
				<?php while($rows_cursos = mysqli_fetch_assoc($resultado_cursos)){ ?>
					
					
					
						<table class="table">
						  <thead class="thead-dark">
							<tr>
							  <th scope="col" colspan="2"># <?php echo $rows_cursos['idpedido']; ?> | <?php if($rows_cursos['status'] == "PAGAMENTO APROVADO"){echo "<span style='color: #63f77c;'>".$rows_cursos['status']."</span>";}elseif($rows_cursos['status'] == "CANCELADO"){echo "<span style='color: #ea5656;'>".$rows_cursos['status']."</span>";}else{echo "<span style='color: #f7a763;'>".$rows_cursos['status']."</span>";}; ?>  <a href="edt-pedido.php?id=<?php echo $rows_cursos['idpedido'];?>" class="btn btn-info" role="button"><i class="fas fa-edit"></i> Editar</a></th>
							  
							</tr>
						  </thead>
						  <tbody>
						  <tr>
							  <th scope="row" style="width: 20%;">Data pedido:</th>
							  <td><?php echo date('d/m/Y', strtotime($rows_cursos['datapedido'])); ?></td>
							  
							</tr>
							<tr>
							  <th scope="row" style="width: 20%;">Nome do Responsável:</th>
							  <td><?php echo $rows_cursos['nome']; ?></td>
							  
							</tr>
							<tr>
							  <th scope="row">E-mail do responsável:</th>
							  <td><a href="mailto:<?php echo $rows_cursos['email']; ?>"><?php echo $rows_cursos['email']; ?></a></td>
							  
							</tr>
							<tr>
							  <th scope="row">Total do pedido:</th>
							  <td><?php echo $rows_cursos['moeda']." ".str_replace(".",",",$rows_cursos['totalpedido']); ?></td>
							  
							</tr>
							<tr>
							  <th scope="row">Tipo de pagamento:</th>
							  <td><?php echo $rows_cursos['tipotransacao']; ?></td>
							  
							</tr>
							<tr>
							  <th scope="row">Evento:</th>
							  <td><a target="_blank" href="<?php $_SERVER['HTTP_HOST'];?>/eventos/evento_single.php?ref=<?php echo $rows_cursos['ref']; ?>"><?php echo $rows_cursos['evento']; ?></a></td>
							  
							</tr>
							<tr>
							  <th scope="row">Detalhes do pedido:</th>
							  <td>
								<a href="detalhes-pedido.php?id=<?php echo $rows_cursos['idpedido'];?>">Clique para ver...</a>
							  </td>
							  
							</tr>
						  </tbody>
						</table>
					
					
				<?php } ?>
			</div>
			<?php
				//Verificar a pagina anterior e posterior
				$pagina_anterior = $pagina - 1;
				$pagina_posterior = $pagina + 1;
			?>
			<nav class="text-center" style="margin:0 auto;">
				<ul class="pagination justify-content-center">
					
						<?php
						if($pagina_anterior != 0){ ?>
						<li class="page-item">
							<a class="page-link" href="pedidos.php?ref=<?php echo $ref;?>&pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
							</li>
						<?php }else{ ?>
						<li class="page-item disabled">
								<a class="page-link" href="">
							<span aria-hidden="true">&laquo;</span>
							</a>
							</li>
					<?php }  ?>
					
					<?php 
					//Apresentar a paginacao
					for($i = 1; $i < 5 + 1; $i++){ ?>
						<li class="page-item"><a class="page-link" href="pedidos.php?ref=<?php echo $ref;?>&pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
					<?php } ?>
					
						<?php
						if($pagina_posterior <= $num_pagina){ ?>
						<li class="page-item">
							<a class="page-link" href="pedidos.php?ref=<?php echo $ref;?>&pagina=<?php echo $pagina_posterior; ?>" aria-label="Previous">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
						<?php }else{ ?>
						<li class="page-item disabled">
							<a class="page-link" href="">
							<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					<?php }  ?>
					
				</ul>
			</nav>
			
		
			
			
		</div>
 
 </div>
 </div>
 </div>
<?php include_once("../footer.php");?>
</body>
</html>