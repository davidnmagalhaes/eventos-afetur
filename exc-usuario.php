<?php
require('config/conn.php');

$id = $_POST['id'];

if($id > 0){

  // Check record exists
  $checkRecord = mysqli_query($link,"SELECT * FROM evn_usuario WHERE cod_usuario=".$id);
  $totalrows = mysqli_num_rows($checkRecord);

  if($totalrows > 0){
    // Delete record
    $query = "DELETE FROM evn_usuario WHERE cod_usuario=".$id;
    mysqli_query($link,$query);
    echo 1;
    exit;
  }
}

echo 0;
exit;
	

?>