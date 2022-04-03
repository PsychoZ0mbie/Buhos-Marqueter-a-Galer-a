<?php headerPage($data);
    $productos = $data['products'];
    $marqueteria = $data['marqueteria'];
    $galeria = $data['galeria'];
    $urlProducto = base_url()."/catalogo/producto/";
?>
<main>
    <section>
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="<?=base_url()?>/catalogo/marqueteria">
                    <img src="<?=media();?>/template/Assets/images/uploads/banner1.gif" class="d-block w-100" alt="Dale estilo a tus cuadros con las mejores molduras">
                    <div class="carousel-caption">
                        <p>Dale estilo a tus cuadros con las mejores molduras</p>
                    </div>
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="<?=base_url()?>/catalogo/galeria">
                    <img src="<?=media();?>/template/Assets/images/uploads/banner2.gif" class="d-block w-100" alt="Obras cargadas con emoción y creatividad">
                    <div class="carousel-caption">
                        <p>Obras cargadas con emoción y creatividad</p>
                    </div>
                    </a>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="container presentation mt-4">
            <h1 class=""><strong>Tienda en línea de marcos a medida y obras de arte. Venta directa al público</strong></h1>
            <p class="mt-3">
                Somos la <strong><a href="<?=base_url()?>/catalogo/marqueteria">mejor marquetería</a></strong> del departamento del Meta/Colombia. Si lo que desea son marcos para espejos, diplomas,
                cuadros, fotos, lienzos... Somos su tienda ideal. Disponemos de un amplio catálogo de 
                <strong><a href="<?=base_url()?>/catalogo/marqueteria">molduras</a></strong>.
            </p>
            <p>
                Visite nuestra <strong><a href="<?=base_url()?>/catalogo/galeria"> galería de arte</a></strong>, encontrará
                cuadros de distintas categorías y técnicas. 
            </p>
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
                    <a href="<?=$urlProducto.$marqueteria[$i]['route']?>"><h2><strong><?= $marqueteria[$i]['title']?></strong></h2></a>
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
                    <a href="<?=$urlProducto.$galeria[$i]['route']?>"><h2><strong><?= $galeria[$i]['title']?></strong></h2></a>
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
                    <a href="<?=$urlProducto.$productos[$i]['route']?>"><h2><strong><?= $productos[$i]['title']?></strong></h2></a>
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
            <img src="<?=media();?>/template/Assets/images/uploads/banner4.gif" alt="">
            <div class="contact_home_text">
                <h2 class="position-relative"><strong>¿No encuentras lo que deseas? Cóntactanos</strong></h2>
                <a class="btn_content"href="<?=base_url();?>/contacto">Contactar</a>
            </div>
    </section>
    </main>
<?php footerPage($data);?>    
    
    