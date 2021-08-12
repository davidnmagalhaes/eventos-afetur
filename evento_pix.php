<?php 
require_once('config/conn.php');

$ref = $_GET['ref'];

$sql = "SELECT * FROM evn_eventos WHERE ref='$ref'";
$eventos = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);
$totalRows_eventos = mysqli_num_rows($eventos);

$tabelabd = $row_eventos['tabela_bd'];
$colunabd = $row_eventos['coluna_bd'];
$valuebd = $row_eventos['value_bd'];

$sql = "SELECT * FROM evn_ingressos WHERE ref_evento='$ref'";
$ingressos = mysqli_query($link, $sql) or die(mysqli_error($link));
$row_ingressos = mysqli_fetch_assoc($ingressos);
$totalRows_ingressos = mysqli_num_rows($ingressos);

if($tabelabd == "" || $colunabd == ""){

}else{
// Faz integração com outro banco de dados

$local2 = $row_eventos['host_bd'];
$usuario2 = $row_eventos['usuario_bd'];
$senha2 = $row_eventos['password_bd'];
$banco2 = $row_eventos['banco_bd'];
$link2 = mysqli_connect($local2, $usuario2, $senha2, $banco2);
 
if (!$link2) {
    echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
// Faz integração com outro banco de dados

$qr = "SELECT * FROM ".$tabelabd." ORDER BY ".$colunabd." ASC";
$adicional = mysqli_query($link2, $qr) or die(mysqli_error($link2));
$row_adicional = mysqli_fetch_assoc($adicional);
$totalRows_adicional = mysqli_num_rows($adicional);

$q = "SELECT * FROM ".$tabelabd." ORDER BY ".$colunabd." ASC";
$add = mysqli_query($link2, $q) or die(mysqli_error($link2));
$row_add = mysqli_fetch_assoc($add);
$totalRows_add = mysqli_num_rows($add);
}


if($row_eventos['emailpagseguro'] == "" || $row_eventos['tokenpagseguro'] == "" || $row_eventos['appidpagseguro'] == "" || $row_eventos['appkeypagseguro'] == ""){
	$ocultacartao = 1;
}
if($row_eventos['appkeypaghiper'] == ""){
	$ocultaboleto = 1;
}
if($row_eventos['clientidpaypal'] == ""){
	$ocultapaypal = 1;
}




?>
<?php if($row_eventos['ativo'] == 1){?>
<html lang="pt-br">

<head>
	<meta charset="utf-8" />
	<title><?php echo $row_eventos['nome_evento']; ?> - Afetur Eventos</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
		integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
	</script>
	<script src="bootstrap/js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
	</script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
		integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="pagseguro/style.css" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

  <script type="text/javascript">
		function fMasc(objeto, mascara) {
			obj = objeto
			masc = mascara
			setTimeout("fMascEx()", 1)
		}

		function fMascEx() {
			obj.value = masc(obj.value)
		}

		function mTel(tel) {
			tel = tel.replace(/\D/g, "")
			tel = tel.replace(/^(\d)/, "($1")
			tel = tel.replace(/(.{3})(\d)/, "$1)$2")
			if (tel.length == 9) {
				tel = tel.replace(/(.{1})$/, "-$1")
			} else if (tel.length == 10) {
				tel = tel.replace(/(.{2})$/, "-$1")
			} else if (tel.length == 11) {
				tel = tel.replace(/(.{3})$/, "-$1")
			} else if (tel.length == 12) {
				tel = tel.replace(/(.{4})$/, "-$1")
			} else if (tel.length > 12) {
				tel = tel.replace(/(.{4})$/, "-$1")
			}
			return tel;
		}

		function mCNPJ(cnpj) {
			cnpj = cnpj.replace(/\D/g, "")
			cnpj = cnpj.replace(/^(\d{2})(\d)/, "$1.$2")
			cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
			cnpj = cnpj.replace(/\.(\d{3})(\d)/, ".$1/$2")
			cnpj = cnpj.replace(/(\d{4})(\d)/, "$1-$2")
			return cnpj
		}

		function mCPF(cpf) {
			cpf = cpf.replace(/\D/g, "")
			cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
			cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
			cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
			return cpf
		}

		function mCEP(cep) {
			cep = cep.replace(/\D/g, "")
			cep = cep.replace(/^(\d{2})(\d)/, "$1.$2")
			cep = cep.replace(/\.(\d{3})(\d)/, ".$1-$2")
			return cep
		}

		function mNum(num) {
			num = num.replace(/\D/g, "")
			return num
		}
	</script>

</head>

<body style="background: #afb2c1;">

	<div class="container-fluid" style="background:#392450;">
		<div class="container">
			<div class="row">
				<div class="col"></div>
				<div class="col"><img
						src="<?php if($row_eventos['logo_sec'] == ""){echo "assets/logo-afetur.png";}else{echo $row_eventos['logo_sec'];}; ?>"
						width="200" style="margin: 10px;"></div>
				<div class="col"></div>
			</div>
		</div>
	</div>


	<form id="comprar" name="comprar" method="post"
		action="pix/pix.php">
		<input type="hidden" name="code" id="code" value="" />

		<div class="container" style="background: #fff; padding: 20px; margin-top: 20px; border-radius: 15px;">

			<div class="row">
				<div class="col">
					<img src="<?php echo $row_eventos['modelo_evento']; ?>" class="img-fluid" height="400"
						style="width:100%" align="center" />
					<h3 style="margin: 15px 0;"><?php echo $row_eventos['nome_evento']; ?></h3>
					<input type="hidden" name="evento" id="evento" value="<?php echo $row_eventos['nome_evento']; ?>">
					<!-- <div class="row" style="border: 1px solid #dee2e6; padding: 5px; margin: 3px 3px 20px 3px;">
						<div class="col-12 col-md-12">
							<?php //echo $row_eventos['descricao_evento']; ?>
						</div>
					</div> -->
					<div class="row" style="padding: 5px; margin: 3px 3px 20px 3px;">
						<div class="col">
							<p><i class="fas fa-calendar-alt" style="margin-right: 10px;"></i>
								<?php if($row_eventos['data_inicio'] == $row_eventos['data_final']){ echo date('d/m/Y', strtotime($row_eventos['data_inicio']));}else{echo date('d/m/Y', strtotime($row_eventos['data_inicio']))." at&eacute; ".date('d/m/Y', strtotime($row_eventos['data_final']));} ?>
								&agrave;s
								<?php if($row_eventos['hora_inicio'] == $row_eventos['hora_final']){ echo date('H:i', strtotime($row_eventos['hora_inicio']));}else{echo date('H:i', strtotime($row_eventos['hora_inicio']))." at&eacute; ".date('H:i', strtotime($row_eventos['hora_final']));} ?>
							</p>
							<p><i class="fas fa-map-marker-alt" style="margin-right: 10px;"></i>
								<?php echo $row_eventos['local_nome']; ?> -
								<?php echo $row_eventos['local_logradouro']; ?>,
								<?php echo $row_eventos['local_numero']; ?>,
								<?php echo $row_eventos['local_complemento']; ?>,
								<?php echo $row_eventos['local_bairro']; ?>,
								<?php echo $row_eventos['local_cidade']; ?>,
								<?php echo $row_eventos['local_estado']; ?>, <?php echo $row_eventos['local_pais']; ?>
							</p>
              <div class="row">
              <div class="col-md-6 col-12">
                <label>Nome completo:</label>
                <input type="text" name="nomefinal" class="form-control" placeholder="Digite seu nome completo" required/>
              </div>
              <div class="col-md-6 col-12">
                <label>E-mail:</label>
                <input type="text" name="emailfinal" class="form-control" placeholder="Digite seu e-mail" required/>
              </div>
              <div class="col-md-6 col-12">
                <label>Telefone:</label>
                <input type="text" name="telefonefinal" class="form-control" placeholder="Digite seu telefone" onkeydown="javascript: fMasc( this, mTel );" maxlength="14" required/>
              </div>
              <div class="col-md-6 col-12">
                <label>CPF:</label>
                <input type="text" onkeydown="javascript: fMasc( this, mCPF );" name="cpffinal" class="form-control" placeholder="Digite seu CPF" maxlength="14" required/>
              </div>
              </div>
						</div>
					</div>
					<div class="table-responsive">

						<table class="table table-bordered">
							<?php do { ?>
							<tr>
								<td colspan="2">
									<label for="nomeingresso">Ingresso:</label>
									<input type="text" id="ingresso" name="ingresso[]"
										placeholder="Ex.: Ingresso Conferência" class="form-control name_list ing"
										value="<?php echo $row_ingressos['ingresso'];?>" readonly required />
								</td>
								<td>
									<label for="valoringresso">Valor:</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<input type="text" class="form-control" id="moeda"
												value="<?php echo $row_eventos['moeda']; ?>" style="width: 45px;"
												readonly />
										</div>
										<input type="text" class="form-control ing" id="valor" name="valor[]"
											placeholder="Ex.: 1.150,00" value="<?php echo $row_ingressos['valor'];?>"
											readonly required>
									</div>
								</td>
								<td>
									<label for="nomeingresso">Quantidade:</label>
									<input type="number" id="quantidade" name="quantidade[]"
										class="form-control name_list ing" onchange="calculaPg();exibePagamento()"
										value="0" min="0" required />
								</td>
								<input name="idingresso[]" type="hidden" id="idingresso"
									value="<?php echo $row_ingressos['id_ingresso']; ?>">
								<input name="unidadeingresso[]" type="hidden" id="unidadeingresso"
									value="<?php echo $row_ingressos['unidade']; ?>" onchange="calculaUnidade()">

							</tr>
							<!--<tr>
										<td colspan="2">
											<label for="nome">Nome completo:</label>
											<input type="text" id="nome" name="nome[]" placeholder="Nome do participante principal" onkeyup="javascript: doSomething(this)" class="form-control name_list" required />
										</td>
										<td colspan="2">
											<label for="email">E-mail:</label>
											<input type="email" id="email" name="email[]" placeholder="E-mail do participante principal" onkeyup="javascript: doSomething(this)" class="form-control name_list" required />
										</td>
									</tr>-->
							<?php } while ($row_ingressos = mysqli_fetch_assoc($ingressos));?>
						</table>


					</div>
				</div>
			</div>

			<!--<div class="row">
				<div class="col" style="text-align:center">
					<h3 style="margin: 15px 0;">Dados de inscri&ccedil;&atilde;o</h3>
					<p>Preencha os nomes de cada participante de acordo com a quantidade de ingressos que ir&aacute;
						comprar. <br><strong>Obs.: O primeiro nome ser&aacute; o respons&aacute;vel pela
							cobran&ccedil;a.</strong></p>
					<div class="table-responsive">
						<div class="row" style="text-align:center; margin: 20px 0;">
							<div class="col">
								<button type="button" name="add" id="add" class="btn btn-success"><i class="fas fa-plus"></i> Adicionar mais
									inscritos</button>
							</div>
						</div>
						<table class="table table-bordered" id="dynamic_field">
							<tr>
								<td colspan="2">
									<label for="nome">Nome completo:</label>
									<input type="text" id="nome" name="nome[]"
										placeholder="Nome do participante principal"
										onkeyup="javascript: doSomething(this)" class="form-control name_list"
										required />

								</td>
								<?php //if($row_eventos['tabela_bd'] == ""){?>
								<td>
									<label for="campoadicional"><?php //echo $row_eventos['campo_adicional']; ?>:</label>
									<input type="text" id="campoadicional" name="campoadicional[]"
										onkeyup="javascript: doSomething(this)" class="form-control name_list"
										required />
								</td>

								<?php //}else{?>
								<td>
									<label for="campoadicional"><?php //echo $row_eventos['campo_adicional']; ?>:</label>
									<select id="campoadicional" name="campoadicional[]" class="form-control" required>
										<?php //do{ ?>
										<option value="<?php //echo $row_adicional[$valuebd];?>">
											<?php //echo $row_adicional[$colunabd];?></option>
										<?php //} while ($row_adicional = mysqli_fetch_assoc($adicional));?>
									</select>
								</td>
								<?php //}?>
								<input type="hidden" id="cpadicional" name="cpadicional[]"
									value="<?php //echo $row_eventos["campo_adicional"]; ?>">
							</tr>


						</table>



					</div>
				</div>

			</div>-->
			<div class="row">
			</div>
			<!-- <div class="row" style="width: 30%; margin: 20px auto;">
				<div class="col g-recaptcha" data-sitekey="6LefA6wZAAAAAGuoR8j070A8TBnX1Wawc-b6Zlt8"></div>
			</div> -->
			<div class="row" style="width: 100%; margin: 20px auto;">
				<div class="col-12" style="display: flex; justify-content: center;">


					<button style='display: none;margin-right: 15px;' type='submit' id='inscreverboleto'
						onclick='return blu();' class='btn btn-primary btn-lg'><i class="fas fa-qrcode"
							style='margin-right:5px;'></i> FINALIZAR INSCRIÇÃO</button>
				</div>

			</div>


			<input name="totalboleto" type="hidden" id="totalboleto">
			<input name="adicional" type="hidden" id="adicional" value="<?php echo $row_eventos['tabela_bd']; ?>">
			<?php if($tabelabd == "" || $colunabd == ""){?>
			<input name="opcoesadicional" type="hidden" id="opcoesadicional"
				value="<?php echo "<input type='text' id='campoadicional' name='campoadicional[]' class='form-control name_list' required />";?>">
			<?php }else{?>
			<input name="opcoesadicional" type="hidden" id="opcoesadicional"
				value="<?php echo "<select class='form-control' id='campoadicional' name='campoadicional[]' required>"; do{echo "<option value='".$row_add[$valuebd]."'>".$row_add[$colunabd]."</option>";} while ($row_add = mysqli_fetch_assoc($add)); echo '</select>';?>">
			<?php } ?>
			<input name="resultado" type="hidden" id="resultado">
			<input name="qt" type="hidden" id="qt">
			<input name="numum" type="hidden" id="numum">
			<input name="numdois" type="hidden" id="numdois">
			<input name="moeda" type="hidden" id="moeda" value="<?php echo $row_eventos['moeda']; ?>">
			<input name="ref" type="hidden" id="ref" value="<?php echo $row_eventos['ref']; ?>">
			<input name="ocultaboleto" type="hidden" id="ocultaboleto" value="<?php echo $ocultaboleto;?>">
			<input name="ocultacartao" type="hidden" id="ocultacartao" value="<?php echo $ocultacartao;?>">
			<input name="ocultapaypal" type="hidden" id="ocultapaypal" value="<?php echo $ocultapaypal;?>">


	</form>

	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script>
  function calculaUnidade(e){

  }

		function calculaPg() {
			var valor = document.getElementsByName("valor[]");
			var quantid = document.getElementsByName("quantidade[]");
			var qt = document.getElementsByName("qt");
			var nome = document.getElementsByName("nome[]");
			var ingresso = document.getElementsByName("ingresso[]");
			var testeu = [];
			var valoru = [];


			var somau = 0;
			var calcula = 0;



			for (var i = 0; i < quantid.length; i++) {

				testeu[i] = parseInt(quantid[i].value);

				valoru[i] = parseFloat(valor[i].value) * parseInt(testeu[i]);

				calcula += parseFloat(valoru[i]);

				somau += parseInt(testeu[i]);

				document.getElementById("resultado").value = calcula.toFixed(2);
				document.getElementById("qt").value = somau;
        console.log(somau)
			}



			var str = document.getElementById("resultado").value;

			document.getElementById("totalboleto").value = str.replace(/[^\d]+/g, '');

		}

		function exibePagamento() {
			var qt = document.getElementById("qt").value;
			var result = document.getElementById("resultado").value;
			var moeda = document.getElementById("moeda").value;
			var ocultaboleto = document.getElementById("ocultaboleto").value;
			var ocultacartao = document.getElementById("ocultacartao").value;
			var ocultapaypal = document.getElementById("ocultapaypal").value;
			if (moeda == "R$" && result == 0 && qt >= 1) {
				document.getElementById("inscrevergratis").style.display = "block";
				document.getElementById("inscreverboleto").style.display = "none";
				document.getElementById("inscrevercartao").style.display = "none";
			} else if (moeda == "R$" && result > 0 && ocultaboleto != 1 && ocultacartao != 1) {
				document.getElementById("inscreverboleto").style.display = "block";
				document.getElementById("inscrevercartao").style.display = "block";
				document.getElementById("inscrevergratis").style.display = "none";
			} else if (moeda == "R$" && result > 0 && ocultaboleto == 1 && ocultacartao != 1) {
				document.getElementById("inscreverboleto").style.display = "none";
				document.getElementById("inscrevercartao").style.display = "block";
				document.getElementById("inscrevergratis").style.display = "none";
			} else if (moeda == "R$" && result > 0 && ocultaboleto != 1 && ocultacartao == 1) {
				document.getElementById("inscreverboleto").style.display = "block";
				document.getElementById("inscrevercartao").style.display = "none";
				document.getElementById("inscrevergratis").style.display = "none";
			} else if (moeda == "R$" && result == 0) {
				document.getElementById("inscreverboleto").style.display = "none";
				document.getElementById("inscrevercartao").style.display = "none";
				document.getElementById("inscrevergratis").style.display = "display";
			} else if (moeda != "R$" && result == 0) {
				document.getElementById("inscreverboleto").style.display = "none";
				document.getElementById("inscrevercartao").style.display = "none";
				document.getElementById("inscrevergratis").style.display = "none";
				document.getElementById("inscreverpaypal").style.display = "none";
			} else if (qt == 0) {
				document.getElementById("inscreverboleto").style.display = "none";
				document.getElementById("inscrevercartao").style.display = "none";
				document.getElementById("inscrevergratis").style.display = "none";
				document.getElementById("inscreverpaypal").style.display = "none";
			} else {
				document.getElementById("inscreverpaypal").style.display = "block";
				document.getElementById("inscrevergratis").style.display = "none";
				document.getElementById("inscreverboleto").style.display = "none";
				document.getElementById("inscrevercartao").style.display = "none";
			}
		}
	</script>


	<script>
		function bla() {
			var valor = document.getElementsByName("valor[]");
			var unid = document.getElementsByName("unidadeingresso[]");
			var quantid = document.getElementsByName("quantidade[]");
			var nome = document.getElementsByName("nome[]");
			var ingresso = document.getElementsByName("ingresso[]");
			var testeu = [];
			var valoru = [];

			var somau = 0;

			for (var i = 0; i < unid.length; i++) {
				valoru[i] = parseInt(quantid[i].value) * parseInt(unid[i].value);


				somau += parseInt(valoru[i]);

			}

			contar = 0;
			for (y = 0; y < nome.length; y++) {
				contar++;
			}

			if (contar != somau) {
				alert('A quantidade de nomes \u00e9 diferente da quantidade de ingressos!');
				return false;
			} else {


				document.comprar.action = "teste-pagseguro/source/examples/checkout/createPaymentRequest.php";

			}

		}



		function paypal() {
			var valor = document.getElementsByName("valor[]");
			var unid = document.getElementsByName("unidadeingresso[]");
			var quantid = document.getElementsByName("quantidade[]");
			var nome = document.getElementsByName("nome[]");
			var ingresso = document.getElementsByName("ingresso[]");
			var testeu = [];
			var valoru = [];

			var somau = 0;

			for (var i = 0; i < unid.length; i++) {
				valoru[i] = parseInt(quantid[i].value) * parseInt(unid[i].value);


				somau += parseInt(valoru[i]);

			}

			contar = 0;
			for (y = 0; y < nome.length; y++) {
				contar++;
			}

			if (contar != somau) {
				alert('A quantidade de nomes \u00e9 diferente da quantidade de ingressos!');
				return false;
			} else {
				document.comprar.action = "paypal.php";

			}
		}



		function blu() {
			var valor = document.getElementsByName("valor[]");
			var unid = document.getElementsByName("unidadeingresso[]");
			var quantid = document.getElementsByName("quantidade[]");
			var nome = document.getElementsByName("nome[]");
			var ingresso = document.getElementsByName("ingresso[]");
			var testeu = [];
			var valoru = [];

			var somau = 0;

			for (var i = 0; i < unid.length; i++) {
				valoru[i] = parseInt(quantid[i].value) * parseInt(unid[i].value);


				somau += parseInt(valoru[i]);

			}

			contar = 0;
			for (y = 0; y < nome.length; y++) {
				contar++;
			}

			// if (contar != somau) {
			// 	alert('A quantidade de nomes \u00e9 diferente da quantidade de ingressos!');
			// 	return false;
			// } else {

				document.comprar.action = "pix/pix.php";


			//}
		}


		function gratis() {
			var valor = document.getElementsByName("valor[]");
			var unid = document.getElementsByName("unidadeingresso[]");
			var quantid = document.getElementsByName("quantidade[]");
			var nome = document.getElementsByName("nome[]");
			var ingresso = document.getElementsByName("ingresso[]");
			var testeu = [];
			var valoru = [];

			var somau = 0;

			for (var i = 0; i < unid.length; i++) {
				valoru[i] = parseInt(quantid[i].value) * parseInt(unid[i].value);


				somau += parseInt(valoru[i]);

			}

			contar = 0;
			for (y = 0; y < nome.length; y++) {
				contar++;
			}

			if (contar != somau) {
				alert('A quantidade de nomes \u00e9 diferente da quantidade de ingressos!');
				return false;
			} else {
				document.comprar.action = "inscricao-gratis.php";

			}
		}

		function myFunction() {
			document.getElementById("demo").innerHTML = document.getElementById("teste");
		}

		$(document).ready(function () {
			var i = 1;
			$('#add').click(function () {
				i++;
				var cpadicional = document.getElementById("cpadicional").value;
				var adicional = document.getElementById("adicional").value;
				var opcoesadicional = document.getElementById("opcoesadicional").value;
				$('#dynamic_field').append('<tr id="row' + i +
					'"><td colspan="2"><label for="nome">Nome completo:</label><input type="text" id="nome" name="nome[]" placeholder="Nome do participante adicional" onkeyup="javascript: doSomething(this)" class="form-control name_list" required /></td><td><label for="campoadicional">' +
					cpadicional + ':</label>' + opcoesadicional +
					'</td><td style="text-align:center"><br><button type="button" name="remove" id="' +
					i + '" class="btn btn-danger btn_remove">X</button> REMOVER</td></tr>');

			});


			$(document).on('click', '.btn_remove', function () {
				var button_id = $(this).attr("id");
				$('#row' + button_id + '').remove();
			});



		});
	</script>

</body>

</html>
<?php }else{header('Location: paginaserro/erro-pagina-desativada.php');}?>