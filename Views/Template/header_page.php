<?php
    $cantCarrito = 0;
    if(isset($_SESSION['arrCarrito']) && $_SESSION['arrCarrito']>0){
        foreach ($_SESSION['arrCarrito'] as $key) {
            $cantCarrito += $key['cantidad'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buhos Marquetería & Galería</title>

    <link rel ="shortcut icon" href="<?=media();?>/template/Assets/images/uploads/icon.gif" sizes="32x32" type="image/png">
    <script src="https://kit.fontawesome.com/3207833fba.js" crossorigin="anonymous"></script>
    <!--Resources styles-->
    <link rel="stylesheet" href="<?=media();?>/template/Assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=media();?>/template/Assets/css/simple-lightbox.min.css">
    <!-- My css -->
    <link rel="stylesheet" href="<?=media();?>/template/Assets/css/style.css">
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
                    <li class="nav-item">
                        <a class="nav-link" href="<?=base_url();?>/nosotros">Nosotros</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Catálogo
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?=base_url();?>/catalogo/marqueteria">Marquetería</a></li>
                            <li><a class="dropdown-item" href="<?=base_url();?>/catalogo/galeria">Galería</a></li>
                            <li><a class="dropdown-item" href="#">Trabajos realizados</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=base_url();?>/servicios">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=base_url();?>/contacto">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=base_url();?>/catalogo/carrito" id="cantCarrito"><i class="fas fa-shopping-cart"> (<?=$cantCarrito?>)</i></a>
                    </li>
                </ul>
            </div>
        </div>
      </nav>
   </header> 
    