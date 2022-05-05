<?php
    $cantCarrito = 0;
    $titulo = NOMBRE_EMPRESA;
    $urlWeb = base_url();
    $urlImg;
    //dep($data['product']);
    if(!empty($data['product'])){
        $urlWeb = base_url()."/tienda/producto/".$data['product']['route'];
        $urlImg = $data['product']['url'][0];
        $titulo = $data['product']['title'];
    }
    
    if(isset($_SESSION['arrCarrito']) && $_SESSION['arrCarrito']>0){
        foreach ($_SESSION['arrCarrito'] as $key) {
            $cantCarrito += $key['cantidad'];
        }
    }
    //dep($_SESSION['arrCarrito']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=DESCRIPCION?>">
    <meta name="author" content="<?=NOMBRE_EMPRESA?>" />
    <meta name="copyright" content="<?=NOMBRE_EMPRESA?>"/>
    <meta name="robots" content="index,follow"/>
    <title><?= $data['page_tag'];?></title>
    <link rel ="shortcut icon" href="<?=media();?>/template/Assets/images/uploads/icon.gif" sizes="114x114" type="image/png">
    
    <meta property="fb:app_id"          content="1234567890" /> 
    <meta property="og:locale" 		content='es_ES'/>
    <meta property="og:type"        content="article" />
    <meta property="og:site_name"	content="<?= NOMBRE_EMPRESA; ?>"/>
    <meta property="og:description" content="<?=DESCRIPCION?>"/>
    <meta property="og:title"       content="<?= $titulo; ?>" />
    <meta property="og:url"         content="<?= $urlWeb; ?>" />
    <meta property="og:image"       content="<?= $urlImg; ?>" />
    <meta name="twitter:card" content="summary"></meta>
    <meta name="twitter:site" content="<?= $urlWeb; ?>"></meta>
    <meta name="twitter:creator" content="<?= NOMBRE_EMPRESA; ?>"></meta>
    <link rel="canonical" href="<?= $urlWeb?>"/>
    
    <script src="https://kit.fontawesome.com/3207833fba.js" crossorigin="anonymous"></script>
    <!--Resources styles-->
    <link rel="stylesheet" href="<?=media();?>/template/Assets/css/bootstrap/bootstrap.min.css">
    <!-- My css -->
    <link rel="stylesheet" href="<?=media();?>/template/Assets/css/style.css">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8MPBNE6BYH"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-8MPBNE6BYH');
    </script>
    
    <meta name="google-site-verification" content="6ieP5zkMXFQodaRSo9W_d40VtMlW8zGO-jZ5s_xE7Sg" />
</head>
<body>

   <header>
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?=base_url();?>">
                <img src="<?=media();?>/template/Assets/images/uploads/icon.gif" alt="Logo">
                <p><strong>Buho's</strong></p>
                <p><strong>Marquetería & Galería</strong></p>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?=base_url();?>">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Tienda
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?=base_url();?>/tienda/marqueteria">Marquetería</a></li>
                            <li><a class="dropdown-item" href="<?=base_url();?>/tienda/galeria">Galería</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=base_url();?>/nosotros">Nosotros</a>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link" href="<?=base_url();?>/servicios">Servicios</a>
                    </li>-->
                    <li class="nav-item">
                        <a class="nav-link" href="<?=base_url();?>/contacto">Contacto</a>
                    </li>
                    <?php
                        if(isset($_SESSION['login'])){
                        
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Mi cuenta
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?=base_url();?>/usuarios/perfil">Perfil</a></li>
                            <li><a class="dropdown-item" href="<?=base_url();?>/logout">Cerrar sesión</a></li>
                        </ul>
                    </li>
                    <?php }else{?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=base_url();?>/cuenta">Mi cuenta</a>
                    </li>
                    <?php }?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=base_url();?>/tienda/carrito" id="cantCarrito"><i class="fas fa-shopping-cart"> (<?=$cantCarrito?>)</i></a>
                    </li>
                </ul>
                <!--
                -->
            </div>
        </div>
      </nav>
   </header> 
    