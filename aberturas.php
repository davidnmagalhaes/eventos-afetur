<?php
$opened_at = $_POST['opened_at'];
$message_sender     = $_POST['sender'];
$message_to             = $_POST['to'];
$message_subject    = $_POST['subject'];
$x_smtplw                 = $_POST['x-smtplw'];

$myfile = fopen("myfile.txt", "a") or die("Unable to open file");
$date = date('m/d/Y H:i:s', time());

$txt = "[$date] opened_at: $opened_at\tsender: $message_sender\tto: $message_to\tsubject: $message_subject\tx_smtplw: $x_smtplw\n";
fwrite($myfile, $txt);

fclose($myfile);
?>