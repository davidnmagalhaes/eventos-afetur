<?php 
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

include_once("config/conn.php");

$idinscrito = $_GET['id_inscritos'];
$ref = $_GET['ref'];

$sql = "SELECT * FROM evn_inscritos WHERE id_inscritos = '$idinscrito'";
$inscritos = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_inscritos = mysqli_fetch_assoc($inscritos);
$totalRows_inscritos = mysqli_num_rows($inscritos);

$query = "SELECT * FROM evn_eventos WHERE ref = '$ref'";
$evento = mysqli_query($link, $query) or die(mysqli_error($link));
$row_evento = mysqli_fetch_assoc($evento);
$totalRows_evento = mysqli_num_rows($evento);

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Fortaleza');

?>

<html>
<head>
<meta charset="UTF-8"/>
<title>Certificado</title>
</title>
<style>
body {
  background: rgb(204, 204, 204);
}

page {
  background: url("certificado/bg-certificado.jpg");
  background-size: 29.7cm 21cm;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
}

page[size="A4"] {
  width: 29.7cm;
  height: 21cm;
}

page[size="A4"][layout="landscape"] {
  width: 21cm;
  height: 29.7cm;
}

@media print {
  body,
  page {
	 -webkit-print-color-adjust: exact; 
	 background: url("certificado/bg-certificado.jpg");
	 background-size: 29.7cm 21cm;
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
    <thead>
      <tr>
        <th colspan="3" style="height: 5cm;"></th>
        
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="width: 3cm; height: 1.5cm;"></td>
		<td></td>
        <td rowspan="3" scope="row" style="width: 9.50cm; text-align:left; padding-left: 50px;"><img src="<?php echo $row_evento['logo'];?>" width="160"/></td>
        
      </tr>
      <tr>
        <td></td>
		<td style="font-family: calibri; font-size: 14px; height: 2cm;">O <?php echo $row_evento['organizador_nome'];?> confere a</td>
        
        
      </tr>
      <tr>
        <td style="height: 1.5cm;"></td>
		<td></td>
        
        
      </tr>
	  <tr>
        <td style="height: 2.00cm;"></td>
		<td style="font-family: calibri; font-size: 35px; font-weight: bold;"><?php echo $row_inscritos['nome_inscrito'];?></td>
        <td></td>
        
      </tr>
	  <tr>
        <td style="height: 2.5cm;"></td>
		<td style="font-family: calibri; font-size: 35px; font-weight: bold;"></td>
        <td></td>
        
      </tr>
      <tr>
      <td></td>
      <td style="font-family: calibri; font-size: 18px; vertical-align:top;">o certificado de participação no evento <?php echo $row_evento['nome_evento'];?></td>
      </tr>
	  <tr>
      
        <td style="height: 2.5cm; "></td>
		<td style="font-family: calibri; font-size: 18px; vertical-align:top;margin-top: 50px">Fortaleza, <?php echo strftime('%d de %B de %Y', strtotime('today')); ?></td>
   
        
      </tr>
	  
    </tbody>
  </table>
</page>


</body>
</html>
