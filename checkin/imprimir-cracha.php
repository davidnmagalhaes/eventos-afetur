<?php 
include_once("../config/conn.php");

$idinscrito = $_GET['id_inscritos'];

$sql = "SELECT * FROM evn_inscritos WHERE id_inscritos = '$idinscrito'";
$inscritos = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_inscritos = mysqli_fetch_assoc($inscritos);
$totalRows_inscritos = mysqli_num_rows($inscritos);

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
  background: #fff;
  background-size: 10cm 7cm;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
}

page[size="A4"] {
  width: 7cm;
  height: 10cm;
}

page[size="A4"][layout="landscape"] {
  width: 7cm;
  height: 10cm;
}

@media print {
  body,
  page {
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

  <table class="table">
    
    <tbody>
      
      
      <tr>
        <td style="height: 0.00cm;"></td>
		<td style="font-family: calibri; font-size: 35px; font-weight: bold;"><img src="http://www.distrito4490conferenciaagersontabosa.com/eventos/img-eventos/Wed-May-20191571469-CONFERENCIA-ROTARY-2.png" width="150"/></td>
        <td></td>
        
      </tr>
	  
	  <tr>
        <td style="height: 2.00cm;"></td>
		<td style="color: #000; font-family: calibri; font-size: 20px; font-weight: bold;"><?php echo $row_inscritos['nome_inscrito'];?></td>
        <td></td>
        
      </tr>
	  <tr>
        <td style="height: 2.00cm;"></td>
		<td style="color: #fff; font-family: calibri; font-size: 20px; font-weight: bold;"><?php echo $row_inscritos['nome_inscrito'];?></td>
        <td></td>
        
      </tr>
	  <tr>
		<td colspan="3" align="center" style="background: #fff; width: 100%"><?php geraCodigoBarra($row_inscritos['id_inscritos']); ?></td>
	  </tr>
	  
    </tbody>
  </table>
</page>


</body>
</html>
