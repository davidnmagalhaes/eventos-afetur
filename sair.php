<?php
    session_start();   
    unset(
        $_SESSION['iduser'],
        
        $_SESSION['nivel'],
        $_SESSION['usuario'],
        $_SESSION['senha']
    );   
    $_SESSION['logindeslogado'] = "Deslogado com sucesso";
    //redirecionar o usuario para a página de login
    header("Location: index.php");
?>