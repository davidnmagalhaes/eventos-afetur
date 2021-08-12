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


// Nome do Arquivo do Excel que será gerado
$arquivo = 'relatorio-financeiro.xls';

// Criamos uma tabela HTML com o formato da planilha para excel
$tabela = '<table border="1">';
$tabela .= '<tr>';
$tabela .= '<td colspan="5" align="center">Relat&oacute;rio Financeiro </tr>';
$tabela .= '</tr>';
$tabela .= '<tr>';
$tabela .= '<td align="center"><b>Respons&aacute;vel</b></td>';
$tabela .= '<td align="center"><b>Pedido</b></td>';
$tabela .= '<td align="center"><b>Data do pedido</b></td>';
$tabela .= '<td align="center"><b>Valor</b></td>';
$tabela .= '<td align="center"><b>Tipo de Pagamento</b></td>';
$tabela .= '</tr>';


// Puxando dados do Banco de dados
$ref = $_GET['ref'];

$resultado = mysqli_query($link, 'SELECT * FROM evn_pedidos WHERE ref='.$ref.' AND status = 3 ORDER BY id');
$row_resultado = mysqli_fetch_assoc($resultado);

while($dados = mysqli_fetch_array($resultado))
{
$tabela .= '<tr>';
$tabela .= '<td align="center">'.mb_convert_encoding($dados['nome'], 'utf-16','utf-8').'</td>';
$tabela .= '<td align="center">'.$dados['id'].'</td>';
$tabela .= '<td align="center">'.$dados['data_pedido'].'</td>';
$tabela .= '<td align="center">'.str_replace(".", ",",$dados['total_pedido']).'</td>';
$tabela .= '<td align="center">'.mb_convert_encoding($dados['tipo_transacao'], 'utf-16','utf-8').'</td>';
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