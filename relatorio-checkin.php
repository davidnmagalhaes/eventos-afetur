<?php
include("valida_pagina.php");

$ref = $_GET['ref'];

$sql = "SELECT * FROM evn_relatorio INNER JOIN evn_inscritos ON evn_relatorio.id_inscrito = evn_inscritos.id_inscritos WHERE evn_relatorio.ref_evento = '$ref' ORDER BY evn_relatorio.data_relatorio DESC";
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
			<h3 style="margin-top:25px;"><i class="far fa-list-alt"></i> Relatório Checkin</h3>
			<div class="row">
				<div class="col-12">
					<div class="alert alert-info" role="alert">
						<strong>Evento:</strong> <?php echo $row_editacampoad['nome_evento']; ?>
					</div>
				</div>
				
			
			</div>


			<div class="row">
			<input type="hidden" id="ref" name="ref" value="<?php echo $row_editacampoad['ref']; ?>">
				<div class="col">
				<div class="table-responsive">
					<table class="table">
					  <thead class="thead-dark">
						<tr>
						  <th scope="col" style="text-align:center;">Participante</th>
						  <th scope="col" style="text-align:center;">Data</th>
						  <th scope="col" style="text-align:center;">Hora</th>
						  
						</tr>
					  </thead>
					  <tbody>
					  
					
					  <?php while ($row_editaevento = mysqli_fetch_array($editaevento)){ ?>
					  
						<tr>
						  <td style="text-align:center;"><?php echo $row_editaevento['nome_inscrito']; ?> </td>
						  <td style="text-align:center;"><?php echo date('d/m/Y',strtotime($row_editaevento['data_relatorio'])); ?></td>
                          <td style="text-align:center;"><?php echo date('H:i:s',strtotime($row_editaevento['data_relatorio'])); ?></td>
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


