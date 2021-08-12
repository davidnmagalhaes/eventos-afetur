
<?php
session_start();

if((empty($_SESSION['iduser'])) || (empty($_SESSION['usuario'])) || (empty($_SESSION['nivel']))){       
            $_SESSION['loginErro'] = "�rea restrita";
            header("Location: index.php");
        }else{
            if($_SESSION['nivel'] != "3"){
                $_SESSION['loginErro'] = "�rea restrita";
                header("Location: index.php");
            }
			
        }

require_once('config/conn.php');

if(isset($_POST)){ //Se existir POST executa
	
	$ref = substr(uniqid(rand()), 0, 5);
	$nome = $_POST['nome'];
	$datainicial = $_POST['datainicial'];
	$datafinal = $_POST['datafinal'];
	$horainicial = $_POST['horainicial'];
	$horafinal = $_POST['horafinal'];
	$refingresso = substr(uniqid(rand()), 0, 5);
	$ingresso = $_POST['ingresso'];
	$valor = str_replace(".","",$_POST['valor']);
	$valorconv = str_replace(",",".",$valor);
	$localnome = addslashes($_POST['nomelocal']);
	$cep = $_POST['cep'];
	$rua = $_POST['rua'];
	$numero = $_POST['numero'];
	$complemento = $_POST['complemento'];
	$bairro = $_POST['bairro'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];
	$descricaoevento = nl2br($_POST['descricaoevento']);
	$nomeorganizador = $_POST['nomeorganizador'];
	$descricaoorganizador = $_POST['descricaoorganizador'];
	$campoadicional = $_POST['campoadicional'];
	$pais = $_POST['pais'];
	$moeda = $_POST['moeda'];
	$emailpagseguro = $_POST['emailpagseguro'];
	$tokenpagseguro = $_POST['tokenpagseguro'];
	$appidpagseguro = $_POST['appidpagseguro'];
	$appkeypagseguro = $_POST['appkeypagseguro'];
	$appkeypaghiper = $_POST['appkeypaghiper'];
	$tokenpaghiper = $_POST['tokenpaghiper'];
	$clientidpaypal = $_POST['clientidpaypal'];
	$qtdboleto = $_POST['qtdboleto'];
	$ativo = 1;
	$unidade = $_POST['unidade'];
	$diascheckin = $_POST['diascheckin'];
	
	/*VariA?veis do upload de imagens*/
	$imagem = $_FILES['modelo']['name'];
	$temporario = $_FILES['modelo']['tmp_name'];
	
	if($imagem == NULL){
	$diretorio = "img-eventos/avatar.jpg";	
	}else{
	$diretorio = "img-eventos/".$ref.$imagem;	
	}
	
	/*VariA?veis do upload de imagens*/
	$logo = $_FILES['logo']['name'];
	$temp = $_FILES['logo']['tmp_name'];
	
	if($logo == NULL){
	$pasta = "img-eventos/sem-logo.jpg";	
	}else{
	$pasta = "img-eventos/".$ref.$logo;	
	}
	
	// Verifica se h� referencia igual no banco de dados
	$check=mysqli_query($link,"select * from evn_eventos where ref='$ref'");
	$checkrows=mysqli_num_rows($check);
	
	$ip = $_SERVER['REMOTE_ADDR']; 
	$data = date('Y-m-d'); 
	$hora = date('H:i:s');
	$nme = $_POST['nme'];
	$mensagem = $hora." - ".$nme." criou um evento chamado ".$nome;
	
	//Se a verifica�ao acima for maior do que 0 retorna erro, senao executa query
	if($checkrows>0){
      echo "Evento j&aacute; existe!";
	} else {  
		$sql = "INSERT INTO evn_eventos (tokenpaghiper, dias_checkin, qtdboleto, ativo, ref, modelo_evento, nome_evento, data_inicio, data_final, hora_inicio, hora_final, ref_ingresso, local_nome, local_cep, local_logradouro, local_numero, local_complemento, local_bairro, local_cidade, local_estado, descricao_evento, organizador_nome, organizador_descricao, campo_adicional, local_pais, moeda, logo, tokenpagseguro, appidpagseguro, appkeypagseguro, appkeypaghiper, clientidpaypal, emailpagseguro)
		VALUES ('$tokenpaghiper','$diascheckin', '$qtdboleto','$ativo','$ref', '$diretorio', '$nome', '$datainicial','$datafinal','$horainicial','$horafinal','$refingresso', '$localnome', '$cep', '$rua', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$descricaoevento', '$nomeorganizador', '$descricaoorganizador', '$campoadicional', '$pais', '$moeda', '$pasta', '$tokenpagseguro', '$appidpagseguro', '$appkeypagseguro', '$appkeypaghiper', '$clientidpaypal', '$emailpagseguro');";

	foreach($ingresso as $key => $ing){
		$referencia = $refingresso++;
		$sql .= "INSERT INTO evn_ingressos (unidade, ref_ingresso, ingresso, ref_evento, valor)
		VALUES ('$unidade[$key]', '$referencia', '$ing', '$ref', '$valorconv[$key]');";
	}
	
		 $sql .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem')";

	
	if ($link->multi_query($sql) === TRUE) {
		  move_uploaded_file($temporario,$diretorio);
		  move_uploaded_file($temp,$pasta);
		header("Location: edt-logo-evento.php?ref=".$ref);
	} else {
		echo "Error: " . $sql . "<br>" . $link->error;
	}

	$link->close();
		}
}


// Pega o n�mero de registros inseridos

//$cadastrados = mysql_affected_rows();
//echo 'Usu�rios cadastrados: ' . $cadastrados;


/* �REA DE TESTES */




    
    /*$usuario = $_POST['usuario'];
	$senha = md5($_POST['senha']);
	$nome_consultor = $_POST['nome_consultor'];
	$cotas = 0;
	$seguro = 0;
	$vm = 0;
	$pm = 0;
	$seminovo = 0;
	$ptfinal = 0;
	$video = $_POST['video'];
	$nivel = "1";
	$consadicional = "0";
	
	
	$nome = $_FILES['imagem']['name'];
	$temporario = $_FILES['imagem']['tmp_name'];
	
	if($nome == NULL){
	$diretorio = "../img-consultor/avatar.jpg";	
	}else{
	$diretorio = "../img-consultor/".$nome;	
	}
    
	
    $result_usuario = "INSERT INTO consultor (usuario, senha, nome_consultor, cotas_consultor, video, nivel, imagem, seguro, vm, pm, ptfinal, consadicional) VALUES ('$usuario','$senha','$nome_consultor','$cotas','$video','$nivel', '$diretorio', '$seguro', '$vm', '$pm', '$ptfinal', '$consadicional')";
    $resultado_usuario = mysqli_query($link, $result_usuario);
    
    move_uploaded_file($temporario,$diretorio);
	header("Location: cad_consultor.php")
	*/
?>