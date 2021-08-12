<?php	

	include_once("../config/conn.php");
	$html = '<table border="1"';	
	$html .= '<thead>';
	$html .= '<tr>';
	$html .= '<th>ID</th>';
	$html .= '<th>COD Transação</th>';
	$html .= '<th>Tipo de Pagamento</th>';
	$html .= '<th>Status da Transação</th>';
	$html .= '<th>E-mail</th>';
	$html .= '</tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	
	
	$result_transacoes = "SELECT * FROM evn_pedidos LIMIT 5";
	$resultado_trasacoes = mysqli_query($link, $result_transacoes);
	while($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)){
		$html .= '<tr><td>'.$row_transacoes['id'] . "</td>";
		$html .= '<td>'.$row_transacoes['nome'] . "</td>";
		$html .= '<td>'.$row_transacoes['email'] . "</td>";
		$html .= '<td>'.$row_transacoes['evento'] . "</td>";
		$html .= '<td>'.$row_transacoes['total_pedido'] . "</td></tr>";		
	}
	
	$html .= '</tbody>';
	$html .= '</table';
$html .= '<div style="width: 500px; height: 500px; border:1px solid #ff0000; background-image: url("https://cwsmgmt.corsair.com/newscripts/landing-pages/wallpaper/v4/Wallpaper-v4-1920x1080.jpg");">teste</div>';
		$html .= '<img src="https://cwsmgmt.corsair.com/newscripts/landing-pages/wallpaper/v4/Wallpaper-v4-1920x1080.jpg"/>';

	//referenciar o DomPDF com namespace
	use Dompdf\Dompdf;

	// include autoloader
	require_once("dompdf/autoload.inc.php");

	//Criando a Instancia
	$dompdf = new DOMPDF();
	
	// Carrega seu HTML
	$dompdf->load_html('
			<h1 style="text-align: center;">Celke - Relatório de Transações</h1>
			'. $html .'
		');
	$dompdf->setPaper('A4', 'landscape');
	$dompdf->set_option('defaultFont', 'Calibri');

	//Renderizar o html
	$dompdf->render();

	//Exibibir a página
	$dompdf->stream(
		"relatorio_celke.pdf", 
		array(
			"Attachment" => false //Para realizar o download somente alterar para true
		)
	);
?>