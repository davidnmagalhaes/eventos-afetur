<?php 
include_once("../config/conn.php");
require_once('../qrcode/phpqrcode/qrlib.php');

$idinscrito = $_GET['id_inscritos'];
$ref = $_GET['ref'];

$sql = "SELECT * FROM evn_inscritos WHERE id_inscritos = '$idinscrito'";
$inscritos = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_inscritos = mysqli_fetch_assoc($inscritos);
$totalRows_inscritos = mysqli_num_rows($inscritos);
$cmpadicional = $row_inscritos['cpadicional'];
$codclube = $row_inscritos['cpadicional'];

function pegaClube($campoadd){

}

$query = "SELECT * FROM evn_eventos WHERE ref='$ref'";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);
$totalRows_eventos = mysqli_num_rows($eventos);

$campoad = "SELECT * FROM evn_eventos WHERE ref = '$ref'";
$editacampoad = mysqli_query($link, $campoad) or die(mysqli_error($link));
$row_editacampoad = mysqli_fetch_assoc($editacampoad);
$totalRows_editacampoad = mysqli_num_rows($editacampoad);

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

$qr = "SELECT * FROM ".$tabelabd." WHERE id_clube= ".$codclube."";
$adicional = mysqli_query($link2, $qr) or die(mysqli_error($link2));
$row_adicional = mysqli_fetch_assoc($adicional);
$totalRows_adicional = mysqli_num_rows($adicional);

}

$sql1 = "SELECT * FROM evn_inscritos WHERE id_inscritos = '$idinscrito'";
$pedidos = mysqli_query($link, $sql1) or die(mysqli_error($link));
$row_exibe = mysqli_fetch_array($pedidos);

$qrCodeName = "imagem_qrcode_{$row_exibe['id_inscritos']}.png";

QRcode::png("http://www.agenciaafetur.com.br/eventos/checkin/proc-checkin.php?ref={$ref}&data=2020-12-03&idinscrito={$row_exibe['id_inscritos']}", $qrCodeName);
    

//Código de barras

/*function geraCodigoBarra($numero){
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
	}*/

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
  background-size: cover;
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
			<div style="width: 160px; height: 113px; background: <?php echo $row_eventos['cracha_cor_foto'];?>; margin:0 auto; padding: 5px; border-radius: 10px"><?php if($row_inscritos['imagem']==""){echo "<img src='../avatar-icon.png' width='150'/>";}else{echo "<img src='webcam/files/images/".$row_inscritos['imagem']."' width='150'/>";}?></div>
		</td>
        
        
      </tr>
	  
	  <tr>
        
		<td style="color: <?php echo $row_eventos['cracha_cor_titulo'];?>; font-family: calibri; font-size: 20px; font-weight: bold; "><?php if($row_inscritos['nickname']!=""){echo $row_inscritos['nickname'];}else{echo $row_inscritos['nome_inscrito'];}?></td>
       
        
      </tr>
	   <tr>
        
		<td style="color: <?php echo $row_eventos['cracha_cor_titulo'];?>; font-family: calibri; font-size: 20px; "><?php echo $row_adicional[$colunabd]; ?></td>
       
        
      </tr>
	  <tr >
        
		<td height="57"></td>
       
        
      </tr>
	  
	  <tr cellpadding="0" cellspacing="0" border="0">
		<td  align="center" style=" width: 100%; background: #fff;" height="100"><?php echo $row_inscritos['id_inscritos'];?><br><?php echo "<img src='{$qrCodeName}'>";?></td>
	  </tr>
	  
	  <tr cellpadding="0" cellspacing="0" border="0">
        
		<td style="width: 100%; border:0;background: #fff;" height="143" border="0"><img src="../<?php echo $row_eventos['cracha_rodape'];?>" style="width:100%"/></td>
       
        
      </tr>
	  
    </tbody>
  </table>
</page>


</body>
</html>
