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

// Inclui a conexão
include_once('config/conn.php');

$id = $_GET['id_lista'];

$query = "SELECT * FROM evn_lista_email WHERE id_lista = '$id'";
$emails = mysqli_query($link, $query) or die(mysqli_error($link));
$row_emails = mysqli_fetch_assoc($emails);

// Nome do Arquivo do Excel que será gerado
$arquivo = 'lista-de-emails-'.$row_emails['nome_lista'].'.xls';

// Criamos uma tabela HTML com o formato da planilha para excel
$tabela = '<table border="1">';
$tabela .= '<tr>';
$tabela .= '<td  align="center">Lista '.$row_emails['nome_lista'].'</tr>';
$tabela .= '</tr>';
$tabela .= '<tr>';
$tabela .= '<td align="center"><b>E-mail</b></td>';
$tabela .= '</tr>';


// Puxando dados do Banco de dados


$resultado = mysqli_query($link, 'SELECT * FROM evn_emails WHERE ref_email='.$id.' GROUP BY email ORDER BY email');
$row_resultado = mysqli_fetch_assoc($resultado);

while($dados = mysqli_fetch_array($resultado))
{
$tabela .= '<tr>';
$tabela .= '<td align="center">'.$dados['email'].'</td>';
$tabela .= '</tr>';
}

$tabela .= '</table>';

// Força o Download do Arquivo Gerado
header ('Cache-Control: no-cache, must-revalidate');
header ('Pragma: no-cache');
header('Content-Type: application/x-msexcel;');
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");
echo $tabela;
?>