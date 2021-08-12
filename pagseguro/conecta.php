<?php

include_once 'config.php';

class conecta extends config{
 var $pdo;
 
 function __construct(){
 $this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->db, $this->usuario, $this->senha); 
 }

/*
 function salvarPedido(){
 $nome = $_POST['nome'];
 $sobrenome = $_POST['sobrenome'];
 $email = $_POST['email'];
  $resultado = $_POST['resultado'];
  $results = $_POST['results'];
  $evento = $_POST['evento'];
  $ref = $_POST['ref'];
	$qts = $_POST['qts'];
	$ingadd = nl2br($_POST['ingadd']);
	$campoadicional = $_POST['campoadicional'];
  
$numberi = number_format($resultado, 2, '.', '');
$number = str_replace(',','.', $numberi);

$stmt = $this->pdo->prepare("INSERT INTO evn_pedidos (descricao, status, nome, sobrenome, email, total_pedido, log, evento, ref, data_pedido, qtd_ingresso, ingadd, campo_adicional) VALUES ('Pedido #', 1, '$nome', '$sobrenome', '$email', '$number', '$results', '$evento', '$ref', NOW(), '$qts', '$ingadd', '$campoadicional')");
 $stmt->bindValue(":codigo",$codigo); 
 $run = $stmt->execute();

 

 }
 */

 
 function consultarPedido($reference){
 $stmt = $this->pdo->prepare("SELECT * FROM evn_pedidos where id = :reference");
 $stmt->bindValue(":reference",$reference);
 $run = $stmt->execute();
 $rs = $stmt->fetch(PDO::FETCH_ASSOC);
 return $rs; 
 
 }

 function atualizaPedido($reference, $status){
 $datapgto = date("Y-m-d");
 $stmt = $this->pdo->prepare("UPDATE evn_pedidos SET status = :status, data_pagamento = :datapgto where id = :reference");
 $stmt->bindValue(":reference",$reference);
 $stmt->bindValue(":datapgto",$datapgto);
 $stmt->bindValue(":status",$status);
 $run = $stmt->execute();
 
 }
 
function listarPedidos(){

//Limita o número de registros a serem mostrados por página

$limite = 3;
//Se pg não existe atribui 1 a variável pg
$pg = (isset($_GET['pg'])) ? (int)$_GET['pg'] : 1 ;
//Atribui a variável inicio o inicio de onde os registros vão ser mostrados por página, exemplo 0 à 10, 11 à 20 e assim por diante
$inicio = ($pg * $limite) - $limite;
	
 $stmt = $this->pdo->prepare("SELECT p.data_pedido, p.tipo_transacao,p.npedido, p.descricao, p.id, p.nome, p.evento, p.total_pedido, p.email, s.status FROM evn_pedidos as p INNER JOIN evn_status_pedido as s on p.status = s.id order by p.id DESC LIMIT ".$inicio.",".$limite);
 $run = $stmt->execute();
 $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
 return $rs;
 
 
 }
 
 
 
 function consultarUltimoPedido(){
 $stmt = $this->pdo->prepare("SELECT * FROM evn_pedidos order by id DESC");
 $run = $stmt->execute();
 $rs = $stmt->fetch(PDO::FETCH_ASSOC);
 return $rs; 
 
 }

}

?>