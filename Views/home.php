<?php headerPage($data);
    $productos = $data['products'];
    $marqueteria = $data['marqueteria'];
    $galeria = $data['galeria'];
    $urlProducto = base_url()."/catalogo/producto/";
?>
<main>
       <section>
           <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
               <div class="carousel-inner">
                   <div class="carousel-item active">
                      <a href="<?=base_url()?>/catalogo/marqueteria">
                        <img src="https://2.bp.blogspot.com/-Oe0RrOx3fKQ/VfSRJGkocxI/AAAAAAAAVdA/YCLW-yK-8ak/w1200-h630-p-k-no-nu/marqueteria%2Btaraseado%2Bhimitsu%2Bboken%2Bsanta%2Bmaria%2Bdel%2Brio.png" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h1>Dale estilo a tus cuadros con las mejores molduras</h1>
                        </div>
                      </a>
                   </div>
                   <div class="carousel-item">
                      <a href="<?=base_url()?>/catalogo/galeria">
                        <img src="https://2.bp.blogspot.com/-Oe0RrOx3fKQ/VfSRJGkocxI/AAAAAAAAVdA/YCLW-yK-8ak/w1200-h630-p-k-no-nu/marqueteria%2Btaraseado%2Bhimitsu%2Bboken%2Bsanta%2Bmaria%2Bdel%2Brio.png" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h1>Obras cargadas con emoción y creatividad</h1>
                        </div>
                      </a>
                   </div>
               </div>
           </div>
       </section>
       <section>
            <div class="container text-center mt-5 cover_presentation">
                <a href="<?=base_url()?>/catalogo/marqueteria" class="text-decoration-none"><h2><strong>Marquetería</strong></h2></a>
            </div>
            <div class="catalog">
                <?php
                    for ($i=0; $i < count($marqueteria) ; $i++) { 
                        # code...
                    
                ?>
                <div class="catalog_product shadow p-3 mb-5 bg-body rounded">
                    <div class="catalog_product_image">
                        <img src="<?= $marqueteria[$i]['url_image']?>" alt="<?= $marqueteria[$i]['title']?>">
                        <a href="<?=$urlProducto.$marqueteria[$i]['route']?>" class="btn_content">Ver más</a>
                    </div>
                    <div class="catalog_product_text">
                        <a href=""><h2><strong><?= $marqueteria[$i]['title']?></strong></h2></a>
                        <h3><?= $marqueteria[$i]['categoria']?></h3>
                        <?php
                        if($marqueteria[$i]['subtopicid'] != 6){
                        ?>
                        <p><?= $marqueteria[$i]['subcategoria']?></p>
                        <?php }?>
                        <?php if($marqueteria[$i]['stock']==0){ ?>
                        <p class="text-danger">Agotado</p>
                        <?php }else{?>
                            <p><?= MS.$marqueteria[$i]['price'].MD?></p>
                        <?php }?>
                    </div>
                </div>
                <?php }?>
            </div>
        </section>
        <section>
            <div class="container text-center mt-5 cover_presentation">
                <a href="<?=base_url()?>/catalogo/galeria" class="text-decoration-none"><h2><strong>Galería</strong></h2></a>
            </div>
            <div class="catalog">
                <?php
                    for ($i=0; $i < count($galeria) ; $i++) { 
                        # code...
                    
                ?>
                <div class="catalog_product shadow p-3 mb-5 bg-body rounded">
                    <div class="catalog_product_image">
                        <img src="<?= $galeria[$i]['url_image']?>" alt="<?= $galeria[$i]['title']?>">
                        <a href="<?=$urlProducto.$galeria[$i]['route']?>" class="btn_content">Ver más</a>
                    </div>
                    <div class="catalog_product_text">
                        <a href=""><h2><strong><?= $galeria[$i]['title']?></strong></h2></a>
                        <h3><?= $galeria[$i]['categoria']?></h3>
                        <?php
                        if($galeria[$i]['subtopicid'] != 6){
                        ?>
                        <p><?= $galeria[$i]['subcategoria']?></p>
                        <?php }?>
                        <?php if($galeria[$i]['stock']==0){ ?>
                        <p class="text-danger">Agotado</p>
                        <?php }else{?>
                            <p><?= MS.$galeria[$i]['price'].MD?></p>
                        <?php }?>
                    </div>
                </div>
                <?php }?>
            </div>
        </section>
        
        <section>
            <div class="container text-center mt-5 cover_presentation">
                <h2><strong>Productos más recientes</strong></h2>
            </div>
            <div class="catalog">
                <?php
                    for ($i=0; $i < count($productos) ; $i++) { 
                        # code...
                    
                ?>
                <div class="catalog_product shadow p-3 mb-5 bg-body rounded">
                    <div class="catalog_product_image">
                        <img src="<?= $productos[$i]['url_image']?>" alt="<?= $productos[$i]['title']?>">
                        <a href="<?=$urlProducto.$productos[$i]['route']?>" class="btn_content">Ver más</a>
                    </div>
                    <div class="catalog_product_text">
                        <a href=""><h2><strong><?= $productos[$i]['title']?></strong></h2></a>
                        <h3><?= $productos[$i]['categoria']?></h3>
                        <?php
                        if($productos[$i]['subtopicid'] != 6){
                        ?>
                        <p><?= $productos[$i]['subcategoria']?></p>
                        <?php }?>
                        <?php if($productos[$i]['stock']==0){ ?>
                        <p class="text-danger">Agotado</p>
                        <?php }else{?>
                            <p><?= MS.$productos[$i]['price'].MD?></p>
                        <?php }?>
                    </div>
                </div>
                <?php }?>
            </div>
        </section>
        <section class="contact_home mt-5 mb-5">
                <img src="https://static.wixstatic.com/media/f10dd1_8fd50df8bb4d4761bcb2e7bbe1774856~mv2.jpg/v1/fill/w_1024,h_575,fp_0.50_0.50,q_85,usm_0.66_1.00_0.01/f10dd1_8fd50df8bb4d4761bcb2e7bbe1774856~mv2.webp" alt="">
                <div class="contact_home_text">
                    <h2 class="position-relative"><strong>¿No encuentras lo que deseas? Cóntactanos</strong></h2>
                    <a class="btn_content"href="<?=base_url();?>/contacto">Contactar</a>
                </div>
        </section>
    </main>
<?php footerPage($data);?>    
    
    