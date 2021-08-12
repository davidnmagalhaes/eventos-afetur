<?php
$bounce_description = $_POST['bounce_description'];
$bounce_code           = $_POST['bounce_code'];
$message_sender     = $_POST['sender'];
$message_to             = $_POST['to'];
$message_subject    = $_POST['subject'];
$x_smtplw                 = $_POST['x-smtplw'];

$myfile = fopen("myfile.txt", "a") or die("Unable to open file");
$date = date('m/d/Y H:i:s', time());

$txt = "[$date] bounce_description: $bounce_description\tbounce_code: $bounce_code\tsender: $message_sender\tto: $message_to\tsubject: $message_subject\tx_smtplw: $x_smtplw\n";
fwrite($myfile, $txt);

fclose($myfile);
?>