<?php headerPage($data);
    /*$productos = $data['products'];
    $marqueteria = $data['marqueteria'];
    $galeria = $data['galeria'];
    $urlProducto = base_url()."/catalogo/producto/";*/
?>
<main  id="<?=$data['page_name']?>">
    <section>
        <div class="presentation_video">
            <video autoplay="autoplay" loop="loop" muted playsinline preload="auto" oncontextmenu="return false;">
                <source src="<?=media();?>/images/uploads/video.mp4" type="video/mp4">
            </video>
            <div class="presentation_title text-center">
                <h1>Marquetería tradicional y moderna, enmarca sin salir de casa!</h1>
                <a href="<?=base_url()?>/tienda/marqueteria" class="btn_content">Empezar ya</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container services">
          <h2 class="text__color text-center mt-4"><strong>Marquetería y galería a tu gusto</strong></h1>
          <div class="row">
            <div class="col-lg-4">
              <div class="services_item">
                <i class="fas fa-certificate"></i>
                <h3>Material de calidad</h3>
                <p>Todos nuestros materiales son escogidos para garantizar la conservación de todos nuestros trabajos.
                </p>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="services_item">
                <i class="fas fa-ruler"></i>
                <h3>Hecho a mano y a medida</h3>
                <p>Todos nuestros marcos y obras son hechos a mano y a las medidas requeridas por el cliente.</p>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="services_item">
                <i class="fas fa-grin-beam"></i>
                <h3>Satisfacción garantizada</h3>
                <p>Las mejores soluciones para las necesidades de nuestros clientes, garantizando siempre el gusto y la satisfacción por nuestro trabajo.</p>
              </div>
            </div>
          </div>
        </div>
    </section>
    <section>
        <div class="container text-center cover_presentation">
            <h2><strong>Nuestras obras</strong></h2>
        </div>
        <div class="d-flex justify-content-center flex-wrap position-relative mt-4" id="itemsGallery"></div>
    </section>
</main>
<?php footerPage($data);?>    
    
    