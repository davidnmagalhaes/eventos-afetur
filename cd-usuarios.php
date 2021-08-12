<?php
include("valida_pagina.php");
		
require('config/conn.php');

$query = "SELECT * FROM evn_eventos ORDER BY nome_evento ASC";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$row_eventos = mysqli_fetch_assoc($eventos);
$totalRows_eventos = mysqli_num_rows($eventos);

?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Cadastro de Usuários - Afetur Eventos</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="bootstrap/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<!--Ajax botão adicionar campos-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<!--Editor de Textos-->
		<link rel="stylesheet" href="custom.css">
		<script src="https://kit.fontawesome.com/13f03eba23.js" crossorigin="anonymous"></script>
		

		<style>
			.field-icon {
			    float: right;
				margin-top: -35px;
				position: relative;
				z-index: 2;
				margin-right: 10px;
			}
			.paginaspermitidas ul{
				list-style: none;
			}
			.paginaspermitidas ul li{
				margin: 5px 0;
			}
			.botoes{
				display:flex; padding-left: 30px;
			}
		</style>
		
  </head>
   <body>
       <?php
		require_once('nav-main.php');
	   ?>

	<div class="container content">
			<form method="post" enctype="multipart/form-data" action="login-seguro/proc_cd_usuario.php">
				
				<div class="form-group">
				<h3 class="mg-top" style="margin: 20px 0;"><i class="fas fa-user" style="margin: 0 10px"></i> Cadastro de Usuários</h3>
				<div class="row">
				<div class="col">
					<label for="nomedoevento">Nome completo:</label>
					<input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do usuário">

				</div>
				<div class="col">
					<label for="nomedoevento">E-mail:</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Digite o e-mail do usuário">

				</div>
				</div>
				
				
				
				<div class="row">
				<div class="col">
					<label for="nomedoevento">Senha:</label>
					<input type="password" id="password-field" class="form-control" id="senha" name="senha">
					<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
				</div>
				<div class="col">
					<label for="nomedoevento">Nível:</label>
					<select class="form-control" id="funcao" name="funcao">
						<option value="1">Master</option>
						<option value="2">Padrão com Permissão</option>
					</select>

				</div>
				</div>
				
				<h3 class="mg-top" style="margin: 20px 0;"><i class="fas fa-key" style="margin: 0 10px"></i> Eventos Permitidos</h3>

				<div class="row">
					<?php  while ($row_eventos = mysqli_fetch_array($eventos)){?>
					<div class="col-12 col-md-4" style="margin: 5px 0">
						
							<div class="form-check form-check-inline">
								<input class="form-check-input passaIdParaValue" type="checkbox" id="<?php echo $row_eventos['ref'];?>" name="permissao[]" value="" onchange="passaIdParaValue(this);">
								<label class="form-check-label" for="<?php echo $row_eventos['ref'];?>"><?php echo $row_eventos['nome_evento'];?></label>
							</div>

					</div>
					<?php }?>
				</div>

				<h3 class="mg-top" style="margin: 20px 0;"><i class="fas fa-unlock-alt" style="margin: 0 10px"></i> Páginas Permitidas</h3>

				<div class="row">
						<div class="col paginaspermitidas">
							<ul>
								<li><button type="button" class="btn btn-primary botoes"><span>Pedidos</span> <input type="checkbox" class="form-check-input" id="pedidos" onchange="all(this);"></button>
									<ul>
										<li><button type="button" class="btn btn-info botoes"><span>Pedidos Pagos</span> <input type="checkbox" class="form-check-input permitirPagina pedidos" id="perm_pedidospagos" name="perm_pedidospagos" value="" onchange="permitirPagina(this);"></button></li>
										<li><button type="button" class="btn btn-info botoes"><span>Pedidos Pendentes</span> <input type="checkbox" class="form-check-input permitirPagina pedidos" id="perm_pedidospendentes" name="perm_pedidospendentes" value="" onchange="permitirPagina(this);"></button></li>
									</ul>
								</li>
								<li><button type="button" class="btn btn-primary botoes"><span>Eventos</span> <input type="checkbox" class="form-check-input" id="eventos"></button>
									<ul>
										<li><button type="button" class="btn btn-info botoes"><span>Criar Eventos</span> <input type="checkbox" class="form-check-input permitirPagina eventos" id="perm_criareventos" name="perm_criareventos" value="" onchange="permitirPagina(this);"></button></li>
										<li><button type="button" class="btn btn-info botoes"><span>Listar Eventos</span> <input type="checkbox" class="form-check-input permitirPagina eventos" id="perm_listareventos" name="perm_listareventos" value="" onchange="permitirPagina(this);"></button></li>
									</ul>
								</li>
								<li><button type="button" class="btn btn-primary botoes"><span>Inscritos</span> <input type="checkbox" class="form-check-input" id="inscritos"></button>
									<ul>
										<li><button type="button" class="btn btn-info botoes"><span>Ver inscritos</span> <input type="checkbox" class="form-check-input permitirPagina inscritos" id="perm_verinscritos" name="perm_verinscritos" value="" onchange="permitirPagina(this);"></button></li>
										<li><button type="button" class="btn btn-info botoes"><span>Adicionar Inscrição</span> <input type="checkbox" class="form-check-input permitirPagina inscritos" id="perm_adicionarinscricao" name="perm_adicionarinscricao" value="" onchange="permitirPagina(this);"></button></li>
									</ul>
								</li>
								<li><button type="button" class="btn btn-primary botoes"><span>Financeiro</span> <input type="checkbox" class="form-check-input" id="financeiro"></button>
									<ul>
										<li><button type="button" class="btn btn-info botoes"><span>Ver Financeiro</span> <input type="checkbox" class="form-check-input permitirPagina financeiro" id="perm_verfinanceiro" name="perm_verfinanceiro" value="" onchange="permitirPagina(this);"></button></li>
										<li><button type="button" class="btn btn-info botoes"><span>Boletos</span> <input type="checkbox" class="form-check-input permitirPagina financeiro" id="perm_boletos" name="perm_boletos" value="" onchange="permitirPagina(this);"></button></li>
									</ul>
								</li>
								<li><button type="button" class="btn btn-primary botoes"><span>Marketing</span> <input type="checkbox" class="form-check-input" id="marketing"></button>
									<ul>
										<li><button type="button" class="btn btn-info botoes"><span>E-mail Marketing</span> <input type="checkbox" class="form-check-input permitirPagina marketing" id="perm_emailmarketing" name="perm_emailmarketing" value="" onchange="permitirPagina(this);"></button></li>
										<li><button type="button" class="btn btn-info botoes"><span>E-mail Remetente</span> <input type="checkbox" class="form-check-input permitirPagina marketing" id="perm_emailremetente" name="perm_emailremetente" value="" onchange="permitirPagina(this);"></button></li>
										<li><button type="button" class="btn btn-info botoes"><span>Lista de E-mails</span> <input type="checkbox" class="form-check-input permitirPagina marketing" id="perm_listaemails" name="perm_listaemails" value="" onchange="permitirPagina(this);"></button></li>
										<li><button type="button" class="btn btn-info botoes"><span>Facebook</span> <input type="checkbox" class="form-check-input permitirPagina marketing" id="perm_facebook" name="perm_facebook" value="" onchange="permitirPagina(this);"></button></li>
									</ul>
								</li>
								<li><button type="button" class="btn btn-primary botoes"><span>Usuários</span> <input type="checkbox" class="form-check-input" id="usuarios"></button>
									<ul>
										<li><button type="button" class="btn btn-info botoes"><span>Ver Usuários</span> <input type="checkbox" class="form-check-input permitirPagina usuarios" id="perm_verusuarios" name="perm_verusuarios" value="" onchange="permitirPagina(this);"></button></li>
										<li><button type="button" class="btn btn-info botoes"><span>Adicionar Usuário</span> <input type="checkbox" class="form-check-input permitirPagina usuarios" id="perm_addusuario" name="perm_addusuario" value="" onchange="permitirPagina(this);"></button></li>
									</ul>
								</li>
							</ul>
						</div>
				</div>


				<!--<div class="row">
					<div class="col">
						<select multiple name="permeventos[]" class="form-control">
						<?php //do{?>
							<option value="<?php //echo $row_eventos['ref'];?>"><?php //echo $row_eventos['nome_evento'];?></option>
						<?php //} while ($row_eventos = mysqli_fetch_assoc($eventos));?>
						</select>
					</div>
					<div class="col">
						<p>* Pressione  CTRL  e clique nos eventos que deseja associar a este usuário.
						<br> Vale ressaltar que a lista exibe apenas eventos já criados.
						</p>
						
					</div>
				</div>-->
				<div class="row">
					<div class="col" style="display:flex; justify-content:center;">
						<button type="submit" id="cadastrar" class="btn btn-success"><i class="fas fa-save" style="margin-right: 15px"></i> CADASTRAR USUÁRIO</button>
					</div>
				</div>
					
				</div>	
			</form>
	</div>  


<script>
//Passa os ID para os Value das Permissões de Eventos
function passaIdParaValue(ele){
	var idevento = document.getElementById(ele.id).id;
	if ($('input.passaIdParaValue').is(':checked')) {
	   	document.getElementById(idevento).value = idevento;
  } else {
		document.getElementById(idevento).value = "";
  }
}

//Passa os valores 1 ou 0 para as permissões de páginas 
function permitirPagina(ele){
	var idpagina = document.getElementById(ele.id).id;
	if ($('input.permitirPagina').is(':checked')) {
	   	document.getElementById(idpagina).value = "1";
  } else {
		document.getElementById(idpagina).value = "0";
  }
}

////Selecionar todos os pedidos por cada sessão////

//Selecionar todos de PEDIDOS
$('#pedidos').click(function(event) {   
    if(this.checked) {
        $('.pedidos').each(function() {
            this.checked = true;
			this.value = 1;                        
        });
    } else {
        $('.pedidos').each(function() {
            this.checked = false;  
			this.value = 0;                        
        });
    }
});

//Selecionar todos de EVENTOS
$('#eventos').click(function(event) {   
    if(this.checked) {
        $('.eventos').each(function() {
            this.checked = true;
			this.value = 1;                         
        });
    } else {
        $('.eventos').each(function() {
            this.checked = false; 
			this.value = 0;                       
        });
    }
});

//Selecionar todos de INSCRITOS
$('#inscritos').click(function(event) {   
    if(this.checked) {
        $('.inscritos').each(function() {
            this.checked = true;  
			this.value = 1;                       
        });
    } else {
        $('.inscritos').each(function() {
            this.checked = false; 
			this.value = 0;                       
        });
    }
});

//Selecionar todos de FINANCEIRO
$('#financeiro').click(function(event) {   
    if(this.checked) {
        $('.financeiro').each(function() {
            this.checked = true; 
			this.value = 1;                        
        });
    } else {
        $('.financeiro').each(function() {
            this.checked = false;  
			this.value = 0;                      
        });
    }
});

//Selecionar todos de MARKETING
$('#marketing').click(function(event) {   
    if(this.checked) {
        $('.marketing').each(function() {
            this.checked = true;
			this.value = 1;                         
        });
    } else {
        $('.marketing').each(function() {
            this.checked = false; 
			this.value = 0;                       
        });
    }
});

//Selecionar todos de USUÁRIOS
$('#usuarios').click(function(event) {   
    if(this.checked) {
        $('.usuarios').each(function() {
            this.checked = true;  
			this.value = 1;                       
        });
    } else {
        $('.usuarios').each(function() {
            this.checked = false;   
			this.value = 0;                     
        });
    }
});

</script>
	
	<script>
			$(".toggle-password").click(function() {

			$(this).toggleClass("fa-eye fa-eye-slash");
			var input = $($(this).attr("toggle"));
			if (input.attr("type") == "password") {
			input.attr("type", "text");
			} else {
			input.attr("type", "password");
			}
			});
		</script>

	   <?php include_once("footer.php");?>
   </body>
</html>
