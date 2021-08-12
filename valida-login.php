<?php
    session_start(); 
        //Incluindo a conexão com banco de dados   
    include_once("config/conn.php");    
    //O campo usuário e senha preenchido entra no if para validar
    if((isset($_POST['usuario'])) && (isset($_POST['senha']))){
        $usuario = mysqli_real_escape_string($link, $_POST['usuario']); //Escapar de caracteres especiais, como aspas, prevenindo SQL injection
        $senha = mysqli_real_escape_string($link, $_POST['senha']);
        $senha = md5($senha);
            
        //Buscar na tabela usuario o usuário que corresponde com os dados digitado no formulário
        $result_usuario = "SELECT * FROM evn_usuarios WHERE usuario_user = '$usuario' && senha_user = '$senha' LIMIT 1";
        $resultado_usuario = mysqli_query($link, $result_usuario);
        $resultado = mysqli_fetch_assoc($resultado_usuario);
        
        //Encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
        if(isset($resultado)){
            $_SESSION['iduser'] = $resultado['id_user'];
        
            $_SESSION['nivel'] = $resultado['nivel_user'];
            $_SESSION['usuario'] = $resultado['usuario_user'];
			$_SESSION['nome'] = $resultado['nome_user'];
			
	
            if($_SESSION['nivel'] == "1"){
                header("Location: pagseguro/pedidos.php");
            }elseif($_SESSION['nivel'] == "2"){
                header("Location: financeiro.php");
			}elseif($_SESSION['nivel'] == "3"){
                header("Location: eventos.php");
            }elseif($_SESSION['nivel'] == "4"){
                header("Location: eventos.php");
            }
            else{
                header("Location: cliente.php");
            }
        //Não foi encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
        //redireciona o usuario para a página de login
        }else{    
            //Váriavel global recebendo a mensagem de erro
            $_SESSION['loginErro'] = "Usuário ou senha Inválido";
            header("Location: index.php");
        }
    //O campo usuário e senha não preenchido entra no else e redireciona o usuário para a página de login
    }else{
        $_SESSION['loginErro'] = "Usuário ou senha inválido";
        header("Location: index.php");
    }
?>