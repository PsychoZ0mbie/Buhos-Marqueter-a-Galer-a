<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="David Parrado">
    <meta name="theme-color" content="#009688">
    <link rel="shortcut icon" href="<?= media();?>/images/uploads/icon.gif">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/bootstrap/bootstrap.min.css?n=1">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/vali/main.css?n=1">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/vali/style.css?n=1">
    <!-- Font-icon css-->
    <link rel="stylesheet" href="<?= media();?>/css/icons/font-awesome.min.css?n=1">
    
    <title><?= $data['page_tag']; ?></title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content" id="<?=$data['page_name']?>">
      <div class="logo">
        <h1><?= $data['page_title']; ?></h1>
      </div>
      <div class="login-box flipped">
        <div id="divLoading" >
          <div>
            <img src="<?= media(); ?>/images/loading/loading.svg" alt="Loading">
          </div>
        </div>
        <form id="formCambiarPass" name="formCambiarPass" class="forget-form" action="">
          <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['idperson']; ?>" required >
          <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email']; ?>" required >
          <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token']; ?>" required >
          <h3 class="login-head"><i class="fas fa-key"></i> Cambiar contraseña</h3>
          <div class="form-group">
            <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Nueva contraseña" required >
          </div>
          <div class="form-group">
            <input id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control" type="password" placeholder="Confirmar contraseña" required >
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
          </div>
        </form>
      </div>
    </section>
    <script>
        const base_url = "<?= base_url(); ?>";
    </script>
    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/bootstrap/jquery-3.3.1.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap/bootstrap.min.js"></script>
    <script src="<?= media();?>/js/icons/fontawesome.js"></script>
    <script src="<?= media(); ?>/js/vali/main.js"></script>
    
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/tinymce/tinymce.min.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= media(); ?>/js/vali/pace.min.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/functions.js?n=1"></script>
    <script type="module" src="<?= media(); ?>/js/app.js?n=1"></script>
  </body>
</html>