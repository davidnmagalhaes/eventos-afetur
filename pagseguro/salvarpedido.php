<?php
 
 include_once 'conecta.php';
 $conn = new conecta();
 
 $conn->salvarPedido();
 

 $pedido = $conn->consultarUltimoPedido();


 $ped = $pedido["id"];
 
 
 echo $pedido["id"];
		

 

?>
