<?php 
include("valida_pagina.php");
		
$ref = $_GET['ref'];

$query = "SELECT * FROM evn_eventos";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <title>Boletos - Afetur Eventos</title>
	<?php include('head.php');?>
</head>
<body>
       
	   <?php
		require('nav-main.php');
	   ?>

	<div class="container content" style="min-height: 780px;">
			<h3 style="margin-top: 20px; margin-left: 20px;"><i class="fas fa-money-check-alt"></i> <strong>Boletos</strong></h3>
			<form method="get" action="listar-boletos-filtro.php">
			<div class="row" style="margin: 30px 0;">
				<div class="col">
					<label>Data inicial:</label>
					<input type="date" class="form-control" name="datainicio">
						
				</div>
				<div class="col">
					<label>Data final:</label>
					<input type="date" class="form-control" name="datafinal">
						
				</div>
				<div class="col">
					<label>Status:</label>
					<select name="status" class="form-control">
					<option value=""></option>
						<option value="pending">Aguardando</option>
						<option value="reserved">Reservado</option>
						<option value="canceled">Cancelado</option>
						<option value="paid">Aprovado e completo</option>
						<option value="processing">Análise</option>
						<option value="refunded">Estornado</option>
					</select>
						
				</div>
				<div class="col">
					<label>Pesquisar por:</label>
					<select name="tipo" class="form-control">
					<option value=""></option>
						<option value="create_date">Data do pedido</option>
						<option value="paid_date">Data do pagamento</option>
					</select>
						
				</div>
				<div class="col">
					
					<br>
				  <button type="submit" class="btn btn-success">Pesquisar</button>
				  
				</div>
			</div>
			
			
			<div class="row">
			
				<div class="col">
<?php 
$data = array(
  'token' => 'UPPKDVD16ZGBGPXTABA6UV3O65FYPY7KOX51SI2ZIJAY',
  'apiKey' => 'apk_43446523-sXFMllcpWlejgCLeYfDmDvQVqbEGcFYV',
  //'initial_date' => '2019-05-17',
  //'final_date' => '2019-06-25',
  //'filter_date' => 'paid_date',
  //'status' => 'paid',
  'page' => '1',
);
$data_post = json_encode( $data );
$url = "http://api.paghiper.com/transaction/list/";
$mediaType = "application/json"; // formato da requisição
$charSet = "UTF-8";
$headers = array();
$headers[] = "Accept: ".$mediaType;
$headers[] = "Accept-Charset: ".$charSet;
$headers[] = "Accept-Encoding: ".$mediaType;
$headers[] = "Content-Type: ".$mediaType.";charset=".$charSet;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
$json = json_decode($result, true);
// captura o http code
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($httpCode == 201):
// CÓDIGO 201 SIGNIFICA QUE O BOLETO FOI GERADO COM SUCESSO
//echo $result;

// Exemplo de como capturar a resposta json
$pedido = $json['transaction_list_request']['transaction_list'];
$url_slip = $json['create_request']['bank_slip']['url_slip'];
$digitable_line = $json['transaction_list_request']['bank_slip']['digitable_line'];


$resulta = $pedido;


foreach($resulta as $key => $rs){
	
//$pd = explode(' ',$rs["order_id"]);

//echo $pd[0]; //pedido
//echo $pd[3]; //parcela
//echo $pd[5]; //parcela final
	
	echo '<div class="accordion" id="accordionExample">';
	echo '<div class="card">
    <div class="card-header" id="heading'.$key.'">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse'.$key.'" aria-expanded="false" aria-controls="collapse'.$key.'">
		<strong>Pedido:</strong> '.$rs["order_id"].'
		</button>
      </h5>
    </div>
	
	<div id="collapse'.$key.'" class="collapse" aria-labelledby="heading'.$key.'" data-parent="#accordionExample">
      <div class="card-body">
		';
	
	echo "<table class='table table-striped'>";
	echo "<thead class='thead-dark'><tr><th colspan='2'><strong>Pedido:</strong> ".$rs['order_id']."<br></th></tr></thead>";
	echo "<tr><td><strong>ID da Transação:</strong></td><td> ".$rs['transaction_id']."<br></td></tr>";
	echo "<tr><td><strong>Data do pedido:</strong> </td><td>".date("d/m/Y",strtotime($rs['create_date']))."<br></td></tr>";
	echo "<tr><td><strong>Status:</strong> </td><td>"; 
	if($rs['status'] == 'refunded'){ echo '<span style="color: #3d3abb; font-weight: bold;">Estornado</span>';};
	if($rs['status'] == 'pending'){ echo '<span style="color: #ea7722; font-weight: bold;">Aguardando</span>';}; 
	if($rs['status'] == 'reserved'){ echo '<span style="color: #ef2cd5; font-weight: bold;">Reservado</span>';};
	if($rs['status'] == 'canceled'){ echo '<span style="color: #e21d1d; font-weight: bold;">Cancelado</span>';};
	if($rs['status'] == 'paid'){ echo '<span style="color: #17a51c; font-weight: bold;">Aprovado</span>';};
	if($rs['status'] == 'completed'){ echo '<span style="color: #17a51c; font-weight: bold;">Completo</span>';};
	if($rs['status'] == 'processing'){ echo '<span style="color: #d6b610; font-weight: bold;">Em análise</span>';}; echo "<br></td></tr>";
	echo "<tr><td><strong>Último status:</strong> </td><td>".date("d/m/Y H:i",strtotime($rs['status_date']))."<br></td></tr>";
	echo "<tr><td><strong>Vencimento do Boleto:</strong> </td><td>".date("d/m/Y",strtotime($rs['due_date']))."<br></td></tr>";
	echo "<tr><td><strong>E-mail do cliente:</strong> </td><td>".$rs['payer_email']."<br></td></tr>";
	echo "<tr><td><strong>Nome do Pagador:</strong> </td><td>".$rs['payer_name']."<br></td></tr>";
	echo "<tr><td><strong>CPF/CNPJ:</strong> </td><td>".$rs['payer_cpf_cnpj']."<br></td></tr>";
	echo "<tr><td><strong>Telefone:</strong> </td><td>".$rs['payer_phone']."<br></td></tr>";
	echo "<tr><td><strong>Data de Aprovação:</strong> </td><td>".date("d/m/Y H:i",strtotime($rs['paid_date']))."<br></td></tr>";
	echo "<tr><td><strong>Valor:</strong></td><td> R$ ".number_format($rs['value_cents']/100, 2 ,',','')."<br></td></tr>";
	echo "<tr><td><strong>Código de Barras:</strong> </td><td><input class='form-control' value='".$rs['bank_slip']['digitable_line']."'/><br></td></tr>";
	echo "<tr><td colspan='2'><strong>Boleto PDF:</strong> <a href='".$rs['bank_slip']['url_slip_pdf']."' target='_blank'><img src='img/icone_boleto.png' width='100'/></a><br><br></td></tr>";
	echo "</table>";
	echo '</div>
    </div>
  </div>';
}
echo '<div class="row justify-content-md-center" style="margin: 30px 0;"><div class="col-2" style="text-align:center;"><label><strong>Página:</strong></label><input type="number" name="page" class="form-control" style="text-align:center" onChange="this.form.submit()" placeholder="Número da página" min="1" max="999" value="1" /></div></div></form>';
else:
//Esse trecho acessa a URL do boleto e exibe o conteudo na pagina, de acordo com a quantidade de parcelas, na hora da impressão ja gera a paginação.
     //echo $result;   
	 echo "Não há resultados para o filtro realizado. Tente novamente selecionando outro filtro.";
endif;

?>

		

</div>
			</div>
	</div>  
	   <?php include_once("footer.php");?>
	   
	
   </body>
</html>