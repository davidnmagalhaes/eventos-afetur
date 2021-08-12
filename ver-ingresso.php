<?php 
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

require_once('config/conn.php');

$ref = $_GET['ref'];

$sql = "SELECT * FROM evn_eventos WHERE ref='$ref'";
$eventos = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);
$totalRows_eventos = mysqli_num_rows($eventos);

$sql = "SELECT * FROM evn_ingressos WHERE ref_evento='$ref'";
$ingressos = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_ingressos = mysqli_fetch_assoc($ingressos);
$totalRows_ingressos = mysqli_num_rows($ingressos);

?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Cadastro de Eventos - Afetur Eventos</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="bootstrap/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<!--Ajax botão adicionar campos-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<!--Editor de Textos-->
		<script src="editor.js"></script>
		<link href="editor.css" type="text/css" rel="stylesheet"/>
		
		<script>
			$(document).ready(function() {
				$("#txtEditor").Editor();
			});
		</script>
		
  </head>
   <body>
       
	<div class="container">
			<form name="cdeventos" id="cdeventos" method="post" enctype="multipart/form-data" action="processos/proc_cd_eventos.php">
				<a href="eventos.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">EVENTOS</a>
				<a href="#" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">PÁGINA DO EVENTO</a>
				
				<div class="form-group">
				<h3>1. Qual é o nome do evento?</h3>
				<div class="row">
				<div class="col">
					<label for="nomedoevento">Nome do Evento:</label>
					<input type="text" class="form-control" id="nome" name="nome" placeholder="Exemplo: 10ª Conferência" value="<?php echo $row_eventos['nome_evento']; ?>">
				
					<label for="capadoevento">Modelo do Evento:</label>
					<input type="file" class="form-control-file" id="modelo" name="modelo">
				</div>
				</div>
				<h3>2. Quando o evento vai acontecer?</h3>
				<div class="row">
					<div class="col">
					<label for="datainicial">Data de Início:</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroupPrepend2"><i class="far fa-calendar-alt"></i></span>
						</div>
						<input type="date" class="form-control" id="datainicial" name="datainicial" value="<?php echo $row_eventos['data_inicio']; ?>">
					</div>
					</div>
					
					<div class="col">
					<label for="datainicial">Data de Término:</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroupPrepend2"><i class="far fa-calendar-alt"></i></span>
						</div>
						<input type="date" class="form-control" id="datafinal" name="datafinal" value="<?php echo $row_eventos['data_final']; ?>">
					</div>
					</div>
					
					<div class="col">
					<label for="datainicial">Hora de Início:</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroupPrepend2"><i class="far fa-clock"></i></span>
						</div>
						<input type="time" class="form-control" id="horainicial" name="horainicial" value="<?php echo $row_eventos['hora_inicio']; ?>">
					</div>
					</div>
					
					<div class="col">
					<label for="datainicial">Hora de Término:</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroupPrepend2"><i class="far fa-clock"></i></span>
						</div>
						<input type="time" class="form-control" id="horafinal" name="horafinal" value="<?php echo $row_eventos['hora_final']; ?>">
					</div>
					</div>
					
				</div>
					<h3>3. Ingressos</h3>
					
					<div class="row" style="text-align:center; margin: 20px 0;">
						<div class="col">
							<button type="button" name="add" id="add" class="btn btn-success">Adicionar ingresso</button>
						</div>
					</div>
					
					<div class="row">
					<div class="col">
						<div class="form-group">
							<div name="add_name" id="add_name">
							<div class="table-responsive">
								
								<table class="table table-bordered" id="dynamic_field" >
								<?php do { ?>
									<tr>
										<td colspan="2">
											<label for="nomeingresso">Ingresso:</label>
											<input type="text" name="ingresso[]" placeholder="Ex.: Ingresso Conferência" class="form-control name_list" value="<?php echo $row_ingressos['ingresso'];?>" required />
										</td>
										<td>
											<label for="valoringresso">Valor:</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="inputGroupPrepend2">R$</span>
												</div>
												<input type="text" class="form-control" id="valor" name="valor[]" placeholder="Ex.: 1.150,00" value="<?php echo $row_ingressos['valor'];?>" required>
											</div>
										</td>
									</tr>
								<?php } while ($row_ingressos = mysqli_fetch_assoc($ingressos));?>
								</table>
								
							</div>
							</div>
						</div>
					</div>
					</div>
					
					<h3>4. Onde o evento vai acontecer?</h3>
					<p>Ajude o público a chegar até o evento! Informe o endereço completo de onde ele irá acontecer.</p>
					
					<div class="row">
					<div class="col">
						<div class="dropdown">
							  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Escolher local salvo...
							  </a>

							  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
								<a class="dropdown-item" href="#">Afetur</a>
								<a class="dropdown-item" href="#">Afetur 2</a>
								<a class="dropdown-item" href="#">Afetur 3</a>
							  </div>
						</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<label for="nomedolocal">Nome do local:</label>
						<input type="text" class="form-control" id="nomelocal" name="nomelocal" placeholder="Exemplo: Afetur" value="<?php echo $row_eventos['local_nome']; ?>" required>
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<label for="cep">CEP:</label>
						<input type="text" class="form-control" id="cep" name="cep" placeholder="Exemplo: 60713-730" value="<?php echo $row_eventos['local_cep']; ?>" required>
					</div>
					<div class="col">
						<label for="rua">Av./Rua:</label>
						<input type="text" class="form-control" id="rua" name="rua" placeholder="Exemplo: Rua General Tertuliano" value="<?php echo $row_eventos['local_logradouro']; ?>" required>
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<label for="numero">Número:</label>
						<input type="text" class="form-control" id="numero" name="numero" placeholder="Exemplo: 137" value="<?php echo $row_eventos['local_numero']; ?>" required>
					</div>
					<div class="col">
						<label for="complemento">Complemento:</label>
						<input type="text" class="form-control" id="complemento" name="complemento" placeholder="Exemplo: Apto. 8, Bloco A" value="<?php echo $row_eventos['local_complemento']; ?>" required>
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<label for="bairro">Bairro:</label>
						<input type="text" class="form-control" id="bairro" name="bairro" placeholder="Exemplo: Aldeota" value="<?php echo $row_eventos['local_bairro']; ?>" required>
					</div>
					<div class="col">
						<label for="cidade">Cidade:</label>
						<input type="text" class="form-control" id="cidade" name="cidade" placeholder="Exemplo: Fortaleza" value="<?php echo $row_eventos['local_cidade']; ?>" required>
					</div>
					<div class="col">
						<label for="estado">Estado:</label>
						<select class="form-control" name="estado" id="estado" value="<?php echo $row_eventos['local_estado']; ?>">
							<option>Selecione um estado...</option>
						</select>
					</div>
					</div>
					
					<h3>5. Descrição do evento</h3>
					<p>Conte todos os detalhes do seu evento, como a programação e os diferenciais da sua produção!</p>
					
					<div class="row">
					<div class="col">
						<div class="form-group">
							<textarea class="form-control" id="descricaoevento" name="descricaoevento" rows="3" ><?php echo $row_eventos['descricao_evento']; ?></textarea>
						</div>
					</div>
					</div>
					
					<h3>6. Sobre o Organizador</h3>
					<p>Conte um pouco sobre você ou a sua empresa. É importante mostrar ao público quem está por trás do evento, dando mais credibilidade à sua produção.</p>

					<div class="row">
					<div class="col">
						<div class="dropdown">
							  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Escolher local salvo...
							  </a>

							  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
								<a class="dropdown-item" href="#">Afetur</a>
								<a class="dropdown-item" href="#">Afetur 2</a>
								<a class="dropdown-item" href="#">Afetur 3</a>
							  </div>
						</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<label for="nomedolocal">Nome do Organizador:</label>
						<input type="text" class="form-control" id="nomeorganizador" name="nomeorganizador" placeholder="Exemplo: Afetur" value="<?php echo $row_eventos['organizador_nome']; ?>" required>
					</div>
					</div>
					
					<div class="row">
					<div class="col">
						<div class="form-group">
							<textarea class="form-control" id="descricaoorganizador" name="descricaoorganizador" rows="3"><?php echo $row_eventos['organizador_descricao']; ?></textarea>
						</div>
					</div>
					</div>
					
					<button type="submit" id="cadastrar" class="btn btn-primary">MODIFICAR EVENTO</button>
				</div>	
				
				<input name="ref" type="hidden" id="ref" value="<?php echo $row_eventos['ref']; ?>">
				
			</form>
	</div>  
	   
   </body>
</html>


<script>
$(document).ready(function(){
	var i=1;
	$('#add').click(function(){
		i++;
		$('#dynamic_field').append('<tr id="row'+i+'"><td><label for="nomeingresso">Ingresso:</label><input type="text" name="ingresso[]" placeholder="Ex.: Ingresso Conferência" class="form-control name_list" /></td><td><label for="valoringresso">Valor:</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend2">R$</span></div><input type="text" class="form-control" id="valor" name="valor[]" placeholder="Ex.: 1.150,00"></div></td><td style="text-align:center"><br><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button> REMOVER</td></tr>');
	

	});

	
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
	
	
	
});
</script>