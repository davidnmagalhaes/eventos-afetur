<?php 
		$ingresso = $_POST['ingresso'];
		$valor = $_POST['valor'];
		$quantidade = $_POST['quantidade'];
		
		$chave = array_search('0', $quantidade);
		if($chave!==false){
			unset($quantidade[$chave]);
		}
		
		$ref = $_POST['ref'];
		
		$nome = $_POST['nome'];
		$resultado = $_POST['resultado'];
		$email = $_POST['email'];
		$evento = $_POST['evento'];
		$ref = $_POST['ref'];
		$campoadicional = $_POST['campoadicional'];
		$numberi = number_format($resultado, 2, '.', '');
		$number = str_replace(',','.', $numberi);
		$npedido = substr(uniqid(rand()), 0, 5);
		$ningresso = substr(uniqid(rand()), 0, 5);
		$cod = $_POST['cod'];
		$tipotransacao = "Pagseguro";
		
		
		echo var_dump($ingresso);
		echo "<br>";
		echo var_dump($valor);
		echo "<br>";
		echo var_dump($quantidade);
		echo "<br>";
		echo var_dump($nome);
		echo "<br>";
		echo var_dump($email);
		echo "<br>";
		echo var_dump($campoadicional);
		echo "<br>";
		
		
		foreach($ingresso as $key => $ing){

			if($quantidade[$key] != 0){
				echo $ing;
				echo $quantidade[$key]."<br>";
				echo $nome[$key]."<br><br>";
			}
			
		}
		
		foreach($nome as $chave => $nm){

			
				
				echo $nm."<br>";
			
		}
?>