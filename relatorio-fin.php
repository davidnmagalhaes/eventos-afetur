<?php
include("valida_pagina.php");

$ref = $_GET['ref'];

$sql = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND (status = 3 OR status = 4) ORDER BY nome ASC";
$editaevento = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_editaevento = mysqli_fetch_assoc($editaevento);
$totalRows_editaevento = mysqli_num_rows($editaevento);

$qr = "SELECT * FROM evn_eventos WHERE ref = '$ref'";
$editaev = mysqli_query($link, $qr) or die(mysqli_error($link));
$row_editaev = mysqli_fetch_assoc($editaev);
$totalRows_editaev = mysqli_num_rows($editaev);

//$queryqtd = "SELECT SUM(qtd_ingresso) as qts FROM evn_pedidos WHERE ref = '$ref' AND status = 3";
//$somaqtd = mysqli_query($link, $queryqtd) or die(mysqli_error($link));
//$row_somaqtd = mysqli_fetch_assoc($somaqtd);
//$totalRows_somaqtd = mysqli_num_rows($somaqtd);

$query = "SELECT SUM(total_pedido) as subt FROM evn_pedidos WHERE ref = '$ref' AND (status = 3 OR status = 4)";
$pegatotal = mysqli_query($link, $query) or die(mysqli_error($link));
$row_pegatotal = mysqli_fetch_assoc($pegatotal);

$sqlcanc = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND (status = 5 OR status = 6 OR status = 9 OR status = 10 OR status = 11)";
$canceladas = mysqli_query($link, $sqlcanc) or die(mysqli_error($link));
$row_canceladas = mysqli_fetch_assoc($canceladas);
$totalRows_canceladas = mysqli_num_rows($canceladas);

$inscritos = "SELECT * FROM evn_pedidos INNER JOIN evn_inscritos ON evn_pedidos.id = evn_inscritos.pedido WHERE evn_pedidos.ref = '$ref' AND (evn_pedidos.status = 3 OR evn_pedidos.status = 14 OR evn_pedidos.status = 4) ORDER BY evn_inscritos.pedido";
$editainscritos = mysqli_query($link, $inscritos) or die(mysqli_error($link));
$row_editainscritos = mysqli_fetch_assoc($editainscritos);
$totalRows_editainscritos = mysqli_num_rows($editainscritos);

$pagamentos = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND (status = 3 OR status = 4)";
$exibepagamentos = mysqli_query($link, $pagamentos) or die(mysqli_error($link));
$totalRows_exibepagamentos = mysqli_num_rows($exibepagamentos);

$paypal = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND (status = 3 OR status = 4) AND tipo_transacao = 'Paypal'";
$exibepaypal = mysqli_query($link, $paypal) or die(mysqli_error($link));
$totalRows_exibepaypal = mysqli_num_rows($exibepaypal);

$dinheiro = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND (status = 3 OR status = 4) AND tipo_transacao = 'Dinheiro'";
$exibedinheiro = mysqli_query($link, $dinheiro) or die(mysqli_error($link));
$totalRows_exibedinheiro = mysqli_num_rows($exibedinheiro);

$cartaoboleto = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND (status = 3 OR status = 4) AND tipo_transacao = '1x Cartão + Boletos'";
$exibecartaoboleto= mysqli_query($link, $cartaoboleto) or die(mysqli_error($link));
$totalRows_exibecartaoboleto = mysqli_num_rows($exibecartaoboleto);

$cartaodinheiro = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND (status = 3 OR status = 4) AND tipo_transacao = '1x Cartão + Dinheiro'";
$exibecartaodinheiro= mysqli_query($link, $cartaodinheiro) or die(mysqli_error($link));
$totalRows_exibecartaodinheiro = mysqli_num_rows($exibecartaodinheiro);

$boleto = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND (status = 3 OR status = 4) AND tipo_transacao = 'Boleto'";
$exibeboleto = mysqli_query($link, $boleto) or die(mysqli_error($link));
$totalRows_exibeboleto = mysqli_num_rows($exibeboleto);

$boletomanual = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND (status = 3 OR status = 4) AND tipo_transacao = 'Boleto Manual'";
$exibeboletomanual = mysqli_query($link, $boletomanual) or die(mysqli_error($link));
$totalRows_exibeboletomanual = mysqli_num_rows($exibeboletomanual);

$transferencia = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND (status = 3 OR status = 4) AND tipo_transacao = 'Transferência'";
$exibetransferencia = mysqli_query($link, $transferencia) or die(mysqli_error($link));
$totalRows_exibetransferencia = mysqli_num_rows($exibetransferencia);

$credito = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND (status = 3 OR status = 4) AND tipo_transacao = 'Cartão de Crédito'";
$exibecredito = mysqli_query($link, $credito) or die(mysqli_error($link));
$totalRows_exibecredito = mysqli_num_rows($exibecredito);

$debito = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND (status = 3 OR status = 4) AND tipo_transacao = 'Cartão de Débito'";
$exibedebito = mysqli_query($link, $debito) or die(mysqli_error($link));
$totalRows_exibedebito = mysqli_num_rows($exibedebito);

$cheque = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND (status = 3 OR status = 4) AND tipo_transacao = 'Cheque'";
$exibecheque = mysqli_query($link, $cheque) or die(mysqli_error($link));
$totalRows_exibecheque = mysqli_num_rows($exibecheque);

$pagseguro = "SELECT * FROM evn_pedidos WHERE ref = '$ref' AND(status = 3 OR status = 4) AND tipo_transacao = 'Pagseguro'";
$exibepagseguro = mysqli_query($link, $pagseguro) or die(mysqli_error($link));
$totalRows_exibepagseguro = mysqli_num_rows($exibepagseguro);

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
	    <?php include("head.php");?>
		
  </head>
   <body>
       
	   <?php
		require_once('nav-main.php');
	   ?>

	<div class="container content" style="min-height: 780px;">
			<h3 style="margin-top: 25px; margin-bottom: 20px;"><i class="far fa-clipboard"></i> <strong>Relatório</strong> <?php echo " - ".$row_editaevento['evento']; ?>  <button type="button" class="btn btn-info print" onclick="window.print();return false;"><i class="fas fa-print"></i> Imprimir</button> <a class="btn btn-success" href="exportar-excel.php?ref=<?php echo $row_editaevento['ref'];?>" role="button"><i class="fas fa-file-excel"></i> Exportar</a> 
			<a class="btn btn-success" href="exportar-excel-ordem-pagamento.php?ref=<?php echo $row_editaevento['ref'];?>" role="button"><i class="fas fa-file-excel"></i> Exportar (Ordem de Pagamento)</a>
			</h3>
			
			<div class="row" style="margin-bottom: 20px;">
				<div class="col">
					<div class="alert alert-success" role="alert" style="text-align:center;">
						<strong style="font-size: 26px">Vendas Totais</strong><br>
						
						<p style="font-size: 20px"><?php echo $row_editaev['moeda']; ?> <?php echo number_format($row_pegatotal['subt'],2,",","."); ?></p>
					</div>
				</div>
				<div class="col">
					<div class="alert alert-secondary" role="alert" style="text-align:center;">
						<strong style="font-size: 26px">Pagamentos</strong><br>
						
						<p style="font-size: 20px"><?php echo $totalRows_exibepagamentos; ?></p>

					</div>
				</div>
				
				<div class="col">
					<div class="alert alert-info" role="alert" style="text-align:center;">
						<strong style="font-size: 26px">Inscritos</strong><br>
						
						<p style="font-size: 20px"><?php echo $totalRows_editainscritos; ?></p>

					</div>
				</div>
				<div class="col">
					<div class="alert alert-danger" role="alert" style="text-align:center;">
						<strong style="font-size: 26px">Canceladas</strong><br>
						
						<p style="font-size: 20px"><?php echo $totalRows_canceladas; ?></p>

					</div>
				</div>
				
			</div>
			
			<div class="row" style="margin-bottom: 20px;">
			<?php if($totalRows_exibepaypal == 0){echo "";}else{ ?>
				<div class="col">
					<div class="alert alert-warning" role="warning" style="text-align:center;">
						<strong style="font-size: 16px">Paypal</strong><br>
						
						<p style="font-size: 12px"><?php echo $totalRows_exibepaypal; ?></p>
					</div>
				</div>
			<?php } ?>
			<?php if($totalRows_exibepagseguro == 0){echo "";}else{ ?>
				<div class="col">
					<div class="alert alert-warning" role="warning" style="text-align:center;">
						<strong style="font-size: 16px">Pagseguro</strong><br>
						
						<p style="font-size: 12px"><?php echo $totalRows_exibepagseguro; ?></p>
					</div>
				</div>
			<?php } ?>
			<?php if($totalRows_exibedinheiro == 0){echo "";}else{ ?>
				<div class="col">
					<div class="alert alert-warning" role="warning" style="text-align:center;">
						<strong style="font-size: 16px">Dinheiro</strong><br>
						
						<p style="font-size: 12px"><?php echo $totalRows_exibedinheiro; ?></p>
					</div>
				</div>
			<?php } ?>
			<?php if($totalRows_exibeboleto == 0){echo "";}else{ ?>
				<div class="col">
					<div class="alert alert-warning" role="warning" style="text-align:center;">
						<strong style="font-size: 16px">Boleto</strong><br>
						
						<p style="font-size: 12px"><?php echo $totalRows_exibeboleto; ?></p>
					</div>
				</div>
			<?php } ?>
			<?php if($totalRows_exibecartaoboleto == 0){echo "";}else{ ?>
				<div class="col">
					<div class="alert alert-warning" role="warning" style="text-align:center;">
						<strong style="font-size: 16px">1x Car. + Bol.</strong><br>
						
						<p style="font-size: 12px"><?php echo $totalRows_exibecartaoboleto; ?></p>
					</div>
				</div>
			<?php } ?>
			<?php if($totalRows_exibecartaodinheiro == 0){echo "";}else{ ?>
				<div class="col">
					<div class="alert alert-warning" role="warning" style="text-align:center;">
						<strong style="font-size: 16px">1x Car. + Din.</strong><br>
						
						<p style="font-size: 12px"><?php echo $totalRows_exibecartaodinheiro; ?></p>
					</div>
				</div>
			<?php } ?>
			<?php if($totalRows_exibeboletomanual == 0){echo "";}else{ ?>
				<div class="col">
					<div class="alert alert-warning" role="warning" style="text-align:center;">
						<strong style="font-size: 16px">Boleto Manual</strong><br>
						
						<p style="font-size: 12px"><?php echo $totalRows_exibeboletomanual; ?></p>
					</div>
				</div>
			<?php } ?>
			<?php if($totalRows_exibetransferencia == 0){echo "";}else{ ?>
				<div class="col">
					<div class="alert alert-warning" role="warning" style="text-align:center;">
						<strong style="font-size: 16px">Transferência</strong><br>
						
						<p style="font-size: 12px"><?php echo $totalRows_exibetransferencia; ?></p>
					</div>
				</div>
			<?php } ?>
			<?php if($totalRows_exibecredito == 0){echo "";}else{ ?>
				<div class="col">
					<div class="alert alert-warning" role="warning" style="text-align:center;">
						<strong style="font-size: 16px">Crédito</strong><br>
						
						<p style="font-size: 12px"><?php echo $totalRows_exibecredito; ?></p>
					</div>
				</div>
			<?php } ?>
			<?php if($totalRows_exibedebito == 0){echo "";}else{ ?>
				<div class="col">
					<div class="alert alert-warning" role="warning" style="text-align:center;">
						<strong style="font-size: 16px">Débito</strong><br>
						
						<p style="font-size: 12px"><?php echo $totalRows_exibedebito; ?></p>
					</div>
				</div>
			<?php } ?>
			<?php if($totalRows_exibecheque == 0){echo "";}else{ ?>
				<div class="col">
					<div class="alert alert-warning" role="warning" style="text-align:center;">
						<strong style="font-size: 16px">Cheque</strong><br>
						
						<p style="font-size: 12px"><?php echo $totalRows_exibecheque; ?></p>
					</div>
				</div>
			<?php } ?>
			</div>
			
			<div class="row">
			<input type="hidden" id="ref" name="ref" value="<?php echo $row_editaevento['ref']; ?>">
				<div class="col">
				<div class="table-responsive">
					<table class="table">
					  <thead class="thead-dark">
						<tr>
						  <th scope="col" style="text-align:center;">Responsável pela compra</th>
						  <th scope="col" style="text-align:center;">Nº Pedido</th>
						  <th scope="col" style="text-align:center;">Data da Compra</th>
						  <th scope="col" style="text-align:center;">Valor da compra</th>
							<th scope="col" style="text-align:center;">Tipo</th>
						</tr>
					  </thead>
					  <tbody>
					  <?php do { ?>
						<tr>
						  <th scope="row" align="center" style="text-align:center;"><?php echo $row_editaevento['nome']; ?></th>
						  <td align="center"><a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/eventos/pagseguro/detalhes-pedido.php?id=<?php echo $row_editaevento['id']; ?>"><i class="fas fa-store"></i> <?php echo $row_editaevento['id']; ?></a></td>
						  <td align="center"><?php echo date('d/m/Y', strtotime($row_editaevento['data_pedido'])); ?></td>
						  <td align="center"><?php echo $row_editaevento['moeda']; ?> <?php echo str_replace(".",",",$row_editaevento['total_pedido']); ?></td>
							<td align="center"><?php echo $row_editaevento['tipo_transacao']; ?></td>
						</tr>
						<?php } while ($row_editaevento = mysqli_fetch_assoc($editaevento));?>
					  </tbody>
					 
					</table>
</div>
				</div>
			</div>
	</div>  
	   <?php include_once("footer.php");?>
   </body>
</html>


