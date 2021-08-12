<?php
require "conexao.php";

/*$funcao = $_POST['funcao'];
$nome = $_POST['nome_usuario'];
$email = $_POST['email_usuario'];*/

$funcao = $_POST['funcao'];
$nome = $_POST['nome'];
$email = $_POST['email'];

$conexao = Conexao::getInstance();
$stmt = $conexao->prepare("SELECT * FROM evn_usuario WHERE email='$email'");
$stmt->execute();
$number_of_rows = $stmt->fetchColumn();

//Start - Gera ID e Verifica se existe
$coduser = date('YmdHm').rand(10,100);

if($number_of_rows > 0){
	echo "<script>javascript:alert('O e-mail já existe, tente cadastrar com outro e-mail.');javascript:window.location='../cd-usuarios.php'</script>";

}else{

$permissao = $_POST['permissao'];
$senha = password_hash($_POST['senha'],PASSWORD_DEFAULT);

// Insere usuários no banco de dados
$sql = "INSERT INTO evn_usuario(cod_usuario, nome, email, senha, status, funcao)VALUES('{$coduser}','{$nome}', '{$email}', '{$senha}', 'Ativo', '{$funcao}')";
$stm = $conexao->prepare($sql);
$executa = $stm->execute();

foreach($permissao as $perm){
	$sql2 = "INSERT INTO evn_permissao(ref_perm, usuario_perm, ativo_perm)VALUES('{$perm}','{$coduser}', '1')";
	$stm2 = $conexao->prepare($sql2);
	$executa2 = $stm2->execute();
}

//Permissões de páginas

//Página 1
$pedidospagos = $_POST['perm_pedidospagos']; 
$sqlpg1 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('1','{$coduser}', '{$pedidospagos}')";
$stmpg1 = $conexao->prepare($sqlpg1);
$executapg1 = $stmpg1->execute();

//Página 2
$pedidospendentes = $_POST['perm_pedidospendentes']; 
$sqlpg2 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('2','{$coduser}', '{$pedidospendentes}')";
$stmpg2 = $conexao->prepare($sqlpg2);
$executapg2 = $stmpg2->execute();

//Página 3
$criareventos = $_POST['perm_criareventos']; 
$sqlpg3 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('3','{$coduser}', '{$criareventos}')";
$stmpg3 = $conexao->prepare($sqlpg3);
$executapg3 = $stmpg3->execute();

//Página 4
$listareventos = $_POST['perm_listareventos']; 
$sqlpg4 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('4','{$coduser}', '{$listareventos}')";
$stmpg4 = $conexao->prepare($sqlpg4);
$executapg4 = $stmpg4->execute();

//Página 5
$verinscritos = $_POST['perm_verinscritos']; 
$sqlpg5 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('5','{$coduser}', '{$verinscritos}')";
$stmpg5 = $conexao->prepare($sqlpg5);
$executapg5 = $stmpg5->execute();

//Página 6
$adicionarinscricao = $_POST['perm_adicionarinscricao'];
$sqlpg6 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('6','{$coduser}', '{$adicionarinscricao}')";
$stmpg6 = $conexao->prepare($sqlpg6);
$executapg6 = $stmpg6->execute();

//Página 7
$verfinanceiro = $_POST['perm_verfinanceiro']; 
$sqlpg7 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('7','{$coduser}', '{$verfinanceiro}')";
$stmpg7 = $conexao->prepare($sqlpg7);
$executapg7 = $stmpg7->execute();

//Página 8
$boletos = $_POST['perm_boletos']; 
$sqlpg8 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('8','{$coduser}', '{$boletos}')";
$stmpg8 = $conexao->prepare($sqlpg8);
$executapg8 = $stmpg8->execute();

//Página 9
$emailmarketing = $_POST['perm_emailmarketing']; 
$sqlpg9 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('9','{$coduser}', '{$emailmarketing}')";
$stmpg9 = $conexao->prepare($sqlpg9);
$executapg9 = $stmpg9->execute();

//Página 10
$emailremetente = $_POST['perm_emailremetente'];
$sqlpg10 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('10','{$coduser}', '{$emailremetente}')";
$stmpg10 = $conexao->prepare($sqlpg10);
$executapg10 = $stmpg10->execute();

//Página 11
$listaemails = $_POST['perm_listaemails'];
$sqlpg11 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('11','{$coduser}', '{$listaemails}')";
$stmpg11 = $conexao->prepare($sqlpg11);
$executapg11 = $stmpg11->execute();

//Página 12
$facebook = $_POST['perm_facebook'];
$sqlpg12 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('12','{$coduser}', '{$facebook}')";
$stmpg12 = $conexao->prepare($sqlpg12);
$executapg12 = $stmpg12->execute(); 

//Página 13
$verusuarios = $_POST['perm_verusuarios']; 
$sqlpg13 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('13','{$coduser}', '{$verusuarios}')";
$stmpg13 = $conexao->prepare($sqlpg13);
$executapg13 = $stmpg13->execute(); 

//Página 14
$addusuario = $_POST['perm_addusuario']; 
$sqlpg14 = "INSERT INTO evn_permissao_pagina(cod_pagina, cod_usuario, ativo)VALUES('14','{$coduser}', '{$addusuario}')";
$stmpg14 = $conexao->prepare($sqlpg14);
$executapg14 = $stmpg14->execute();

if($executa){
	echo "<script>javascript:alert('Usuário cadastrado com sucesso!');javascript:window.location='../usuarios.php'</script>";
}else{
	echo "<script>javascript:alert('Erro! Tente novamente mais tarde');javascript:window.location='../administracao.php'</script>";
}

}
?>