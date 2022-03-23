<?php
    headerPage($data);

    $producto = $data['product'];
    $arrImg = $producto[0]['image'];
    $categoria = $data['categoria'];
    $subcategoria = $data['subcategoria'];
    $htmlS ="";
    $htmlD="";
    $atributos = $data['atributos'];
    $productosAl = $data['productsAl'];

    if($producto[0]['topicid'] == 2){
        $htmlD ='<li><i class="fas fa-check-circle text-success"></i>Dimensiones: <span>'.$producto[0]['length'].'cm x '.$producto[0]['width'].'cm</span></li>';
    }else{
        $htmlD ="";
    }
    if($producto[0]['topicid'] == 1 && $producto[0]['subtopicid'] == 5 || $producto[0]['subtopicid'] == 6){
      $htmlS="";
      
    }else{
      $htmlS = '<li><i class="fas fa-check-circle text-success"></i>Subcategoria: <span>'.$producto[0]['subcategoria'].'</span></li>';
    }

    $url = base_url()."/catalogo/".$categoria[0]['route']."/";
    $ruta=base_url()."/catalogo/".$producto[0]['rutaC']."/";
    $urlProducto = base_url()."/catalogo/producto/";
?>
    <main>
    <div id="divLoading">
      <div>
          <img src="<?= media(); ?>/images/loading/loading.svg" alt="Loading">
      </div>
    </div>
       <section>
        <div class="container mt-4" >
          <div class="container mt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url();?>">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?=$ruta?>"><?=$producto[0]['titulo'];?></a></li>
                    <li class="breadcrumb-item"><a href="<?=$ruta.$producto[0]['rutaS']?>"><?=$producto[0]['categoria'];?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$producto[0]['title'];?></li>
                </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-lg-6 mb-5">
              <div class="product_left mt-4">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-inner">
                    <?php
                        for ($i=0; $i < count($arrImg); $i++) { 
                            $urlImg = $arrImg[$i]['url_image'];
                            if($i == 0){
                                $active = "active";
                            }else{
                                $active ="";
                            }
                    ?>
                    <div class="carousel-item <?=$active?>">
                      <img src="<?=$urlImg;?>" class="d-block w-100" alt="<?=$producto[0]['title'];?>">
                    </div>
                    <?php } ?>
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
              </div>
            </div>
            <div class="col-lg-6 mb-5">
              <div class="product_right mt-4">
                <div class="product_info">
                  <h1 class="position-relative underline"><strong><?=$producto[0]['title'];?></strong></h1>
                  <p class="mt-4 fs-5"><strong>Referencia:</strong> <?=$producto[0]['reference'];?></p>
                  <input type="hidden" id="num_price" value="<?=$producto[0]['price']?>">
                  <p class="fs-5 price" ><strong>Precio:</strong> <?=MS.number_format($producto[0]['price'],0,DEC,MIL).MD;?></p>
                  <h2>Descripción</h2>
                  <p><?=$producto[0]['description'];?></p>
                  <ul>
                    <li><i class="fas fa-check-circle text-success"></i>Categoria: <span><?=$producto[0]['categoria'];?></span></li>
                    <?=$htmlS;?>
                    <?=$htmlD;?>
                  </ul>
                </div>
                <hr>
                <?php
                    if($producto[0]['topicid']==1){ ?>
                    <?php 
                        if(count($atributos)>0){
                      ?>
                    <select id="listAtributo"class="form-select mb-3 mt-3" aria-label="Default select example">
                      <option selected>Seleccione un tipo</option>
                      <?php
                        for ($i=0; $i < count($atributos) ; $i++) { 
                      ?>
                        <option id="listAtributo" value="<?=$atributos[$i]['idattribute']?>"><?=$atributos[$i]['atributo']?></option>
                        <?php }?>
                    </select>
                        <?php }?>
                    <div class="row mt-3 d-flex justify-content-center">
                        <label for="exampleFormControlInput1" class="form-label w-50">Largo (cm)</label>
                        <input id="txtLargo" type="number" class="w-25 text-center num_dimension" value="0">
                    </div>
                        
                    <div class="row mt-3 d-flex justify-content-center">
                        <label for="exampleFormControlInput1" class="form-label w-50">Ancho (cm)</label>
                        <input id="txtAncho" type="number" class="w-25 text-center num_dimension" value="0">
                    </div>
                    <hr>
                      
                      <?php }?>
                <div class="product_social">
                  <p><strong>Compartir en:</strong></p>
                  <ul>
                    <li><a href="" title="Compartir en facebook"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="" title="Compartir en instagram"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="" title="Compartir en twitter"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="" title="Compartir en linkedin"><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href="" title="Compartir en whatsapp"><i class="fab fa-whatsapp"></i></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-5">
            <div class="col-lg-6 order-lg-1 order-md-5 order-sm-5">
                <div class="accordion pt-4" id="accordionExample">
                    <p><strong>Información adicional</strong></p>
                    <?php
                      if($producto[0]['subtopicid'] != 5 && $producto[0]['subtopicid'] !=6 && $producto[0]['topicid']==1){

                      
                    ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Cómo son las medidas
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            <strong>Medida Interna</strong>: Es la medida que normalmente se usa y hace referencia al tamaño total de la obra, imagen, afiche, o arte que vas a enmarcar.<br>
                            <strong>Medida externa</strong>: En ciertas ocasiones el espacio disponible para exhibir nuestros cuadros son limitados y por esta razón se usa esta medida, la cual es el tamaño total que quieres que mida el marco por la parte externa del mismo.
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    <?php 
                      if($producto[0]['topicid'] == 1){
                    ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Tiempos de producción
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            3 a 4 días hábiles después de confirmado el pago, si tienes alguna solicitud con algún producto en especial, háznoslo saber para que podamos confirmarte si podemos entregarte antes.
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Tiempos de entrega
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Realizamos envíos directos en Villavicencio. Para zonas no cubiertas, realizamos envíos con diferentes transportadoras del país, buscando siempre la mejor opción para nuestros clientes, los tiempos pueden variar desde 1 día hábil hasta 5 días hábiles según la ciudad o municipio destino, normalmente en ciudades principales las transportadoras entregan máximo en 3 días hábiles.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-5 order-md-1 order-sm-1 ">
              <div class="product_purchase flex-column align-items-center">
                <div class="d-flex align-items-center pr-2">
                  <div id="btn_decrement" class="btnHover">-</div>
                  <input  id="num_cant" type="number" value="1" min="1">
                  <div id="btn_increment" class="btnHover">+</div>
                </div>
                <button id="<?=openssl_encrypt($producto[0]['idproduct'],ENCRIPTADO,KEY)?>" type="button" class="btn_content addCart">Agregar</button>
              </div>
            </div>
          </div> 
       </section>
       <section>
            <div class="container text-center mt-5 cover_presentation">
                <h2><strong>También te puede interesar</strong></h2>
            </div>
            <div class="catalog">
                <?php
                    for ($i=0; $i < count($productosAl) ; $i++) { 
                    
                ?>
                <div class="catalog_product shadow p-3 mb-5 bg-body rounded">
                    <div class="catalog_product_image">
                        <img src="<?= $productosAl[$i]['url_image']?>" alt="<?= $productosAl[$i]['title']?>">
                        <a href="<?=$urlProducto.$productosAl[$i]['route']?>" class="btn_content">Ver más</a>
                    </div>
                    <div class="catalog_product_text">
                        <a href=""><h2><strong><?= $productosAl[$i]['title']?></strong></h2></a>
                        <h3><?= $productosAl[$i]['categoria']?></h3>
                        <p><?= MS.$productosAl[$i]['price'].MD?></p>
                    </div>
                </div>
                <?php }?>
            </div>
        </section>
       
    </main>
<?php 
    footerPage($data);
?>