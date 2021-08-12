<?php
include_once("../config/conn.php");

$sql = "SELECT * FROM evn_inscritos";
$editaevento = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_editaevento = mysqli_fetch_assoc($editaevento);
$totalRows_editaevento = mysqli_num_rows($editaevento);

?>


<!DOCTYPE html>
<html>
<head>
	<title>Exemplo Autocomplete com AJAX + PHP + MySQL</title>
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="jquery-ui.min.css">
</head>
<body>
	<div class='container'>
		<header class="row">
			<h1 class='text-center text-primary'>Autocomplete com jQuery UI + PHP + MySQL</h1>
		</header>	

		<br>
		<div class="row">
			<div class="form-group col-md-6 col-md-offset-3">
			    <input type="text" class="form-control" id="busca" placeholder="Informe o Título do Livro">
			</div>
		</div>

		</div>
	</div>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="jquery-ui.min.js"></script>
	<script type="text/javascript" src="custom.js"></script>
</body>
</html>