<?php
include_once("../config/conn.php");
$ref = 63693;

$name = $_POST['nomefinal'];
$email = $_POST['emailfinal'];
$cpf = $_POST['cpffinal'];
$phone = $_POST['telefonefinal'];
$totalpix = $_POST['totalboleto'];
$resultado = $_POST['resultado'];
$numberi = number_format($resultado, 2, '.', '');
$number = str_replace(',','.', $numberi);

$query = "SELECT * FROM evn_eventos WHERE ref='$ref'";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);
		
$chavepaghiper = $row_eventos['appkeypaghiper'];
$cod = date('YmdHis').rand(10,99);

$sql = "INSERT INTO evn_pedidos (id, descricao, status, nome, email, telefone, total_pedido, evento, ref, data_pedido, npedido, tipo_transacao, moeda, cpf) VALUES ('$cod','Pedido #', 1, '$name', '$email', '$phone','$number', '71ª Conferência', '$ref', NOW(), '$cod', 'PIX', 'R$', '$cpf');";

$link->multi_query($sql); 

$data = array(
  'apiKey' => $chavepaghiper,
  'order_id' => $cod, // código interno do lojista para identificar a transacao.
  'payer_email' => $email,
  'payer_name' => $name, // nome completo ou razao social
  'payer_cpf_cnpj' => $cpf, // cpf ou cnpj
  'payer_phone' => $phone, // fixou ou móvel
  'notification_url' => 'https://agenciaafetur.com.br/eventos/retorno_paghiper.php?ref='.$ref,
  //'discount_cents' => '1100', // em centavos
  //'shipping_price_cents' => '2595', // em centavos
  //'shipping_methods' => 'PAC',
  //'number_ntfiscal' => '1554123',
  'fixed_description' => true,
  'days_due_date' => '5', // dias para vencimento do Pix
  'items' => array(
      array ('description' => 'Inscrição na 71º Conferência',
      'quantity' => '1',
'item_id' => '1',
'price_cents' => $totalpix), // em centavos
),
);
$data_post = json_encode( $data );
$url = "https://pix.paghiper.com/invoice/create/";
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
// CÓDIGO 201 SIGNIFICA QUE O PIX FOI GERADO COM SUCESSO
$imagepix = $json["pix_create_request"]["pix_code"]["qrcode_image_url"];
$urlpix = $json["pix_create_request"]["pix_code"]["pix_url"];
//echo $result."<br>";
// Exemplo de como capturar a resposta json
$transaction_id = $json['create_request']['transaction_id'];
$url_slip = $json['create_request']['bank_slip']['url_slip'];
$digitable_line = $json['create_request']['bank_slip']['digitable_line'];
else:
echo $result;
endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PIX - Eventos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
</head>
<body>
<script src='https://llwhatsapp.blob.core.windows.net/whatschat-scripts/whatschat-782d22cf004f48b19b6137c2ec5a1e10.js'></script>
  <section class="container">
    <div class="row mt-5">
      <div class="col text-center">
          <h2 style="color: #36489e">Parabéns! Recebemos seu pedido de inscrição.</h2>
          <p>Realize seu pagamento via PIX utilizando o QRCODE abaixo:</p>
          <img src="<?php echo $imagepix;?>"/><br>
          <strong>URL PIX:</strong> <?php echo $urlpix;?>
      </div>
    </div>
  </section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>
</html>
