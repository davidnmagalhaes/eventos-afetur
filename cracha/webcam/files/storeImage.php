<?php
    require_once('config.php');
	
    $img = $_POST['image'];
    $folderPath = "images/";
	
  
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.png';
  
    $file = $folderPath . $fileName;
	
	$result_usuario = "INSERT INTO webcams (imagem) VALUES ('$fileName');";
	
	if ($con->multi_query($result_usuario) === TRUE) {
		 file_put_contents($file, $image_base64);
	} else {
		echo "Error: " . $result_usuario . "<br>" . $con->error;
	}

	$link->close();
   
  
    //print_r($fileName);
  
?>