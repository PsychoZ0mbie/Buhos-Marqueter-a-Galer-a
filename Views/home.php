<?php headerPage($data);
    /*$productos = $data['products'];
    $marqueteria = $data['marqueteria'];
    $galeria = $data['galeria'];
    $urlProducto = base_url()."/catalogo/producto/";*/
?>
<main id="<?=$data['page_name']?>">
    <section>
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="<?=base_url()?>/tienda/marqueteria">
                        <img src="<?=media();?>/template/Assets/images/uploads/banner1.gif" class="d-block w-100" alt="Dale estilo a tus cuadros con las mejores molduras">
                        <div class="carousel-caption">
                            <p>Dale estilo a tus cuadros con las mejores molduras</p>
                            <button class="btn_content">Ver más</button>
                        </div>
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="<?=base_url()?>/tienda/galeria">
                    <img src="<?=media();?>/template/Assets/images/uploads/banner2.gif" class="d-block w-100" alt="Obras cargadas con emoción y creatividad">
                    <div class="carousel-caption">
                        <p>Obras cargadas con emoción y creatividad</p>
                        <button class="btn_content">Ver más</button>
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
        <div class="container presentation d-none mt-4">
            <h1 class=""><strong>Tienda en línea de marcos a medida y obras de arte. Venta directa al público</strong></h1>
            <p class="mt-3">
                Somos la <strong>mejor marquetería</strong> del departamento del Meta/Colombia. Si lo que desea son marcos para espejos, diplomas,
                cuadros, fotos, lienzos... Somos su tienda ideal. Disponemos de un amplio catálogo de 
                <strong>molduras</strong>.
            </p>
            <p>
                Visite nuestra <strong>galería de arte</strong>, encontrará
                cuadros de distintas categorías y técnicas. 
            </p>
        </div>
    </section>
</main>
<?php footerPage($data);?>    
    
    