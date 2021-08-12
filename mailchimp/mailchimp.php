<?php
/*
 * WIDGET MAILCHIMP BY EBRAHIM P. LEITE | www.webcreative.com.br
 */

require_once("lib/ApiMailchimp.php");

ob_start();

define('MAILCHIMP_KEY', 'd42ad5c98a2ed4deb9d180638f4c3fa1-us3');
define('MAILCHIMP_LIST_ID', '47c33a7302');
define('MAILCHIMP_DOUBLE_OPTIN', 'false'); //Enviar e-mail de confirmação? true=sim false=não
define('MAILCHIMP_UPDATE_EXISTING', 'true'); //Substitui contato existente? true=sim false=não

function response($responseStatus, $responseMsg) {
    $out = json_encode(array('status' => $responseStatus, 'msg' => $responseMsg));

    ob_end_clean();
    echo $out;
    die();
}

// AJAX CALLBACK
if (!isset($_SERVER['X-Requested-With']) && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    response(false, 'ajax');
}

$emailAddress = trim(strtolower($_POST['subscribeEmail']));

// Erro de sintaxe e verifica se e-mail é válido
if (!isset($emailAddress) || !trim($emailAddress)) {
    response(false, 'email-required');
}
if (!isset($emailAddress) || !preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', trim($emailAddress))) {
    response(false, 'email-err');
}

// Envida dados para api
$MailChimp = new MailChimp(MAILCHIMP_KEY);
$result = $MailChimp->call('lists/subscribe', array(
    'id' => MAILCHIMP_LIST_ID,
    'email' => array('email' => $emailAddress),
    'merge_vars' => array('FNAME' => $_POST['subscribeName'], 'LNAME' => $lastName),
    'double_optin' => MAILCHIMP_DOUBLE_OPTIN, //CONFIRMAÇÃO DE EMAIL
    'update_existing' => MAILCHIMP_UPDATE_EXISTING, //ATUALIZAR LEAD EXISTENTE
    'replace_interests' => false,
    'send_welcome' => false,
        ));

if ($result) {
    response(true, 'subscribed');
} else {
    response(false, 'api-error');
}