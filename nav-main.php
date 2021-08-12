<nav class="navbar navbar-expand-lg navbar-dark bg-nav">
<div class="container">
    <div class="row" style="width: 100%">

      <div class="col">
        <a class="navbar-brand" href="<?php echo $path;?>eventos.php"><img src="<?php echo $path;?>assets/logo-afetur.png" width="120"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>

      <div class="col">
      <div class="collapse navbar-collapse" id="navbarNavDropdown" style="height: 65px;">
        <ul class="navbar-nav">
          

          
          
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-store icon-nav"></i> Pedidos
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php 
                    $menuPagos = '<a class="dropdown-item" href="'.$order.'escolhe-evento-pedido.php">Pagos</a>';
                    $menuPendentes = '<a class="dropdown-item" href="'.$order.'escolhe-evento-pedido-pendente.php">Pendentes</a>';
                    if($_SESSION['funcao'] == 1){
                            echo $menuPagos;
                            echo $menuPendentes;
                    }else{
                      foreach($lock as $lck){
                        if($lck['cod_pagina'] == 1 && $lck['ativo'] == 1){
                            echo $menuPagos;
                        }
                        if($lck['cod_pagina'] == 2 && $lck['ativo'] == 1){
                            echo $menuPendentes;
                        }
                      }
                    }
                  ?>
                  <!--<a class="dropdown-item" href="pagseguro/status-pedidos.php">Status</a>-->
              </div>
            </li>
          

      
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-calendar-alt icon-nav"></i> Eventos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <?php 
                    $menuCriaEvento = '<a class="dropdown-item" href="'.$path.'cd_eventos.php">Criar evento</a>';
                    $menuListaEvento = '<a class="dropdown-item" href="'.$path.'eventos.php">Lista de Eventos</a>';
                    if($_SESSION['funcao'] == 1){
                            echo $menuCriaEvento;
                            echo $menuListaEvento;
                    }else{
                      foreach($lock as $lck){
                        if($lck['cod_pagina'] == 3 && $lck['ativo'] == 1){
                            echo $menuCriaEvento;
                        }
                        if($lck['cod_pagina'] == 4 && $lck['ativo'] == 1){
                            echo $menuListaEvento;
                        }
                      }
                    }
                  ?>
            </div>
          </li>
          

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-check icon-nav"></i> Inscritos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php 
                    $menuVerInscritos = '<a class="dropdown-item" href="'.$path.'inscritos.php">Ver inscritos</a>';
                    $menuAdicionarInscritos = '<a class="dropdown-item" href="'.$path.'escolhe-evn-inscricao.php">Adicionar inscrição</a>';
                    if($_SESSION['funcao'] == 1){
                            echo $menuVerInscritos;
                            echo $menuAdicionarInscritos;
                    }else{
                      foreach($lock as $lck){
                        if($lck['cod_pagina'] == 5 && $lck['ativo'] == 1){
                            echo $menuVerInscritos;
                        }
                        if($lck['cod_pagina'] == 6 && $lck['ativo'] == 1){
                            echo $menuAdicionarInscritos;
                        }
                      }
                    }
                  ?>
            </div>
          </li>


          
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-dollar-sign icon-nav"></i> Financeiro
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php 
                    $menuVerFinanceiro = '<a class="dropdown-item" href="'.$path.'financeiro.php">Ver financeiro</a>';
                    $menuBoletos = '<a class="dropdown-item" href="'.$path.'escolhe-evn-boletos.php">Boletos</a>';
                    if($_SESSION['funcao'] == 1){
                            echo $menuVerFinanceiro;
                            echo $menuBoletos;
                    }else{
                      foreach($lock as $lck){
                        if($lck['cod_pagina'] == 7 && $lck['ativo'] == 1){
                            echo $menuVerFinanceiro;
                        }
                        if($lck['cod_pagina'] == 8 && $lck['ativo'] == 1){
                            echo $menuBoletos;
                        }
                      }
                    }
                  ?>
              </div>
            </li>


 
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-lightbulb icon-nav"></i> Marketing
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php 
                    $menuEmailMarketing = '<a class="dropdown-item" href="'.$path.'escolhe-evn-email-marketing.php">E-mail Marketing</a>';
                    $menuEmailRemetente = '<a class="dropdown-item" href="'.$path.'email-smtp.php">E-mail Remetente</a>';
                    $menuListaEmails = '<a class="dropdown-item" href="'.$path.'lista-emails.php">Listas de E-mails</a>';
                    $menuFacebook = '<a class="dropdown-item" href="'.$path.'escolhe-evn-inscricao.php">Facebook</a>';
                    if($_SESSION['funcao'] == 1){
                            echo $menuEmailMarketing;
                            echo $menuEmailRemetente;
                            echo $menuListaEmails;
                            echo $menuFacebook;
                    }else{
                      foreach($lock as $lck){
                        if($lck['cod_pagina'] == 9 && $lck['ativo'] == 1){
                            echo $menuEmailMarketing;
                        }
                        if($lck['cod_pagina'] == 10 && $lck['ativo'] == 1){
                            echo $menuEmailRemetente;
                        }
                        if($lck['cod_pagina'] == 11 && $lck['ativo'] == 1){
                            echo $menuListaEmails;
                        }
                        if($lck['cod_pagina'] == 12 && $lck['ativo'] == 1){
                            echo $menuFacebook;
                        }
                      }
                    }
                  ?>
            </div>
          </li>



          <li class="nav-item dropdown" >
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-lock icon-nav"></i> Usuários
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php 
                    $menuUsuarios = '<a class="dropdown-item" href="'.$path.'usuarios.php">Usuários</a>';
                    $menuAdicionarUsuario = '<a class="dropdown-item" href="'.$path.'cd-usuarios.php">Adicionar usuário</a>';
                    if($_SESSION['funcao'] == 1){
                            echo $menuUsuarios;
                            echo $menuAdicionarUsuario;
                    }else{
                      foreach($lock as $lck){
                        if($lck['cod_pagina'] == 13 && $lck['ativo'] == 1){
                            echo $menuUsuarios;
                        }
                        if($lck['cod_pagina'] == 14 && $lck['ativo'] == 1){
                            echo $menuAdicionarUsuario;
                        }
                        
                      }
                    }
                  ?>
            </div>
          </li>

        
          <!--<li class="nav-item" style="width: 115px;">
            <a class="nav-link" href="log.php">Logs</a>
          </li>-->


          <li class="nav-item" style="width: 0px;">
            <a class="nav-link" href="login-seguro/logout.php"><i class="fas fa-power-off mr-2" style="color:#fbff12"></i></a>
          </li>
      
        </ul>
      </div>
      </div>
      
      </div>
  </div>
</nav>