<?php
include("valida_pagina.php");

if($_SESSION['funcao'] == 1){
$query = "SELECT * FROM evn_eventos ORDER BY data_inicio desc";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$totalRows_eventos = mysqli_num_rows($eventos);
}else{
$query = "SELECT * FROM evn_permissao INNER JOIN evn_eventos ON evn_permissao.ref_perm = evn_eventos.ref WHERE evn_permissao.usuario_perm = '$user' ORDER BY evn_eventos.data_inicio desc";
$eventos = mysqli_query($link, $query) or die(mysqli_error($link));
$totalRows_eventos = mysqli_num_rows($eventos);
}

function encurtar_com_bitly( $url = "" ) {
     if( !empty( $url ) ) {
          $login = "afeturturismo"; //Informe seu nome de usuário
          $api_key = "R_edd6e5ebd16546c395c46128e56a20ab"; //Informe sua chave
          $api_url = 'http://api.bit.ly/shorten?version=2.0.1&longUrl=' . urlencode( $url ) . '&login=' . $login . '&apiKey=' . $api_key . '&format=json';
          $response = @json_decode( file_get_contents( $api_url ), true );
          return isset( $response['results'][ $url ]['shortUrl'] ) ? $response['results'][ $url ]['shortUrl'] : false;
     } else {
          return false;
     }
}
$host = $_SERVER['HTTP_HOST'];
?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="utf-8"/>
      <title>Lista de Eventos - Afetur Eventos</title>
	    <?php include('head.php');?>

      <script language="JavaScript" type="text/javascript">

      $(document).ready(function(){
          $("a.remove").click(function(e){
              if(!confirm('Tem certeza que deseja excluir?')){
                  e.preventDefault();
                  return false;
              }
              return true;
          });
      });
      </script>
		
  </head>
   <body>
       
	   <?php
		require_once('nav-main.php');
	   ?>

	<div class="container content" style="min-height: 780px;">
      <h3 style="margin-top: 20px;">
        <i class="fas fa-calendar-alt icon-nav"></i> Eventos 
        <a class="btn btn-primary" href="cd_eventos.php" role="button" style="margin-left: 10px;"><i class="fas fa-calendar-plus" style="margin-right: 15px;"></i> Criar evento</a>
      </h3>
			<div class="row">
			
				<div class="col">
				<div class="table-responsive">
					<table class="table">
					  <thead class="thead-dark">
						<tr>
						  	<th scope="col" class="textcenter">Código</th>
						  	<th scope="col" class="textcenter">Logo</th>
						  	<th scope="col" class="textcenter">Evento</th>
						  	<th scope="col" class="textcenter">Período</th>
						  	<th scope="col" class="textcenter">Local</th>
							<th scope="col" class="textcenter"><i class="fas fa-link"></i></th>
							<th scope="col" class="textcenter"><i class="fas fa-eye"></i></th>
							<th scope="col" class="textcenter">Ações</th>
						  	<th scope="col" class="textcenter"><i class="fas fa-wrench"></i></th>
						  	<th scope="col" class="textcenter"><i class="fas fa-trash-alt"></i></th>
						  	<th scope="col" class="textcenter"></th>
						</tr>
					  </thead>
					  <tbody>
					  <?php while ($row_eventos = mysqli_fetch_array($eventos)){ ?>
						<tr>
						  <th scope="row" align="center" style="vertical-align: middle !important;"><?php echo $row_eventos['ref']; ?></th>
						  <th scope="row" align="center" style="vertical-align: middle !important;"><img src="<?php echo "https://".$host."/eventos/".$row_eventos['logo']; ?>" width="150" height="150"/></th>
						  <td align="center" style="vertical-align: middle !important;"><?php echo $row_eventos['nome_evento']; ?></td>
						  <td align="center" style="vertical-align: middle !important;"><?php if($row_eventos['data_inicio'] == $row_eventos['data_final']){ echo date('d/m/Y', strtotime($row_eventos['data_inicio']));}else{echo date('d/m/Y', strtotime($row_eventos['data_inicio']))." at&eacute; ".date('d/m/Y', strtotime($row_eventos['data_final']));} ?></td>
						  <td align="center" style="vertical-align: middle !important;"><?php echo $row_eventos['local_nome']; ?></td>
						  <td align="center" style="vertical-align: middle !important;"><button class="btn" data-clipboard-text="<?php echo encurtar_com_bitly("https://".$host."/eventos/evento_single.php?ref=".$row_eventos['ref']);?>" title="Copiar link do evento"><i class="fas fa-link"></i></button> </td>
						  <td align="center" style="vertical-align: middle !important;"><a title="Ver evento" href="evento_single.php?ref=<?php echo $row_eventos['ref'];?>" target="_blank"><i class="fas fa-eye"></i></a></td>
						  <td style="vertical-align: middle !important;">
						  <div class="btn-group">
							<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Ações
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="edt-foto-evento.php?ref=<?php echo $row_eventos['ref'];?>"><i class="fas fa-image"></i> Trocar Capa</a>
								<a class="dropdown-item" href="edt-logo-evento.php?ref=<?php echo $row_eventos['ref'];?>"><i class="fas fa-adjust"></i> Trocar logotipo</a>
								<a class="dropdown-item" href="edt-logo-sec-evento.php?ref=<?php echo $row_eventos['ref'];?>"><i class="fas fa-hat-wizard"></i> Trocar logotipo topo</a>
								<a class="dropdown-item" href="edt-identidade-cracha.php?ref=<?php echo $row_eventos['ref'];?>"><i class="fas fa-id-card"></i> Visual do Crachá</a>
							</div>
							</div>
						  </td>
						  <td style="vertical-align: middle !important;"><a title="Editar evento" href="edt-evento.php?ref=<?php echo $row_eventos['ref'];?>"><i class="fas fa-wrench"></i></a></td>
						  <td style="vertical-align: middle !important;"><a title="Excluir evento" href="exc-evento.php?ref=<?php echo $row_eventos['ref'];?>&nome=<?php echo $_SESSION['nome'];?>" class="remove"><i class="fas fa-trash-alt"></i></a></td>
						 

							<td style="vertical-align: middle !important;">
							
							<form id="formName" action="proc-update-evento.php" method="post">
							<input name="nme" type="hidden" id="nme" value="<?php echo $_SESSION['nome'];?>">
								<?php if($row_eventos["ativo"] == 0){?>
								<div class="switch">
								<input type="checkbox" name="option" id="option" value="1" onChange="this.form.submit()"/>
								<input type="hidden" name="id_evento" id="id_evento" value="<?php echo $row_eventos["id_evento"]; ?>"/>
								<input type="hidden" name="ref" id="ref" value="<?php echo $row_eventos["ref"]; ?>"/>
								<label for="option"><span></span></label>
								</div>
								<?php }else{?>
								<div class="switch">
								<input type="checkbox" name="option" id="option" value="0" checked onChange="this.form.submit()"/>

								<input type="hidden" name="id_evento" id="id_evento" value="<?php echo $row_eventos["id_evento"]; ?>"/>
								<input type="hidden" name="ref" id="ref" value="<?php echo $row_eventos["ref"]; ?>"/>
								<label for="option"><span></span></label>
								</div>
								<?php } ?>
								
							</form>
							
								
							</td>
						</tr>
						<?php } ?>
					  </tbody>
					</table>
</div>
				</div>
			</div>
	</div>  
	   <?php include_once("footer.php");?>
	   
	   <script src="clipboard/dist/clipboard.min.js"></script>
	   <script>
    var clipboard = new ClipboardJS('.btn');

    clipboard.on('success', function(e) {
        console.log(e);
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });
    </script>
   </body>
</html>


