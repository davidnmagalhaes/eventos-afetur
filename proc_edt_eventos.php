<?php
session_start();

if((empty($_SESSION['iduser'])) || (empty($_SESSION['usuario'])) || (empty($_SESSION['nivel']))){       
            $_SESSION['loginErro'] = "Área restrita";
            header("Location: index.php");
        }else{
            if($_SESSION['nivel'] != "3"){
                $_SESSION['loginErro'] = "Área restrita";
                header("Location: index.php");
            }
			
        }

     require_once('config/conn.php');
    $ref = $_POST['ref'];
	$nome = $_POST['nome'];
	$datainicial = $_POST['datainicial'];
	$datafinal = $_POST['datafinal'];
	$horainicial = $_POST['horainicial'];
	$horafinal = $_POST['horafinal'];
	$refing = substr(uniqid(rand()), 0, 5);
	$refingresso = $_POST['refing'];
	$ingresso = $_POST['ingresso'];
	$valor = str_replace(".","",$_POST['valor']);
	$valorconv = str_replace(",",".",$valor);
	$localnome = $_POST['nomelocal'];
	$cep = $_POST['cep'];
	$rua = $_POST['rua'];
	$numero = $_POST['numero'];
	$complemento = $_POST['complemento'];
	$bairro = $_POST['bairro'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];
	$pais = $_POST['pais'];
	$moeda = $_POST['moeda'];
	$diascheckin = $_POST['diascheckin'];
	$descricaoevento = nl2br($_POST['descricaoevento']);
	$nomeorganizador = $_POST['nomeorganizador'];
	$descricaoorganizador = $_POST['descricaoorganizador'];
	$campoadicional = $_POST['campoadicional'];
	$emailpagseguro = $_POST['emailpagseguro'];
	$tokenpagseguro = $_POST['tokenpagseguro'];
	$appidpagseguro = $_POST['appidpagseguro'];
	$appkeypagseguro = $_POST['appkeypagseguro'];
	$appkeypaghiper = $_POST['appkeypaghiper'];
	$tokenpaghiper = $_POST['tokenpaghiper'];
	$clientidpaypal = $_POST['clientidpaypal'];
	$unidade = $_POST['unidade'];
	$qtdboleto = $_POST['qtdboleto'];
	$daysduedate = $_POST['days_due_date'];
	$unidade = $_POST['unidade'];
	$tabelabd = $_POST['tabelabd'];
	$colunabd = $_POST['colunabd'];
	$valuebd = $_POST['valuebd'];
	$hostbd = $_POST['hostbd'];
	$usuariobd = $_POST['usuariobd'];
	$passbd = $_POST['passbd'];
	$bancobd = $_POST['bancobd'];
	$emailcopia = $_POST['emailcopia'];

	$ingresso2 = $_POST['ingresso2'];
	$valor2 = str_replace(".","",$_POST['valor2']);
	$valorconv2 = str_replace(",",".",$valor2);
	$unidade2 = $_POST['unidade2'];
	
	$ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_POST['nme'];
	
	$query = "SELECT * FROM evn_eventos WHERE ref='$ref'";
	$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
	$row_eventos = mysqli_fetch_assoc($eventos);
	
	$qr = "SELECT * FROM evn_ingressos WHERE ref_evento='$ref'";
	$ingressos = mysqli_query($link, $qr) or die(mysqli_error($link));
	$row_ingressos = mysqli_fetch_assoc($ingressos);
	
	$mensagem = $hora." - ".$nme." editou o evento ".$ref.":";
	if($row_eventos['nome_evento'] != $nome){
	$mensagem .= "<br>Editou o nome de ".$row_eventos['nome_evento']." para ".$nome;
	}
	if($row_eventos['data_inicio'] != $datainicial){
	$mensagem .= "<br>Editou a data inicial de ".$row_eventos['data_inicio']." para ".$datainicial;
	}
	if($row_eventos['data_final'] != $datafinal){
	$mensagem .= "<br>Editou a data final de ".$row_eventos['data_final']." para ".$datafinal;
	}
	if($row_eventos['hora_inicio'] != $horainicial){
	$mensagem .= "<br>Editou a hora inicial de ".$row_eventos['hora_inicio']." para ".$horainicial;
	}
	if($row_eventos['hora_final'] != $horafinal){
	$mensagem .= "<br>Editou a hora final de ".$row_eventos['hora_final']." para ".$horafinal;
	}
	if($row_eventos['moeda'] != $moeda){
	$mensagem .= "<br>Editou a moeda de ".$row_eventos['moeda']." para ".$moeda;
	}
	if($row_eventos['qtdboleto'] != $qtdboleto){
	$mensagem .= "<br>Editou a quantidade de parcelas permitidas para boletos de ".$row_eventos['qtdboleto']." para ".$qtdboleto;
	}
	if($row_eventos['local_nome'] != $localnome){
	$mensagem .= "<br>Editou o nome do local de ".$row_eventos['local_nome']." para ".$localnome;
	}
	if($row_eventos['local_cep'] != $cep){
	$mensagem .= "<br>Editou o CEP de ".$row_eventos['local_cep']." para ".$cep;
	}
	if($row_eventos['local_logradouro'] != $rua){
	$mensagem .= "<br>Editou o logradouro de ".$row_eventos['local_logradouro']." para ".$rua;
	}
	if($row_eventos['local_numero'] != $numero){
	$mensagem .= "<br>Editou o número do local de ".$row_eventos['local_numero']." para ".$numero;
	}
	if($row_eventos['local_complemento'] != $complemento){
	$mensagem .= "<br>Editou o complemento do local de ".$row_eventos['local_complemento']." para ".$complemento;
	}
	if($row_eventos['local_bairro'] != $bairro){
	$mensagem .= "<br>Editou o bairro do local de ".$row_eventos['local_bairro']." para ".$bairro;
	}
	if($row_eventos['local_cidade'] != $cidade){
	$mensagem .= "<br>Editou a cidade do local de ".$row_eventos['local_cidade']." para ".$cidade;
	}
	if($row_eventos['local_estado'] != $estado){
	$mensagem .= "<br>Editou o estado do local de ".$row_eventos['local_estado']." para ".$estado;
	}
	if($row_eventos['local_pais'] != $pais){
	$mensagem .= "<br>Editou o pais do local de ".$row_eventos['local_pais']." para ".$pais;
	}
	if($row_eventos['descricao_evento'] != $descricaoevento){
	$mensagem .= "<br>Editou a descrição do evento de ".$row_eventos['descricao_evento']." para ".$descricaoevento;
	}
	if($row_eventos['organizador_nome'] != $nomeorganizador){
	$mensagem .= "<br>Editou o nome do organizador de ".$row_eventos['organizador_nome']." para ".$nomeorganizador;
	}
	if($row_eventos['organizador_descricao'] != $descricaoorganizador){
	$mensagem .= "<br>Editou a descriçao do organizador de ".$row_eventos['organizador_descricao']." para ".$descricaoorganizador;
	}
	if($row_eventos['campo_adicional'] != $campoadicional){
	$mensagem .= "<br>Editou o campo adicional de ".$row_eventos['campo_adicional']." para ".$campoadicional;
	}
	if($row_eventos['emailpagseguro'] != $emailpagseguro){
	$mensagem .= "<br>Editou o e-mail do Pagseguro de ".$row_eventos['emailpagseguro']." para ".$emailpagseguro;
	}
	if($row_eventos['tokenpagseguro'] != $tokenpagseguro){
	$mensagem .= "<br>Editou o token do pagseguro de ".$row_eventos['tokenpagseguro']." para ".$tokenpagseguro;
	}
	if($row_eventos['appidpagseguro'] != $appidpagseguro){
	$mensagem .= "<br>Editou o App Id do Pagseguro de ".$row_eventos['appidpagseguro']." para ".$appidpagseguro;
	}
	if($row_eventos['appkeypagseguro'] != $appkeypagseguro){
	$mensagem .= "<br>Editou o App Key do Pagseguro de ".$row_eventos['appkeypagseguro']." para ".$appkeypagseguro;
	}
	if($row_eventos['appkeypaghiper'] != $appkeypaghiper){
	$mensagem .= "<br>Editou o App Key do PagHiper de ".$row_eventos['appkeypaghiper']." para ".$appkeypaghiper;
	}
	if($row_eventos['clientidpaypal'] != $clientidpaypal){
	$mensagem .= "<br>Editou o Client Id do Paypal ".$row_eventos['clientidpaypal']." para ".$clientidpaypal;
	}
	

    $result_usuario = "UPDATE evn_eventos SET days_due_date='$daysduedate', email_copia='$emailcopia', host_bd='$hostbd', password_bd='$passbd', usuario_bd='$usuariobd', banco_bd='$bancobd', dias_checkin='$diascheckin', value_bd='$valuebd', coluna_bd='$colunabd', tabela_bd='$tabelabd', qtdboleto='$qtdboleto', emailpagseguro='$emailpagseguro', emailpagseguro='$emailpagseguro', clientidpaypal='$clientidpaypal', tokenpaghiper='$tokenpaghiper', appkeypaghiper='$appkeypaghiper', appkeypagseguro='$appkeypagseguro', appidpagseguro='$appidpagseguro', tokenpagseguro='$tokenpagseguro', moeda='$moeda', local_pais='$pais', nome_evento='$nome', data_inicio='$datainicial', data_final='$datafinal', hora_inicio='$horainicial', hora_final='$horafinal', local_nome='$localnome', local_cep='$cep', local_logradouro='$rua', local_numero='$numero', local_complemento='$complemento', local_bairro='$bairro', local_cidade='$cidade', local_estado='$estado', descricao_evento='$descricaoevento', organizador_nome='$nomeorganizador', organizador_descricao='$descricaoorganizador', campo_adicional='$campoadicional' WHERE ref='$ref';";
	
	
	
	foreach($ingresso as $key => $ing){
		
		$result_usuario .= "UPDATE evn_ingressos SET unidade='$unidade[$key]', ingresso='$ing', valor='$valorconv[$key]' WHERE ref_ingresso='$refingresso[$key]';";
	
	}

	foreach($ingresso2 as $key2 => $ing2){

	$referencia = $refing++;
	$result_usuario .= "INSERT INTO evn_ingressos (unidade, ref_ingresso, ingresso, ref_evento, valor)
	VALUES ('$unidade2[$key2]', '$referencia', '$ing2', '$ref', '$valorconv2[$key2]');";

	}

	if ($link->multi_query($result_usuario) === TRUE) {
		header("Location: paginassucesso/sucesso-edt-evento.php");
	} else {
		echo "Error: " . $result_usuario . "<br>" . $link->error;
	}

	$link->close();
	
	
?>