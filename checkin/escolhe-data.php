<?php 
require_once('../config/conn.php');

$ref = $_GET['ref'];

$query = "SELECT * FROM evn_eventos WHERE ref='$ref'";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);

$diascheckin = $row_eventos['dias_checkin'];
$datainicio = $row_eventos['data_inicio'];
$datafinal = $row_eventos['data_final'];

$d1 = $datainicio;
$d2 = $datafinal;

$timestamp1 = strtotime( $d1 );
$timestamp2 = strtotime( $d2 );



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
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form" method="POST" action="proc-search.php">
					<span class="login100-form-title p-b-49">
						ESCOLHA O DIA...
						<p><a href="../lista-inscritos.php?ref=<?php echo $ref;?>">Voltar para lista de inscritos...</a></p>
					</span>
					

					
					<div class="row">
						<div class="col" style="text-align:center;">
					<?php 
						$cont = 1;
						while ( $timestamp1 <= $timestamp2 )
						{
						echo '<a class="btn btn-primary" style="margin-bottom: 5px;" href="index.php?ref='.$ref.'&data='.date( 'Y-m-d', $timestamp1 ) . PHP_EOL.'" role="button">'.date( 'd/m/Y', $timestamp1 ) . PHP_EOL ."</a><br>";
						$timestamp1 += 86400;
						$cont++;
						}﻿
					?>
						</div>
					</div>
					
					
					

					
				</form>
				
				
					
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
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