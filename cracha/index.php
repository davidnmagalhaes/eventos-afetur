<?php 
require_once('../config/conn.php');

$ref = $_GET['ref'];
$URL_ATUAL= "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$urlcorreta = "https://agenciaafetur.com.br/eventos/cracha".$ref;

if($URL_ATUAL == $urlcorreta){
	$liberadiretorio = "cracha/";
}else{
	$liberadiretorio = "";
}

$ref = $_GET['ref'];
$pedido = $_GET['pedido'];
$inscrito = $_GET['inscrito'];
$email = $_GET['email'];

if(!empty($pedido) && empty($inscrito) && empty($email)):
	$result_cursos = "SELECT * FROM evn_inscritos WHERE pedido='$pedido'";
	$resultado_cursos = mysqli_query($link, $result_cursos);
endif;

if(empty($pedido) && !empty($inscrito) && empty($email)):
	$result_cursos = "SELECT * FROM evn_inscritos WHERE nome_inscrito LIKE '%$inscrito%'";
	$resultado_cursos = mysqli_query($link, $result_cursos);
endif;

if(empty($pedido) && empty($inscrito) && !empty($email)):
	$result_cursos = "SELECT * FROM evn_inscritos WHERE email_inscrito = '$email'";
	$resultado_cursos = mysqli_query($link, $result_cursos);

endif;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Emissão de Crachá</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?php echo $liberadiretorio;?>images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $liberadiretorio;?>vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $liberadiretorio;?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $liberadiretorio;?>fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $liberadiretorio;?>vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo $liberadiretorio;?>vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $liberadiretorio;?>vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $liberadiretorio;?>vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo $liberadiretorio;?>vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $liberadiretorio;?>css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $liberadiretorio;?>css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('<?php echo $liberadiretorio;?>images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form" method="GET" action="<?php echo $liberadiretorio;?>index.php">
					<span class="login100-form-title p-b-49">
						<a href="<?php echo 'https://agenciaafetur.com.br/eventos/cracha'.$ref; ?>" style="font-size: 35px; color: #000; font-weight: bold;">Emissão de Crachá</a>
						
					</span>
					

					<div class="wrap-input100 m-b-23" data-validate = "Digite o número do pedido">
						<span class="label-input100">Número do pedido</span>
						<input autofocus class="input100" type="text" name="pedido" placeholder="Digite o número do pedido">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100" data-validate="Digite o nome do inscrito">
						<span class="label-input100">Nome</span>
						<input class="input100" type="text" name="inscrito" placeholder="Digite o nome do inscrito">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100" data-validate="Digite o nome do inscrito" style="margin-top: 25px;">
						<span class="label-input100">E-mail</span>
						<input class="input100" type="email" name="email" placeholder="Digite o e-mail de inscrição">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>
					
					<input type="hidden" name="ref" value="<?php echo $ref;?>">
					
					<div class="container-login100-form-btn" style="margin-top: 20px;">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit">
								Pesquisar
							</button>
						</div>
					</div>

					
				</form>
				
				<div class="row">
					<div class="col">
					<?php if(empty($_GET['pedido']) && empty($_GET['inscrito']) && empty($_GET['email'])){echo "";}else{?>
					<?php 
						echo "<h3 style='margin-top: 25px'><strong>Selecione o inscrito...</strong></h3>";
						while($row_resultado = mysqli_fetch_array($resultado_cursos)){
							
							$npedido = $row_resultado['pedido'];
							$sqlpedido = "SELECT * FROM evn_pedidos WHERE id='$npedido' AND ref = '$ref'";
							$resultado_pedido = mysqli_query($link, $sqlpedido);
							$row_resultadopedido = mysqli_fetch_array($resultado_pedido);
							
							$statuspedido = $row_resultadopedido['status'];
						
							if($statuspedido==3 || $statuspedido==4){
							echo "<div class='row' style='margin-top: 20px'><div class='col-8'><a href='webcam/files/index.php?id_inscritos=".$row_resultado['id_inscritos']."&ref=".$ref."' target='_blank' data-toggle='modal' data-target='.bd-example-modal-lg'>".$row_resultado['nome_inscrito']."</a></div><div class='col-2'>";
						
							
					?>
					<a class="btn btn-success" href="webcam/files/index.php?id_inscritos=<?php echo $row_resultado['id_inscritos']."&ref=".$ref ?>" target="_blank" role="button"><i class="fa fa-user" style="margin-right: 10px; color: #fff;"></i> Emitir</a>
					<?php
					echo "</div></div>"; 
				}
}}
					?>
					</div>
				</div>
					
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="<?php echo $liberadiretorio;?>vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $liberadiretorio;?>vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $liberadiretorio;?>vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo $liberadiretorio;?>vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $liberadiretorio;?>vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $liberadiretorio;?>vendor/daterangepicker/moment.min.js"></script>
	<script src="<?php echo $liberadiretorio;?>vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $liberadiretorio;?>vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $liberadiretorio;?>js/main.js"></script>

</body>
</html>