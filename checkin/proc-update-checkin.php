<?php
session_start();

if((empty($_SESSION['iduser'])) || (empty($_SESSION['usuario'])) || (empty($_SESSION['nivel']))){       
            $_SESSION['loginErro'] = "Área restrita";
            header("Location: index.php");
        }else{
            if($_SESSION['nivel'] != "3"){
                $_SESSION['loginErro'] = "Área restrita";
                header("Location: index.php");
            }
			
        }

include_once ('../config/conn.php');


 $id = $_POST['pedido'];
 $ref = $_POST['ref'];
 $data = date('Y-m-d',strtotime($_POST['data']));
 $ativo = 1;
 
 
$query = "SELECT * FROM evn_inscritos WHERE id_inscritos = '$id';";
$checkin = mysqli_query($link, $query) or die(mysqli_error($link));
$row_checkin = mysqli_fetch_assoc($checkin);

$qr = "SELECT * FROM evn_datas_checkin WHERE id_inscrito = '$id';";
$chec = mysqli_query($link, $qr) or die(mysqli_error($link));
$row_chec = mysqli_fetch_assoc($chec);

    $check=mysqli_query($link,"select * from evn_datas_checkin where id_inscrito='$id' AND data='$data'");
	$checkrows=mysqli_num_rows($check);
	
	if($row_checkin['voucher'] == 1 && $checkrows<1){
		$sql = "INSERT INTO evn_datas_checkin (data, checkin, id_inscrito) VALUES ('$data', '$ativo', '$id');";
		$link->multi_query($sql);
		header("Location: configura-certificado.php?ref=".$ref."&id_inscrito=".$id."&data=".$data);
	}else{
		header("Location: ../paginaserro/erro-check-in.php?ref=".$ref."&data=".$data);
	}
 
 ?>