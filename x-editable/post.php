<?php
require_once 'config.php';
global $con;
$query = '';

if($_POST['name']=='username'){
    $id = $_POST['pk'];
    $username = $_POST['value'];
    $result = mysqli_query($con, "SELECT id_inscritos FROM evn_inscritos WHERE id_inscritos=$id") or die(mysqli_error($con)); 
    
	if (mysqli_num_rows($result) == 0) {
       $query = "INSERT INTO evn_inscritos(id_inscritos,username) VALUES('".$id."','".$username."')"; 
    }else{
       $query = "UPDATE sample SET username='".$username."' WHERE id=$id"; 
    }
	
	
	
}
if($_POST['name']=='comments'){
    $id=$_POST['pk'];
    $comments=$_POST['value'];
    $result=mysqli_query($con, "SELECT id FROM sample WHERE id=$id") or die(mysqli_error($con));
    
	if (mysqli_num_rows($result) == 0) {
       $query = "INSERT INTO sample(id,comments) VALUES('".$id."','".$comments."')"; 
    }else{
       $query = "UPDATE sample SET comments='".$comments."' WHERE id=$id"; 
    }
}

if($_POST['name']=='country'){
    $id=$_POST['pk'];
    $country=$_POST['value'];
    $result=mysqli_query($con, "SELECT nome_clube FROM rc_clubes WHERE id_clube=$id") or die(mysqli_error($con));
	
    if (mysqli_num_rows($result) == 0) {
       $query = "INSERT INTO sample(id,country_name) VALUES('".$id."','".$country."')"; 
    }else{
      $query = "UPDATE sample SET country_name='".$country."' WHERE id=$id"; 
    }
    
}

if($_POST['name']=='dob'){
    $id=$_POST['pk'];
    $dob=$_POST['value'];
	
    $result=mysqli_query($con, "SELECT id FROM sample WHERE id=$id") or die(mysqli_error($con));
	
    if (mysqli_num_rows($result) == 0) {
       $query = "INSERT INTO sample(id,dob) VALUES('".$id."','".$dob."')"; 
    }else{
       $query = "UPDATE sample SET dob='".$dob."' WHERE id=$id"; 
    }
    
}
if($_POST['name']=='appt'){
    $id=$_POST['pk'];
    $appt=$_POST['value'];
	
    $result=mysqli_query($con, "SELECT id FROM sample WHERE id=$id") or die(mysqli_error($con));
	
    if (mysqli_num_rows($result) == 0) {
       $query = "INSERT INTO sample(id,appt) VALUES('".$id."','".$appt."')"; 
    }else{
       $query = "UPDATE sample SET appt='".$appt."' WHERE id=$id"; 
    }
    
}
if($_POST['name']=='combo'){
    $id=$_POST['pk'];
    $combo=$_POST['value'];
   	$result=mysqli_query($con, "SELECT id FROM sample WHERE id=$id") or die(mysqli_error($con));
	
    if (mysqli_num_rows($result) == 0) {
       $query = "INSERT INTO sample(id,combo_appt) VALUES('".$id."','".$combo."')"; 
    }else{
       $query = "UPDATE sample SET combo_appt='".$combo."' WHERE id=$id"; 
    }
    
}
if($_POST['name']=='email'){
    $id=$_POST['pk'];
    $email=$_POST['value'];
	$result=mysqli_query($con, "SELECT id FROM sample WHERE id=$id") or die(mysqli_error($con));
	
    if (mysqli_num_rows($result) == 0) {
       $query = "INSERT INTO sample(id,email) VALUES('".$id."','".$email."')"; 
    }else{
       $query = "UPDATE sample SET email='".$email."' WHERE id=$id"; 
    }
    
}
if($_POST['name']=='options'){
    $id=$_POST['pk'];
    $options =  !empty($_POST['value']) ? $_POST['value'] : [];
	$options = json_encode($options);
    $result=mysqli_query($con, "SELECT id FROM sample WHERE id=$id") or die(mysqli_error($con));
	
    if (mysqli_num_rows($result) == 0) {
       $query = "INSERT INTO sample(id,options) VALUES('".$id."','".$options."')"; 
    }else{
       $query = "UPDATE sample SET options='".$options."' WHERE id=$id"; 
    }
    
}
if($_POST['name']=='wy'){
    $id=$_POST['pk'];
    $text=htmlspecialchars($_POST['value']);
    $result=mysqli_query($con, "SELECT id FROM sample WHERE id=$id") or die(mysqli_error($con));
	
    if (mysqli_num_rows($result) == 0) {
       $query = "INSERT INTO sample(id,wy_text) VALUES('".$id."','".$text."')"; 
    }else{
       $query = "UPDATE sample SET wy_text='".$text."' WHERE id=$id"; 
    }
    
}


if ( !empty($query) && mysqli_query($con, $query)) {
	$status = [
		 "success" => true,
		"message" => "Record updated successfully"
	];
} else {

	$status = [
		 "success" => false,
		"message" => "Error updating record: " . mysqli_error($con)
	];

}
echo json_encode($status);exit;



?>