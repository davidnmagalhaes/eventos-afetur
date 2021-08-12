<?php 
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

session_start();

if(!isset($_SESSION['logado'])){
    // Apaga todas as variáveis da sessão
$_SESSION = array();

// Se é preciso matar a sessão, então os cookies de sessão também devem ser apagados.
// Nota: Isto destruirá a sessão, e não apenas os dados!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão
session_destroy();
// Por último, redireciona para a página de login
echo "<script>javascript:alert('Você não está autorizado(a) a acessar esta página! Consulte o administrador ou presidente do clube!');javascript:window.location='index.php'</script>";
}

$pathAtual= getcwd();
$separador = explode("/",$pathAtual);
$pastaAtual = end($separador);
if($pastaAtual == "eventos"){
    $path = "";
    $order = "pagseguro/";
}else{
    $path = "../";
    $order = "";
}
require($path.'config/conn.php');

$user = $_SESSION['id_usuario'];
$sqllock = "SELECT * FROM evn_permissao_pagina WHERE cod_usuario='$user'";
$lock = mysqli_query($link, $sqllock) or die(mysqli_error($link));
$totalRows_lock = mysqli_num_rows($lock);



?>