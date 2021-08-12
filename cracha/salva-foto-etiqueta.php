<?php
include_once("../config/conn.php");

$idinscrito = $_POST['idinscrito'];
$ref = $_POST['ref'];
$nickname = $_POST['nickname'];

$sql = "SELECT * FROM evn_inscritos WHERE id_inscritos = '$idinscrito'";
$inscritos = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_inscritos = mysqli_fetch_assoc($inscritos);
$totalRows_inscritos = mysqli_num_rows($inscritos);

$img = $_POST['image'];
    $folderPath = "webcam/files/images/";
	
  
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = date("YmdHis").rand(10,99) . '.png';
  
    $file = $folderPath . $fileName;
	
	$result_usuario = "UPDATE evn_inscritos SET nickname='$nickname', imagem = '$fileName' WHERE id_inscritos='$idinscrito';";
	
	if ($link->multi_query($result_usuario) === TRUE) {
		 file_put_contents($file, $image_base64);
		 header("Location: emitir-etiqueta.php?id_inscritos=".$idinscrito."&ref=".$ref);
	} else {
		echo "Error: " . $result_usuario . "<br>" . $link->error;
	}
?>