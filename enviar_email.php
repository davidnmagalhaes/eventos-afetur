<?php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

$nome = "David";
$email = "david_nbxnb@hotmail.com";
$mensagem = "Teste";

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

use PHPMailer\src\PHPMailer;
use PHPMailer\src\Exception;
use PHPMailer\src\SMTP;

$mail = new PHPMailer(true);
try {

     //Server settings
    $mail->SMTPDebug = 2;               
    $mail->isSMTP();                               
    $mail->Host = 'afetur.com.br';  
    $mail->SMTPAuth = true;             
    $mail->Username = 'social@afetur.com.br';
    $mail->Password = 'Afetur159753@';     
    $mail->SMTPSecure = 'tls';               
    $mail->Port = 587;                                 

    //Recipients
    $mail->setFrom('social@afetur.com.br', 'Mailer');
    $mail->addAddress('social@afetur.com.br', 'Joe User');  

    $mail->Subject = "Email de contato da loja";
    $mail->msgHTML("<html>de: {$nome}<br/>email: {$email}<br/>mensagem: {$mensagem}</html>");
    $mail->AltBody = "de: {$nome}\nemail:{$email}\nmensagem: {$mensagem}";

    if ($mail->send()) {
        echo "Mensagem enviada com sucesso";
        header("Location: index.php");
    } else {
        echo "Erro ao enviar mensagem " . $mail->ErrorInfo;
        header("Location: contato.php");
    }
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
die();