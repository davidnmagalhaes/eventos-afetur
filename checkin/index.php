<?php 
require_once('../config/conn.php');

$ref = $_GET['ref'];
$idinscrito = $_GET['idinscrito'];
$data = date('Y-m-d',strtotime($_GET['data']));

if(!empty($_GET['pedido'])){
	$teste = explode('0',$_GET['pedido']);
	if(strlen($teste[1]) == 3){
		$pesquisar = $teste[1];
	}else{
		$pesquisar = $_GET['pedido'];
	}

$result_cursos = "SELECT * FROM evn_inscritos INNER JOIN evn_pedidos ON evn_inscritos.pedido = evn_pedidos.id WHERE pedido LIKE '%$pesquisar%' AND evn_pedidos.ref = '$ref' AND (evn_pedidos.status = 3 OR evn_pedidos.status = 14 OR evn_pedidos.status = 4)";
$resultado_cursos = mysqli_query($link, $result_cursos);
}elseif(!empty($_GET['inscrito'])){
$pesquisar = $_GET['inscrito'];
$result_cursos = "SELECT * FROM evn_inscritos INNER JOIN evn_pedidos ON evn_inscritos.pedido = evn_pedidos.id WHERE nome_inscrito LIKE '%$pesquisar%' AND evn_pedidos.ref = '$ref' AND (evn_pedidos.status = 3 OR evn_pedidos.status = 14 OR evn_pedidos.status = 4)";
$resultado_cursos = mysqli_query($link, $result_cursos);
}else{}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Fazer check-in</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
<link rel="alternate" href="https://qrbot.net/x-callback-url/scan?x-success=https%3A%2F%2Fyourwebsite.com" />
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form" id="formulario" method="POST" action="proc-update-checkin.php">
					<span class="login100-form-title p-b-49">
						FAZER CHECK-IN
						<p><a href="../lista-inscritos.php?ref=<?php echo $ref;?>">Voltar para lista de inscritos...</a></p>
					</span>
					

					<div class="wrap-input100 m-b-23" data-validate = "Digite o número do pedido">
						<span class="label-input100">Código do Inscrito</span>
						<input autofocus class="input100" type="text" name="pedido" placeholder="Faça a leitura do código de barras" value="<?php echo $idinscrito;?>">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					
					
					<input type="hidden" name="ref" value="<?php echo $ref;?>">
					<input type="hidden" name="data" value="<?php echo $data;?>">
					<div class="container-login100-form-btn" style="margin-top: 20px;">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit">
								VERIFICAR
							</button>
						</div>
					</div>

					
				</form>
				
				
					
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	<?php if(empty($idinscrito)){}else{?>
	<script>
	window.onload = function(){
  document.forms['formulario'].submit();
}
	</script>
	<?php } ?>
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>