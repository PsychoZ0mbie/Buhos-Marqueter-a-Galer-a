<?php headerPage($data);
    /*$productos = $data['products'];
    $marqueteria = $data['marqueteria'];
    $galeria = $data['galeria'];
    $urlProducto = base_url()."/catalogo/producto/";*/
?>
<main  id="<?=$data['page_name']?>">
    <section>
        <div class="banner">
            <div class="row h-100 m-0">
              <div class="col-md-6 text-center p-0">
                <div class="banner-content p-0">
                  <h1 class="p-0">Marquetería tradicional y moderna</h1>
                  <h2 class="text__color p-0">Enmarca sin salir de casa</h2>
                  <a href="<?=base_url();?>/tienda/marqueteria" class="btn_content bg-dark text-white">Empieza a enmarcar <i class="fas fa-arrow-right"></i></a>
                </div>
              </div>
            </div>
        </div>
    </section>
    <section>
      <div class="container mt-5 mb-5">
        <div class="row">
          <div class="col-md-4 mt-4">
            <div class="service">
              <div class="service-img">
                <img src="<?=media()?>/template/assets/images/uploads/calidad.png" alt="molduras de calidad">
              </div>
              <h3>Materiales de calidad</h3>
            </div>
          </div>
          <div class="col-md-4 mt-4">
            <div class="service">
              <div class="service-img">
                <img src="<?=media()?>/template/assets/images/uploads/medida.png" alt="molduras hecho a mano">
              </div>
              <h3>Hecho a medida</h3>
            </div>
          </div>
          <div class="col-md-4 mt-4">
            <div class="service">
              <div class="service-img">
                <img src="<?=media()?>/template/assets/images/uploads/satisfaccion.png" alt="satisfacción al cliente">
              </div>
              <h3>Satisfacción garantizada</h3>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="container mt-5 mb-5">
        <div class="row">
          <div class="col-md-4 pt-3 pb-3">
            <div class="artwork">
              <img src="<?=media()?>/template/assets/images/uploads/imagen1.gif" alt="Urbanismo">
              <a class="artwork-btn" href="<?=base_url();?>/tienda/galeria">Urbanismo</a>
            </div>
          </div>
          <div class="col-md-4 pt-3 pb-3">
            <div class="artwork">
              <div class="artwork-content">
                <h2>Decora tu alrededor con nuestros cuadros</h2>
                <a href="<?=base_url();?>/tienda/galeria" class="btn_content">Comprar</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 pt-3 pb-3">
            <div class="artwork">
              <img src="<?=media()?>/template/assets/images/uploads/imagen2.gif" alt="Abstracto">
              <a class="artwork-btn" href="<?=base_url();?>/tienda/galeria">Abstracto</a>
            </div>
          </div>
          <div class="col-md-4 pt-3 pb-3">
            <div class="artwork">
              <img src="<?=media()?>/template/assets/images/uploads/imagen3.gif" alt="Rostros">
              <a class="artwork-btn" href="<?=base_url();?>/tienda/galeria">Rostros</a>
            </div>
          </div>
          <div class="col-md-4 pt-3 pb-3">
            <div class="artwork">
              <img src="<?=media()?>/template/assets/images/uploads/imagen4.gif" alt="Bodegón">
              <a class="artwork-btn" href="<?=base_url();?>/tienda/galeria">Bodegón</a>
            </div>
          </div>
          <div class="col-md-4 pt-3 pb-3">
            <div class="artwork">
              <img src="<?=media()?>/template/assets/images/uploads/imagen5.gif" alt="religión">
              <a class="artwork-btn" href="<?=base_url();?>/tienda/galeria">Religión</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="container">
        <h2 class="text__color text-center"><strong>Nuestras obras</strong></h2>
        <div class="row mb-5" id="itemsGallery"></div>
      </div>
    </section>
</main>
<?php footerPage($data);?>    
    
    