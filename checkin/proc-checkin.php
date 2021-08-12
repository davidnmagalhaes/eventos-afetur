<?php

include_once ('../config/conn.php');

 $id = $_GET['idinscrito'];
 $ref = $_GET['ref'];
 $data = date('Y-m-d',strtotime($_GET['data']));
 $datarelatorio = date('Y-m-d H:i:s');
 $ativo = 1;
 
/*$query = "SELECT * FROM evn_inscritos WHERE id_inscritos = '$id';";
$checkin = mysqli_query($link, $query) or die(mysqli_error($link));
$row_checkin = mysqli_fetch_assoc($checkin);

$qr = "SELECT * FROM evn_datas_checkin WHERE id_inscrito = '$id';";
$chec = mysqli_query($link, $qr) or die(mysqli_error($link));
$row_chec = mysqli_fetch_assoc($chec);

    $check=mysqli_query($link,"select * from evn_datas_checkin where id_inscrito='$id' AND data='$data'");
	$checkrows=mysqli_num_rows($check);
	
	if($row_checkin['voucher'] == 1 && $checkrows<1){*/
		$sql = "INSERT INTO evn_datas_checkin (data, checkin, id_inscrito) VALUES ('$data', '$ativo', '$id');";
		$sql = "INSERT INTO evn_relatorio (id_inscrito, ref_evento, data_relatorio) VALUES ('$id', '$ref', '$datarelatorio');";
		$link->multi_query($sql);
		header("Location: configura-certificado.php?ref=".$ref."&id_inscrito=".$id."&data=".$data);
	/*}else{
		header("Location: ../paginaserro/erro-check-in.php?ref=".$ref."&data=".$data);
	}*/
 
 ?>