<?php headerAdmin($data);?> 
<main class="app-content">

<?php
    getModal('modalPedido',$data);
    if(empty($_SESSION['permisosMod']['r'])){
?>
    <p>Acceso denegado</p>

    <?php 
    }else{?>
      <div class="app-title">
        <div>
            <h1><i class="fa fa-truck"></i> <?= $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/pedidos"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="pills-products-tab" data-toggle="pill" href="#pills-products" role="tab" aria-controls="pills-products" aria-selected="true">Pedidos</a>
        </li>
        <?php if($_SESSION['permisosMod']['r']){?>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pills-make-tab" data-toggle="pill" href="#pills-make" role="tab" aria-controls="pills-make" aria-selected="false">Detalle del pedido</a>
        </li>
        <?php }?>  
      </ul>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-products" role="tabpanel" aria-labelledby="pills-products-tab">
          <div class="row">
              <div class="col-md-12">
                <div class="tile">
                  <div class="tile-body">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered w-100" id="tablePedidos">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
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
        </div>
        <div class="tab-pane fade" id="pills-make" role="tabpanel" aria-labelledby="pills-make-tab">
          <div class="container factura">
            <div class="row">
              <div class="col-md-6 d-flex flex-column align-items-center">
                  <img src="<?=media()?>/images/uploads/logo.png" width="150px" height="150px">
                  <P><?=DIRECCION?></P>
                  <P><?=TELEFONO?></P>
                  <P><?=EMAIL_REMITENTE?></P>
              </div>
              <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                <h2>Orden</h2>
                <strong>Fecha</strong>
                <p id="fecha"></p>
                <strong>N° de orden</strong>
                <p id="numOrden"></p>
              </div>
            </div>
            <hr>
            <div class="row d-flex justify-content-center">
              <div class="col-md-6">
                <h3>Datos del cliente</h3>
                <ul>
                  <li><strong>Nombre: </strong><p id="nombre"></p></li>
                  <li><strong>CC: </strong><p id="identificacion"></p></li>
                  <li><strong>Email: </strong><p id="email"></p></li>
                  <li><strong>Teléfono: </strong><p id="telefono"></p></li>
                </ul>
              </div>
              <div class="col-md-6">
                <h3>Datos de envio</h3>
                <ul>
                  <li><strong>Departamento: </strong><p id="departamento"></p></li>
                  <li><strong>Ciudad: </strong><p id="ciudad"></p></li>
                  <li><strong>Dirección: </strong><p id="direccion"></p></li>
                </ul>
              </div>
            </div>
            <table class="w-100">
              <thead>
                <tr class="bg-warning">
                  <th>Descripción</th>
                  <th>Precio</th>
                  <th>Cantidad</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody id="detalle">
                <tr>
                  <td id="descripcion"></td>
                  <td id="precio"></td>
                  <td id="cantidad"></td>
                  <td id="total"></td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3" class="text-right">Subtotal:</th>
                  <td id="subtotal"></td>
                </tr>
                <tr>
                  <th colspan="3" class="text-right">Envío:</th>
                  <td>Pago contra entrega</td>
                </tr>
                <tr>
                  <th colspan="3" class="text-right">Total:</th>
                  <td id="totalprecio"></td>
                </tr>
              </tfoot>
            </table>
            <button id ="btnCancel" class="btn btn-secondary btn-lg btn-block" onclick="location.reload()" type="button" data-dismiss="modal">Regresar</button>
          </div>
        </div>
      </div>
        
        <?php }?>
    </main>
<?php footerAdmin($data); ?>
    