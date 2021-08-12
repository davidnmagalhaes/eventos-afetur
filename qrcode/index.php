<?php 
require_once('phpqrcode/qrlib.php');
include('../config/conn.php');

$sql = "SELECT * FROM evn_pedidos WHERE ref='15714'";
$pedidos = mysqli_query($link, $sql) or die(mysqli_error($link));

foreach ($pedidos as $value) {
    $npedido = $value['id'];
    $query = "SELECT * FROM evn_inscritos WHERE pedido='$npedido'";
    $exibe = mysqli_query($link, $query) or die(mysqli_error($link));
    $row_exibe = mysqli_fetch_array($exibe);

    $qrCodeName = "imagem_qrcode_{$row_exibe['id_inscritos']}.png";

    QRcode::png("http://www.agenciaafetur.com.br/{$row_exibe['id_inscritos']}", $qrCodeName);
    echo "<img src='{$qrCodeName}'>";
    echo $row_exibe['id_inscritos'];
    
    }

?>