
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

if(isset($_POST)){ //Se existir POST executa
	
	$nomelista = $_POST['nomelista'];
	$participantes = $_POST['participa'];
	$statuslista = 1;
	
	$sql = "INSERT INTO evn_lista_email (nome_lista, status_lista) VALUES ('$nomelista', '$statuslista');";

	$string = $participantes;
	$array = explode(',', $string);
	
	$qr = "SELECT * FROM evn_lista_email ORDER BY id_lista DESC";
	$codref = mysqli_query($link, $qr) or die(mysqli_error($link));
	$row_codref = mysqli_fetch_assoc($codref);
	
	$refemail = $row_codref['id_lista'];
	$refemail += 1;
	
	$ip = $_SERVER['REMOTE_ADDR']; 
			$data = date('Y-m-d'); 
			$hora = date('H:i:s');
			$nme = $_SESSION['nome'];
			
			$mensagem = $hora." - ".$nme." criou uma lista de e-mails com nome de ".$nomelista;

			$sql .= "INSERT INTO evn_log (ip_log, data_log, hora_log, nome_log, item_log, mensagem_log) VALUES ('$ip', '$data', '$hora', '$nme', '$item', '$mensagem');";

	
	foreach($array as $valores)
	{
	$sql .= "INSERT INTO evn_emails (email, ref_email) VALUES ('$valores', '$refemail');";
	}

	if ($link->multi_query($sql) === TRUE) {
		echo "Evento criado com sucesso!";
		header("Location: paginassucesso/sucesso-cd-lista-emails.php");
	} else {
		echo "Error: " . $sql . "<br>" . $link->error;
	}

	$link->close();
		}



// Pega o número de registros inseridos

//$cadastrados = mysql_affected_rows();
//echo 'Usuários cadastrados: ' . $cadastrados;


/* ÁREA DE TESTES */




    
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