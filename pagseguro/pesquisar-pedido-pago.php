<?php
include("../valida_pagina.php");
	
	$pesquisar = $_POST['pesquisar'];
	$ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_POST['nme'];
	$mensagem = $hora." - ".$nme." pesquisou um pedido pelo termo: ".$pesquisar;
	
	
	$result_cursos = "SELECT evn_pedidos.moeda as moeda, evn_pedidos.ref as ref, evn_pedidos.data_pedido as datapedido, evn_pedidos.tipo_transacao as tipotransacao, evn_pedidos.id as idpedido, evn_status_pedido.status as status, evn_status_pedido.id as idstatus, evn_pedidos.nome as nome, evn_pedidos.email as email, evn_pedidos.total_pedido as totalpedido, evn_pedidos.evento as evento FROM evn_pedidos INNER JOIN evn_status_pedido ON evn_pedidos.status = evn_status_pedido.id WHERE evn_pedidos.id LIKE '%$pesquisar%' OR evn_pedidos.nome LIKE '%$pesquisar%' OR evn_pedidos.email LIKE '%$pesquisar%'";
	$resultado_cursos = mysqli_query($link, $result_cursos);
	$total_cursos = mysqli_num_rows($resultado_cursos);
	
	$sql = "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";
    
	if ($link->multi_query($sql) === TRUE) {
		
	} else {
		echo "Erro: " . $sql . "<br>" . $link->error;
	}

	$link->close();


	$protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';
?>


<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pesquisar Pedidos</title>
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
	


</head>
  <body>

<?php
		require($path.'nav-main.php');
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
 </form>
 </div>
 </div>
 
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
			
			
		
			
			
		</div>
 



<?php include_once("../footer.php");?>
</body>
</html>