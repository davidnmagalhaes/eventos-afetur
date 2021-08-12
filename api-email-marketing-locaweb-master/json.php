<?php

$nome = $_POST['nome'];
$email = $_POST['email'];

$dados = array('list' => array(
	'contacts' => array(array(
		'email' => $email,
		
		)
	),
	'overwriteattributes' => true)
);

$data_string = json_encode($dados);                                                                                   

$ch = curl_init('https://emailmarketing.locaweb.com.br/api/v1/accounts/104067/lists/45/contacts');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'GET: https://emailmarketing.locaweb.com.br/api/v1/accounts',
    'Content-Type: application/json',
	'X-Auth-Token: zEK8T9r5K4UrhhRzchd7viciUjwLdzkquWLyypzxGYor'
	)
);
$result = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo 'HTTP code: ' . $httpcode;
 
?>
