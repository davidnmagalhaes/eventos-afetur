<?php 
$ref = $_GET['ref'];
$idinscrito = $_GET['id_inscritos'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Captura de Foto do Inscrito</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../../images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../../vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../../vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../css/util.css">
	<link rel="stylesheet" type="text/css" href="../../css/main.css">
<!--===============================================================================================-->
<script type="text/javascript">
function actionComFoto()
{
document.formulario.action = "../../salva-foto.php";
document.formulario.submit();
}
function actionSemFoto()
{
document.formulario.action = "../../salva-foto-cracha-sem-foto.php";
document.formulario.submit();
}
function actionEtiqueta()
{
document.formulario.action = "../../salva-foto-etiqueta.php";
document.formulario.submit();
}
</script>

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('../../images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form" method="POST" action="#" id="formulario" name="formulario">
					<span class="login100-form-title p-b-49">
						Tire uma foto do inscrito
						
					</span>
					

					
					
        <div class="row">
            <div class="col-md-6 " >
                <div id="my_camera"></div>
                <br/>
                
                <input type="hidden" name="image" class="image-tag" >
				 <input type="hidden" name="idinscrito" value="<?php echo $idinscrito;?>">
				 <input type="hidden" name="ref" value="<?php echo $ref;?>">
            </div>
            <div class="col-md-6" style="padding: 10px;background-image: url('camera.jpg');background-size: 800px; border-radius: 10px;">
                <div id="results" align="center" style="color: #33afe5; font-size: 25px; font-weight: bold; text-align:center;"><span style="margin-top:  100px;">Sua foto aparecerá aqui...</span>				<p style="padding: 10px; color: #fff; font-size: 25px; font-weight: bold; text-align:center;">* A imagem utilizada será unica e exclusiva para este evento, sendo deletada de nossos registros após a finalização do evento.</p>
</div>
            </div>
            
        </div>
		<div class="row">
			<div class="col" align="center" style="margin-top: 50px">
			
			<button type="button" class="btn btn-success" onClick="take_snapshot()"><i class='fa fa-camera' style="margin-right: 10px"></i> Tirar foto</button>
			</div>
		</div>
 
					
					
					
					<div class="container-login100-form-btn" style="margin-top: 20px;">
					<div class="wrap-input100 m-b-23" data-validate = "Digite um Nickname">
						<span class="label-input100">Nome no Crachá</span>
						<input autofocus class="input100" type="text" name="nickname" placeholder="Digite um Nickname">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit" onClick="actionComFoto()">
								GERAR CRACHÁ COM FOTO
							</button>
						</div>
						<!--<div class="wrap-login100-form-btn" style="margin-top: 20px;">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit" onClick="actionSemFoto()">
								GERAR CRACHÁ SEM FOTO
							</button>
						</div>-->
						<div class="wrap-login100-form-btn" style="margin-top: 20px;">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit" onClick="actionEtiqueta()">
								GERAR ETIQUETA
							</button>
						</div>
					</div>

					
				</form>
				
				
					
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
	<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
    Webcam.set({
        width: 520,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>
	
<!--===============================================================================================-->
	<script src="../../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../../vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="../../vendor/bootstrap/js/popper.js"></script>
	<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../../vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../../vendor/daterangepicker/moment.min.js"></script>
	<script src="../../vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="../../vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="../../js/main.js"></script>

</body>
</html>