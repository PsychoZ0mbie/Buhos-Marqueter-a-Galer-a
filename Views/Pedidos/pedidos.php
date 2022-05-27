<?php headerAdmin($data); ?>
    <main class="app-content" id="<?=$data['page_name']?>">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-picture-o"></i> <?=$data['page_title']?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#"><?=$data['page_title']?></a></li>
        </ul>
      </div>
      <div id="modalItem"></div>
      <div class="item_list" id="listItem" name="listItem">
          <div class="row">
            <div class="col-md-6">
              <input class="form-control" type="search" placeholder="buscar" aria-label="Search" id="search" name="search">
            </div>
            <div class="col-md-6">
              <select class="form-control form-control" aria-label="Default select example" id="orderBy" name="orderBy">
                <option value="1">Ordenar por más reciente</option>
                <option value="2">Ordenar por más antiguo</option>
                <option value="3">Ordenar por estado</option>
              </select>
            </div>
          </div>
      </div>
      <div id="detailItem" class="d-none">
        <button class="btn btn-info" id="btnBack">Regresar</button>
        <div class="format mt-4">
          <div class="format__decoration"></div>
          <div class="format__info row">
            <div class="format__info__logo col-md-6">
              <img src="<?=media();?>/template/Assets/images/uploads/logo.png" alt="">
              <ul>
                <li><?=NOMBRE_EMPRESA?></li>
                <li><?=DIRECCION?></li>
                <li><?=TELEFONO?></li>
                <li><?=EMAIL_REMITENTE?></li>
              </ul>
            </div>
            <div class="format__info__data col-md-6">
              <h2 class="text-secondary">Factura</h2>
              <p class="text-info">Fecha</p>
              <p id="fecha">10/05/2022</p>
              <p class="text-info">Nro. de factura</p>
              <p id="orden">1</p>
            </div>
          </div>
          <div class="format__customer">
              <div class="format__customer__data mb-3 mt-5 row">
                  <div class="col-md-4">
                    <p class="text-info mb-4 mt-2"><strong>Cliente</strong></p>
                    <p id="nombre">David Parrado</p>
                    <p id="identificacion">1121964592</p>
                    <p id="email">davidstiven1999@hotmail.com</p>
                    <p id="telefono">3193094264</p>
                  </div>
                  <div class="col-md-4">
                    <p class="text-info mb-4 mt-2"><strong>Datos de envio</strong></p>
                    <p id="lugar">Villavicencio/meta</p>
                    <p id="direccion">cra 36 n 15a-03</p>
                  </div>
                  <div class="col-md-4">
                    <p class="text-info mb-4 mt-2"><strong>Observaciones/Comentarios</strong></p>
                    <p id="comentario">Villavicencio/meta</p>
                  </div>
              </div>
              <div class="format__customer__order">
                <table class="table">
                  <thead class="format__decoration text-white">
                    <tr>
                      <th scope="col" >Descripción</th>
                      <th scope="col">Cantidad</th>
                      <th scope="col">Precio</th>
                      <th scope="col">Total</th>
                    </tr>
                  </thead>
                  <tbody id="productos">
                    
                  </tbody>
                  <tfoot>
                      <tr>
                        <th colspan="3" class="text-right">Subtotal:</th>
                        <td class="text-right" id="subtotal">$50.000</td>
                      </tr>
                      <!--<tr>
                        <th colspan="3" class="text-right">IVA:</th>
                        <td class="text-right" id="iva">$50.000</td>
                      </tr>-->
                      <tr>
                        <th colspan="3" class="text-right">Total:</th>
                        <td class="text-right" id="total">$25.000.000</td>
                      </tr>
                  </tfoot>
                </table>
              </div> 
          </div>
          <div class="format__decoration"></div>
        </div>
      </div>
    </main>
<?php footerAdmin($data); ?>