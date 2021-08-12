<?php
$ref = $_GET['ref'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Sucesso no Cadastro!</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:700,900" rel="stylesheet">

	<!-- Font Awesome Icon -->
	<link type="text/css" rel="stylesheet" href="css/font-awesome.min.css" />

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="css/style.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<script type="text/javascript">
var ss = -1;
function atualizaContador(futuro) 
{
  ss = (ss==-1) ? futuro : ss;
  var faltam =  'Você será redirecionado em '+ss+' segundos.';

  if (ss > 0) {
	document.getElementById('contador').innerHTML = faltam;
	ss--;
	setTimeout(atualizaContador,1000);	
  } else {
	location.href="../lista-inscritos.php?ref=<?php echo $ref;?>";
  }
}
</script>

</head>

<body onLoad="atualizaContador(7);">

	<div id="notfound">
		<div class="notfound-bg"></div>
		<div class="notfound">
			<div class="notfound-404">
				<h1>Ok!</h1>
			</div>
			<h2>"Evento cadastrado com sucesso!"</h2>
			<h2 id="contador" style="color: #000"> </h2>
			<a href="../eventos.php" class="home-btn">Ou clique para continuar</a>
			
			
		</div>
	</div>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
