<?php 


include_once("config/conn.php");

		$ref = $_POST['ref'];
		
		$query = "SELECT * FROM evn_eventos WHERE ref='$ref'";
		$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
		$row_eventos = mysqli_fetch_assoc($eventos);
		
		$chavepaghiper = $row_eventos['appkeypaghiper'];
		
		// Variáveis dos ingressos
		$ingresso = $_POST['ingresso'];
		$valor = $_POST['valor'];
		$quantidade = $_POST['quantidade'];
		
		$pvenc = $_POST['pvenc'];
		
		$nome = $_POST['nome'];
		$resultado = $_POST['resultado'];
		$email = $_POST['email'];
		$evento = $_POST['evento'];
		
		$campoadicional = $_POST['campoadicional'];
		$numberi = number_format($resultado, 2, '.', '');
		$number = str_replace(',','.', $numberi);
		$npedido = substr(uniqid(rand()), 0, 5);
		$ningresso = substr(uniqid(rand()), 0, 5);
		$cod = $_POST['cod'];
		$tipotransacao = "Boleto";
		$totalboleto = $_POST['totalboleto'];
		$cpf = $_POST['cpf'];
		$telefone = $_POST['telefone'];
		
		
		

// Código para emitir boleto no Paghiper
$qtdparcelas = $_POST['parcelas'];
$divideparcela = $totalboleto / $qtdparcelas;

$parcela = 0; // Não Alterar DEVE SEMPRE INICIAR EM 0 
$parcelaf = $qtdparcelas; // numero de parcelas que deseja o carne
$dataHoje = date('Y-m-d'); //não alterar, busca a data atual
$diavencimento = date('Y-m-d', strtotime($pvenc)); // Data do vencimento da primeira parcela, em formato Universal Y-M-D
while ($parcela < $parcelaf): // laço que calcula a quantidade de vezes que deve requisitar os boletos.
    if ($parcela > 0):
        $novovencimento = date('Y-m-d', strtotime('+ ' . $parcela . ' months', strtotime($diavencimento)));
    else:
        $novovencimento = $diavencimento;
    endif;
    $parcelan = $parcela + 1; // $parcelan serve para exibir corretamente o numero de parcelas do carne.
    $data1 = new DateTime($novovencimento);
    $data2 = new DateTime($dataHoje);

    $intervalo = $data1->diff($data2); // CALCULA A DIFERENÇA DE DATAS, PARA TRAZER O RESULTADOS EM DIAS CORRIDOS
    $vencimentoBoleto = $intervalo->days;

$data = array(
  'apiKey' => $chavepaghiper,
  'order_id' => $cod.' - Parcela '.$parcelan.' de '.$parcelaf, // código interno do lojista para identificar a transacao.
  'payer_email' => $email[0],
  'payer_name' => $nome[0], // nome completo ou razao social
  'payer_cpf_cnpj' => $cpf, // cpf ou cnpj
  'payer_phone' => $telefone, // fixou ou móvel
  //'payer_street' => 'Av Brigadeiro Faria Lima',
  //'payer_number' => '1461',
  //'payer_complement' => 'Torre Sul 4º Andar',
  //'payer_district' => 'Jardim Paulistano',
  //'payer_city' => 'São Paulo',
  //'payer_state' => 'SP', // apenas sigla do estado
  //'payer_zip_code' => '01452002',
  'notification_url' => 'http://www.distrito4490conferenciaagersontabosa.com/eventos/retorno_paghiper.php',
  'discount_cents' => '0', // em centavos
  'shipping_price_cents' => '0', // em centavos
  //'shipping_methods' => 'PAC',
  'fixed_description' => true,
  'type_bank_slip' => 'boletoCarne', // formato do boleto
  'days_due_date' => $vencimentoBoleto, // dias para vencimento do boleto
  'late_payment_fine' => '2',// Percentual de multa após vencimento.
  'per_day_interest' => true, // Juros após vencimento.
  'items' => array(
      array ('description' => 'Pedido: #'.$cod,
      'quantity' => '1',
'item_id' => '1',
'price_cents' => $divideparcela), // em centavos

),
);
$data_post = json_encode( $data );
$url = "http://api.paghiper.com/transaction/create/";
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
$transaction_id = $json['create_request']['transaction_id'];
$url_slip = $json['create_request']['bank_slip']['url_slip'];
$digitable_line = $json['create_request']['bank_slip']['digitable_line'];
$url_slip_pdf = $json['create_request']['bank_slip']['url_slip'];
echo "<a href='".$url_slip_pdf."/pdf' target='_blank'><strong>Visualizar PDF</strong></a>";
echo $resulta = file_get_contents($url_slip);
else:
//Esse trecho acessa a URL do boleto e exibe o conteudo na pagina, de acordo com a quantidade de parcelas, na hora da impressão ja gera a paginação.
     echo $result;   
	 echo "Infelizmente estamos com uma instabilidade em nossa emiss&atilde;o de boletos online, tente mais tarde ou ligue (85) 3048-1900. Se preferir poder&aacute; efetuar seu pagamento via Cart&atilde;o de Cr&eacute;dito. Tamb&acute;m sugerimos que tente por outro navegador. Obrigado!";
endif;

$parcela ++; // incrementa a contagem de parcelas, para que assim o laço se encerre na quantidade certa de parcelas 
endwhile; // fim do laço
?>

		

