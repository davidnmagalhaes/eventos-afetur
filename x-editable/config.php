<?php
/*
 * Site : http:www.smarttutorials.net
 * Author :muni
 * 
 */
 
//define('BASE_PATH','http://localhost/projects/inline3');
define('DB_HOST', 'db_volvo.mysql.dbaas.com.br');
define('DB_NAME', 'db_volvo');
define('DB_USER', 'db_volvo');
define('DB_PASSWORD', 'Afe159753@Volv');


$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if( mysqli_connect_error()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

?>