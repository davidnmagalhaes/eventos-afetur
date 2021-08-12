<?php
// FileName="Connection_php_mysql.htm"
// Type="MYSQL"
// HTTP="true"
$local = "db_volvo.mysql.dbaas.com.br";
$usuario = "db_volvo";
$senha = "Afe159753@Volv";
$banco = "db_volvo";
$con = mysqli_connect($local, $usuario, $senha, $banco);
 
if (!$con) {
    echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
 
//echo "Sucesso: Sucesso ao conectar-se com a base de dados MySQL." . PHP_EOL;
?>