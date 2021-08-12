<?php
include("valida_pagina.php");

$ref = $_GET['ref'];

$sql = "SELECT * FROM evn_pedidos INNER JOIN evn_inscritos ON evn_pedidos.id = evn_inscritos.pedido WHERE evn_pedidos.ref = '$ref' AND (evn_pedidos.status = 3 OR evn_pedidos.status = 14 OR evn_pedidos.status = 4) ORDER BY evn_inscritos.nome_inscrito ASC";
$editaevento = mysqli_query($link, $sql) or die(mysqli_error($link));
$totalRows_editaevento = mysqli_num_rows($editaevento);

$campoad = "SELECT * FROM evn_eventos WHERE ref = '$ref'";
$editacampoad = mysqli_query($link, $campoad) or die(mysqli_error($link));
$row_editacampoad = mysqli_fetch_assoc($editacampoad);
$totalRows_editacampoad = mysqli_num_rows($editacampoad);

$sqlperc = "SELECT * FROM evn_datas_checkin";
$perc = mysqli_query($link, $sqlperc) or die(mysqli_error($link));
$row_perc = mysqli_fetch_assoc($perc);
$totalRows_perc = mysqli_num_rows($perc);

$tabelabd = $row_editacampoad['tabela_bd'];
$colunabd = $row_editacampoad['coluna_bd'];
$valuebd = $row_editacampoad['value_bd'];

if($tabelabd == "" || $colunabd == ""){

}else{
//Segunda Conexão - Integração
$local2 = $row_editacampoad['host_bd'];
$usuario2 = $row_editacampoad['usuario_bd'];
$senha2 = $row_editacampoad['password_bd'];
$banco2 = $row_editacampoad['banco_bd'];
$link2 = mysqli_connect($local2, $usuario2, $senha2, $banco2);
 
if (!$link2) {
    echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
//Segunda Conexão - Integração

$qr = "SELECT * FROM ".$tabelabd." ORDER BY ".$colunabd." ASC";
$adicional = mysqli_query($link2, $qr) or die(mysqli_error($link2));
$row_adicional = mysqli_fetch_assoc($adicional);
$totalRows_adicional = mysqli_num_rows($adicional);

}

//Código de barras

function geraCodigoBarra($numero){
		$fino = 1;
		$largo = 3;
		$altura = 50;
		
		$barcodes[0] = '00110';
		$barcodes[1] = '10001';
		$barcodes[2] = '01001';
		$barcodes[3] = '11000';
		$barcodes[4] = '00101';
		$barcodes[5] = '10100';
		$barcodes[6] = '01100';
		$barcodes[7] = '00011';
		$barcodes[8] = '10010';
		$barcodes[9] = '01010';
		
		for($f1 = 9; $f1 >= 0; $f1--){
			for($f2 = 9; $f2 >= 0; $f2--){
				$f = ($f1*10)+$f2;
				$texto = '';
				for($i = 1; $i < 6; $i++){
					$texto .= substr($barcodes[$f1], ($i-1), 1).substr($barcodes[$f2] ,($i-1), 1);
				}
				$barcodes[$f] = $texto;
			}
		}
		
		echo '<img src="codigo-barras/imagens/p.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		echo '<img src="codigo-barras/imagens/b.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		echo '<img src="codigo-barras/imagens/p.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		echo '<img src="codigo-barras/imagens/b.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		
		echo '<img ';
		
		$texto = $numero;
		
		if((strlen($texto) % 2) <> 0){
			$texto = '0'.$texto;
		}
		
		while(strlen($texto) > 0){
			$i = round(substr($texto, 0, 2));
			$texto = substr($texto, strlen($texto)-(strlen($texto)-2), (strlen($texto)-2));
			
			if(isset($barcodes[$i])){
				$f = $barcodes[$i];
			}
			
			for($i = 1; $i < 11; $i+=2){
				if(substr($f, ($i-1), 1) == '0'){
  					$f1 = $fino ;
  				}else{
  					$f1 = $largo ;
  				}
  				
  				echo 'src="codigo-barras/imagens/p.gif" width="'.$f1.'" height="'.$altura.'" border="0">';
  				echo '<img ';
  				
  				if(substr($f, $i, 1) == '0'){
					$f2 = $fino ;
				}else{
					$f2 = $largo ;
				}
				
				echo 'src="codigo-barras/imagens/b.gif" width="'.$f2.'" height="'.$altura.'" border="0">';
				echo '<img ';
			}
		}
		echo 'src="codigo-barras/imagens/p.gif" width="'.$largo.'" height="'.$altura.'" border="0" />';
		echo '<img src="codigo-barras/imagens/b.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		echo '<img src="codigo-barras/imagens/p.gif" width="1" height="'.$altura.'" border="0" />';
	}
	


// Datas para exibir no modal de check in

$diascheckin = $row_editacampoad['dias_checkin'];
$datainicio = $row_editacampoad['data_inicio'];
$datafinal = $row_editacampoad['data_final'];

$d1 = $datainicio;
$d2 = $datafinal;

$timestamp1 = strtotime( $d1 );
$timestamp2 = strtotime( $d2 );


while ( $timestamp1 <= $timestamp2 )
{
$teste[] = date( 'Y-m-d', $timestamp1 ) . PHP_EOL;
$timestamp1 += 86400;

}
?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Lista de Inscritos - Afetur Eventos</title>
	    <?php include('head.php');?>

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
   <body >
       
	   <?php
		require('nav-main.php');
	   ?>

	<div class="container content" style="min-height: 780px;">
			<h3 style="margin-top:25px;"><i class="far fa-list-alt"></i> Lista de Inscritos <button type="button" class="btn btn-info print" onclick="window.print();return false;"><i class="fas fa-print"></i> Imprimir</button> <a href="cracha<?php echo $row_editacampoad['ref']; ?>" role="button" class="btn btn-success" ><i class="fas fa-user-check"></i> Crachá</a> <a href="checkin/escolhe-data.php?ref=<?php echo $row_editacampoad['ref']; ?>" role="button" class="btn btn-warning" ><i class="fas fa-tasks"></i> Check-in</a> <a href="relatorio-checkin.php?ref=<?php echo $row_editacampoad['ref']; ?>" role="button" class="btn btn-danger" ><i class="fas fa-tasks"></i> Relatório de Checkin</a></h3>
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="alert alert-info" role="alert">
						<strong>Inscritos no evento:</strong> <?php echo $row_editacampoad['nome_evento']; ?>
					</div>
				</div>
				
				<div class="col-12 col-md-6">
					<div class="alert alert-info" role="alert">
						<strong>Quantidade de inscritos:</strong> <?php echo $totalRows_editaevento; ?>
					</div>
				</div>
			</div>

	<form method="post" action="proc-cd-inscrito-pedido.php">
	<input name="nme" type="hidden" id="nme" value="<?php echo $_SESSION['nome'];?>">
	<input type="hidden" name="ref" id="ref" value="<?php echo $row_editacampoad['ref']; ?>"/>
		<div class="row">
			<div class="col">
				<div class="form-group">
					<input type="text" style="width: 280px;" class="form-control" id="nomeparticipa" name="nomeparticipa" placeholder="Nome do participante">
				  </div>
			</div>
			<div class="col">
				<div class="form-group">
					<input type="email" style="width: 280px;" class="form-control" id="emailparticipa" name="emailparticipa" aria-describedby="emailHelp" placeholder="E-mail do participante">
				  </div>
			</div>
			<div class="col">
				<div class="form-group">
					<input type="text" class="form-control" id="busca" name="pedidoparticipa" placeholder="Nº Pedido">
				  </div>
			</div>
			<div class="col">
				<div class="form-group">
					<input type="text" class="form-control" id="cpadparticipa" name="cpadparticipa" placeholder="<?php echo $row_editacampoad['campo_adicional']; ?>">
				  </div>
			</div>
			<div class="col">
				<button type="submit" class="btn btn-info"><i class="fas fa-plus-circle"></i> Inserir</button>
			</div>
		</div>
		</form>

			<div class="row">
			<input type="hidden" id="ref" name="ref" value="<?php echo $row_editacampoad['ref']; ?>">
				<div class="col">
				<div class="table-responsive">
					<table class="table">
					  <thead class="thead-dark">
						<tr>
						  <th scope="col" style="text-align:center;">Participante</th>
						  <th scope="col" style="text-align:center;">E-mail</th>
						  <th scope="col" style="text-align:center;">Pedido</th>
						  <th scope="col" style="text-align:center;"><?php echo $row_editacampoad['campo_adicional']; ?></th>
						  <th scope="col" style="text-align:center;"></th>
						  <th scope="col" style="text-align:center;"></th>
						  <th scope="col" style="text-align:center;"></th>
						  
						</tr>
					  </thead>
					  <tbody>
					  
					
					  <?php while ($row_editaevento = mysqli_fetch_array($editaevento)){ ?>
					  
						<tr <?php if($row_editaevento['status'] == 14){ echo 'style="background: #ffe6e6;"';} ?> id="<?php echo $row_editaevento["id_inscritos"]; ?>">
						  <td style="vertical-align: middle;" contenteditable="true" data-old_value="<?php echo $row_editaevento["nome_inscrito"]; ?>" onBlur="saveInlineEdit(this,'nome_inscrito','<?php echo $row_editaevento["id_inscritos"]; ?>')" onClick="highlightEdit(this);" scope="row" align="center" style="text-align:center;" ><?php echo $row_editaevento['nome_inscrito']; ?> </td>
						  <td style="vertical-align: middle;" contenteditable="true" data-old_value="<?php echo $row_editaevento["email_inscrito"]; ?>" onBlur="saveInlineEdit(this,'email_inscrito','<?php echo $row_editaevento["id_inscritos"]; ?>')" onClick="highlightEdit(this);" scope="row" align="center" style="text-align:center;"><?php echo $row_editaevento['email_inscrito']; ?> </td>
						  <td style="vertical-align: middle;" align="center"> <a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/eventos/pagseguro/detalhes-pedido.php?id=<?php echo $row_editaevento['id']; ?>"><i class="fas fa-store"></i> <?php echo $row_editaevento['id']; ?></a> <?php if($row_editaevento['status'] == 14){ echo '<i class="fas fa-exclamation-circle" style="color: #ff0000; margin-right: 10px;" title="Pagamento por terceiro ou pendente"></i>';} ?></td>
						  <?php if($row_editacampoad['tabela_bd'] == ""){?>						  
						  <td style="vertical-align: middle;" contenteditable="true" data-old_value="<?php echo $row_editaevento["cpadicional"]; ?>" onBlur="saveInlineEdit(this,'cpadicional','<?php echo $row_editaevento["cpadicional"]; ?>')" onClick="highlightEdit(this);" scope="row" align="center" style="text-align:center;"><?php echo $row_editaevento['cpadicional']; ?> </td>
						  <?php }else{?>
						  <td style="vertical-align: middle;">
							 <form id="trocacpadicional" action="proc-update-cpadicional.php" method="post">
							  <select name="cadd" onChange="this.form.submit()" class="form-control" >
							  	<?php 
									foreach($adicional as $row){
										if($row_editaevento["cpadicional"] == $row[$valuebd]){
											echo "<option value=".$row[$valuebd].">".$row['nome_clube']."</option>";
										}
									}
								?>
							  
								<?php 
									foreach($adicional as $row){
										echo "<option value=".$row[$valuebd].">".$row['nome_clube']."</option>";
									}
								?>
							  </select>
							  <input type="hidden" name="id_inscritos" value="<?php echo $row_editaevento["id_inscritos"]; ?>"/>
							  <input type="hidden" name="ref" value="<?php echo $row_editaevento["ref"]; ?>"/>
							  <input name="nme" type="hidden" id="nme" value="<?php echo $_SESSION['nome'];?>">
							  <input type="hidden" name="cpinscrito" value="<?php echo $row_editaevento["cpadicional"]; ?>"/>
							  
							  </form>
						</td>
						<?php }?>
						<?php if($row_editaevento["certificado"] == 1){?>
						<td style="vertical-align: middle;" align="center"><a href="certificado.php?id_inscritos=<?php echo $row_editaevento["id_inscritos"]; ?>&ref=<?php echo $row_editaevento["ref"]; ?>" target="_blank" title="Certificado"><i class="fas fa-graduation-cap"></i></a></td>
						<?php }else{ ?>
						<td style="vertical-align: middle;" align="center"><i class="fas fa-graduation-cap" style="color: #bfbfbf" title="Certificado não liberado"></i></td>
						<?php } ?>
						
						<td style="vertical-align: middle;" align="center" ><a href="enviar-voucher.php?id=<?php echo $row_editaevento['id_inscritos']; ?>&pedido=<?php echo $row_editaevento['id']; ?>" title="Enviar voucher do inscrito"><i class="fas fa-file-upload vc"></i></a></td>
						
						<td style="vertical-align: middle;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter<?php echo $row_editaevento['id_inscritos']; ?>" title="Realizar check-in"><i class="far fa-check-circle"></i></button></td>
						
						<!-- Modal Checkin -->
						<div class="modal fade" id="exampleModalCenter<?php echo $row_editaevento['id_inscritos'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Check-in - <strong><?php echo $row_editaevento["nome_inscrito"]; ?></strong></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="row">
								<div class="col" style="text-align:center;">
								<p>Escolha o dia para fazer check-in:</p>
									<?php 
										$cont = 0;
										foreach($teste as $t){
											echo '<a class="btn btn-primary" style="margin-bottom: 5px;" href="proc-update-checkin.php?id_inscritos='.$row_editaevento['id_inscritos'].'&ref='.$ref.'&data='.$t.'" role="button">'.date("d/m/Y",strtotime($t))."</a><br>";
											$cont +=1;
										}
									?>
								</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
								<button type="button" class="btn btn-primary">Salvar</button>
							</div>
							</div>
						</div>
						</div>


						<!-- Modal Código de Barras -->
						<div class="modal fade" id="exampleModal<?php echo $row_editaevento['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle"><?php echo $row_editaevento["nome_inscrito"]; ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="row">
								<div class="col-2">
							<?php echo geraCodigoBarra($row_editaevento['id']);?>
							</div>
							<div class="col-8">
							<strong>Inscrito:</strong> <?php echo $row_editaevento["nome_inscrito"]; ?><Br>
							<strong>E-mail:</strong> <?php echo $row_editaevento["email_inscrito"]; ?><br>
							<strong>Nº pedido:</strong> 
							</div>
							</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
								<button type="button" class="btn btn-primary">Imprimir</button>
							</div>
							</div>
						</div>
						</div>
												
						</tr>
						
							
						
					  <?php } ?>
					  </tbody>
					  
					</table>
				</div>
				</div>
			</div>
	</div>  
	   <?php include_once("footer.php");?>
	   
	   
	<script type="text/javascript" src="jquery-ui.min.js"></script>
	<script type="text/javascript" src="custom.js"></script>
	   
   </body>
</html>


