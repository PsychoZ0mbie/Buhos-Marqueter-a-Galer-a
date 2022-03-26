
<?php 

headerAdmin($data);

?>
<main class="app-content">
<?php
  if(empty($_SESSION['permisosMod']['r'])){
?>
  <p>Acceso denegado</p>
    <?php
      }else{?>
    
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> <?= $data['page_title'];?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?=base_url();?>/dashboard">Dashboard</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-user fa-3x"></i>
            <div class="info">
              <h4>Clientes</h4>
              <p><b><?=$data['clientes']?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-truck fa-3x"></i>
            <div class="info">
              <h4>Pedidos</h4>
              <p><b><?=$data['pedidos']?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-archive fa-3x"></i>
            <div class="info">
              <h4>Productos</h4>
              <p><b><?=$data['productos']?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-usd fa-3x"></i>
            <div class="info">
              <h4>Ventas</h4>
              <p><b><?=$data['ventas']?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-envelope fa-3x"></i>
            <div class="info">
              <h4>Mensajes</h4>
              <p><b><?=$data['mensajes']?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Últimos pedidos</h3>
            <div class="table-responsive">
              <table class="table" id="tableUltimos" name="tableUltimos">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody id="ultimosPedidos" name="ultimosPedidos">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
      <?php
        }
      ?>
    </main>
    <?php footerAdmin($data);?>