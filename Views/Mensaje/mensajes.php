<?php headerAdmin($data); ?>
<main class="app-content">
<?php
    getModal('modalContacto',$data);
?>  
    <?php
      if(empty($_SESSION['permisosMod']['r'])){

      
    ?>
    <p>Acceso denegado</p>

    <?php }else{?>
      <div class="app-title">
        <div>
            <h1><i class="fa fa-user"></i> <?= $data['page_title'] ?>
                <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Nuevo</button>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/mensajes"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
      <div class="row">
          <div class="col-md-12">
            <div class="tile">
              <div class="tile-body">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered" id="tableContacto">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>IP</th>
                        <th>Dispositivo</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
      </div>
      <?php }?>
    </main>
<?php footerAdmin($data); ?>
    