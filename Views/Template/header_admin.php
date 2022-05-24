
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?=DESCRIPCION?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content ="David Pg">
    <meta name = "theme-color" content="#009688">
    <link rel ="shortcut icon" href="<?= media();?>/images/uploads/icon.gif">
    <title><?= $data['page_tag'];?></title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/bootstrap/bootstrap.min.css?n=1">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/vali/main.css?n=1">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/vali/style.css?n=1">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/normalize.css?n=1">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/style.css?n=1">
    <!-- Font-icon css-->
    <link rel="stylesheet" href="<?= media();?>/css/icons/font-awesome.min.css?n=1">
  </head>
  <body class="app sidebar-mini">
    <div id="divLoading">
        <img src="<?= media();?>/images/loading/loading.svg" alt="Loading">
    </div>
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?=base_url();?>" target="_blank">Buhos</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle fa fa-bars pt-3 pb-2" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <!--<li><a class="dropdown-item" href="<?=base_url();?>/opciones"><i class="fa fa-cog fa-lg"></i> Opciones</a></li>-->
            <li><a class="dropdown-item" href="<?=base_url();?>/Usuarios/perfil"><i class="fa fa-user fa-lg"></i> Perfil</a></li>
            <li><a class="dropdown-item" href="<?=base_url();?>/logout"><i class="fa fa-sign-out fa-lg"></i> Cerrar sesión</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <?php require_once("nav_admin.php");?>