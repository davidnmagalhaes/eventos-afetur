<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
<div class="row" style="width: 100%">
<div class="col">
  <a class="navbar-brand" href="../eventos.php"><img src="../assets/logo-afetur.png" width="120"/></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  </div>
  <div class="col">
  <div class="collapse navbar-collapse" id="navbarNavDropdown" style="height: 65px;">
    <ul class="navbar-nav">
      <?php if($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2 || $_SESSION['nivel'] == 3){?>
      <li class="nav-item dropdown" style="width: 115px;">
		<a class="nav-link dropdown-toggle" href="inscritos.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Pedidos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		<a class="dropdown-item" href="pedidos.php">Pagos</a>
          <a class="dropdown-item" href="pedidos-pendentes.php">Pendentes</a>
		  <?php if($_SESSION['nivel'] == 3){?>
		  <a class="dropdown-item" href="status-pedidos.php">Status</a>
          <?php } ?>
        </div>
      </li>
      <?php } ?>
	  <?php if($_SESSION['nivel'] == 3){?>
      <li class="nav-item dropdown" style="width: 115px;">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Eventos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="../cd_eventos.php">Criar evento</a>
          <a class="dropdown-item" href="../eventos.php">Lista de Eventos</a>
          
        </div>
      </li>
	  <?php } ?>
	   <?php if($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2 || $_SESSION['nivel'] == 3){?>
	  <li class="nav-item dropdown" style="width: 115px;">
		<a class="nav-link dropdown-toggle" href="inscritos.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Inscritos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		<a class="dropdown-item" href="../inscritos.php">Ver inscritos</a>
          <a class="dropdown-item" href="../escolhe-evn-inscricao.php">Adicionar inscrição</a>
          
        </div>
      </li>
	  <?php } ?>
	  <?php if($_SESSION['nivel'] == 2 || $_SESSION['nivel'] == 3){?>
	  <li class="nav-item" style="width: 115px;">
        <a class="nav-link" href="../financeiro.php">Financeiro</a>
      </li>
	  <?php } ?>
	  <?php if($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 3){?>
	  <li class="nav-item dropdown" style="width: 115px;">
		<a class="nav-link dropdown-toggle" href="inscritos.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Marketing
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		<a class="dropdown-item" href="../escolhe-evn-email-marketing.php">E-mail Marketing</a>
		<a class="dropdown-item" href="../email-smtp.php">E-mail Remetente</a>
		<a class="dropdown-item" href="../lista-emails.php">Listas de E-mails</a>
          <a class="dropdown-item" href="../escolhe-evn-inscricao.php">Facebook</a>
          
        </div>
      </li>
	  <?php } ?>
	  <?php if($_SESSION['nivel'] == 3){?>
	  <li class="nav-item dropdown" style="width: 115px;">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Usuários
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		<a class="dropdown-item" href="../usuarios.php">Usuários</a>
          <a class="dropdown-item" href="../cd-usuarios.php">Adicionar usuário</a>
          
        </div>
      </li>
	  <?php }?>
    </ul>
	<!--
	<form class="form-inline my-2 my-lg-0" style="width: 330px;" method="post" action="pesquisar.php">
      <input class="form-control mr-sm-2" type="search" placeholder="Pesquisar evento" aria-label="Search" name="pesquisar">
      <button class="btn btn-primary my-2 my-sm-0" type="submit">Pesquisar</button>
    </form>
	-->
		<i class="fas fa-power-off mr-2" style="color:#fff;float:left"></i><a href="sair.php" style="color: #fff; float:left;">Sair</a>

  </div>
  </div>

  </div>
  </div>
</nav>