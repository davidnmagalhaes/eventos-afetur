<?php 
include_once("../config/conn.php");

$idinscrito = $_GET['id_inscritos'];
$ref = $_GET['ref'];

$sql = "SELECT * FROM evn_inscritos WHERE id_inscritos = '$idinscrito'";
$inscritos = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_inscritos = mysqli_fetch_assoc($inscritos);
$totalRows_inscritos = mysqli_num_rows($inscritos);

$sql = "SELECT * FROM evn_pedidos INNER JOIN evn_inscritos ON evn_pedidos.id = evn_inscritos.pedido WHERE evn_pedidos.ref = '$ref' AND (evn_pedidos.status = 3 OR evn_pedidos.status = 14 OR evn_pedidos.status = 4) ORDER BY evn_inscritos.nome_inscrito ASC";
$editaevento = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_editaevento = mysqli_fetch_assoc($editaevento);
$totalRows_editaevento = mysqli_num_rows($editaevento);

$query = "SELECT * FROM evn_eventos WHERE ref='$ref'";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);
$totalRows_eventos = mysqli_num_rows($eventos);

$tabelabd = $row_eventos['tabela_bd'];
$colunabd = $row_eventos['coluna_bd'];
$valuebd = $row_eventos['value_bd'];

if($tabelabd == "" || $colunabd == ""){

}else{
	$qr = "SELECT * FROM ".$tabelabd." ORDER BY ".$colunabd." ASC";
$adicional = mysqli_query($link, $qr) or die(mysqli_error($link));
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
		
		echo '<img src="../codigo-barras/imagens/p.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		echo '<img src="../codigo-barras/imagens/b.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		echo '<img src="../codigo-barras/imagens/p.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		echo '<img src="../codigo-barras/imagens/b.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		
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
  				
  				echo 'src="../codigo-barras/imagens/p.gif" width="'.$f1.'" height="'.$altura.'" border="0">';
  				echo '<img ';
  				
  				if(substr($f, $i, 1) == '0'){
					$f2 = $fino ;
				}else{
					$f2 = $largo ;
				}
				
				echo 'src="../codigo-barras/imagens/b.gif" width="'.$f2.'" height="'.$altura.'" border="0">';
				echo '<img ';
			}
		}
		echo 'src="../codigo-barras/imagens/p.gif" width="'.$largo.'" height="'.$altura.'" border="0" />';
		echo '<img src="../codigo-barras/imagens/b.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		echo '<img src="../codigo-barras/imagens/p.gif" width="1" height="'.$altura.'" border="0" />';
	}

?>

<html>
<head>
<meta charset="UTF-8"/>
<title>Crachá</title>
</title>
<style>
body {
  background: rgb(204, 204, 204);
}

page {
  background: url("../<?php echo $row_eventos['cracha_background'];?>");
  background-size: 14.5cm 10cm;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
}

page[size="A4"] {
  width: 10cm;
  height: 14.5cm;
}

page[size="A4"][layout="landscape"] {
  width: 10cm;
  height: 14.5cm;
}

@media print {
  body,
  page {
-webkit-print-color-adjust: exact; 
  background: url("../<?php echo $row_eventos['cracha_background'];?>");
background-size: 14.5cm 10cm;   
   margin: 0;
    box-shadow: 0;
  }
}

.header {
  padding-top: 10px;
  text-align: center;
  border: 2px solid #ddd;
}

table {
  border-collapse: collapse;
  width: 100%;
  font-size: 80%;
  font-family: calibri;

}

table th {
  
  color: black;
  text-align: center;
}

th,
td {
 
  text-align: center;
}

tr:nth-child(even) {
  
}

</style>
</head>
<body>
<page size="A4">

  <!--<div class="header">
    [nomeEmpresa]
    <br> [endereco] - [cidade] - [cep]
    <br> [cnpj] - [telefone]
    <br>
    <h3>[nomeRelatorio] -  [tipoRelatorio]</h3>
  </div>-->

  <table class="table" cellpadding="0" cellspacing="0">
    
    <tbody>
      
      
      <tr>
        
		<td style="font-family: calibri; font-size: 35px; font-weight: bold; " height="200">
			<div style="width: 80px; height: 80px; background: <?php echo $row_eventos['cracha_cor_foto'];?>; margin:0 auto; padding: 5px; border-radius: 10px"><img src="webcam/files/images/avatar.png" width="80"/></div>
		</td>
        
        
      </tr>
	  
	  <tr>
        
		<td style="color: <?php echo $row_eventos['cracha_cor_titulo'];?>; font-family: calibri; font-size: 20px; font-weight: bold; "><?php echo $row_inscritos['nome_inscrito'];?></td>
       
        
      </tr>
	   <tr>
        
		<td style="color: <?php echo $row_eventos['cracha_cor_titulo'];?>; font-family: calibri; font-size: 20px; ">
		
		
							
						
					<?php if($row_eventos['tabela_bd'] == ""){?>						  
						 <?php echo $row_editaevento["cpadicional"]; ?>

						  
						 <?php }else{?>
						 
							  <?php 
								foreach($adicional as $row){
									if($row_editaevento["cpadicional"] == $row[$valuebd]){
								  echo "<option value=".$row[$valuebd].">".$row['nome_clube']."</option>";
									}
								}
							?>
							  
							
						 <?php }?>

						 
		
		
		
		
		</td>
       
        
      </tr>
	  <tr >
        
		<td height="57"></td>
       
        
      </tr>
	  
	  <tr cellpadding="0" cellspacing="0" border="0">
		<td  align="center" style=" width: 100%; background: #fff;" height="100"><?php echo $row_inscritos['id_inscritos'];?><br><?php geraCodigoBarra($row_inscritos['id_inscritos']); ?></td>
	  </tr>
	  
	  <tr cellpadding="0" cellspacing="0" border="0">
        
		<td style="width: 100%; border:0;background: #fff;" height="143" border="0"><img src="../<?php echo $row_eventos['cracha_rodape'];?>" style="width:100%"/></td>
       
        
      </tr>
	  
    </tbody>
  </table>
</page>


</body>
</html>
