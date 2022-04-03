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



    if($producto[0]['topicid'] == 1 && $producto[0]['subtopicid'] != 5 && $producto[0]['subtopicid'] != 6){
      $htmlS = '<li><i class="fas fa-check-circle text-success"></i>Color: <span>'.$producto[0]['subcategoria'].'</span></li>';
    }else if($producto[0]['topicid'] == 2){
      $htmlS = '<li><i class="fas fa-check-circle text-success"></i>Técnica: <span>'.$producto[0]['subcategoria'].'</span></li>';
      $htmlD ='<li><i class="fas fa-check-circle text-success"></i>Dimensiones: <span>'.$producto[0]['length'].'cm x '.$producto[0]['width'].'cm</span></li>';
    }else{
      $htmlS = '';
      $htmlD ="";
    }

    $url = base_url()."/catalogo/".$categoria[0]['route']."/";
    $ruta=base_url()."/catalogo/".$producto[0]['rutaC']."/";
    $urlProducto = base_url()."/catalogo/producto/";
    $urlCompartir = base_url()."/catalogo/producto/".$producto[0]['route'];
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
                  <input type="hidden" id="num_price" value="<?=$producto[0]['price']?>">
                  <input type="hidden" id="num_stock" value="<?=$producto[0]['stock']?>">
                  <p class="fs-5 price pt-4" ><strong>Precio:</strong> <?=MS.number_format($producto[0]['price'],0,DEC,MIL).MD;?></p>
                  <h3>Descripción</h3>
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
                    <a href="#" onclick="window.open('http://www.facebook.com/sharer.php?u=<?=$urlCompartir?>&t=<?=$producto[0]['title'];?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')" title="Compartir en facebook"><li><i class="fab fa-facebook-f"></i></li></a>
                    <a href="#"  onclick="window.open('https://twitter.com/intent/tweet?text=<?=$producto[0]['title'];?>&url=<?=$urlCompartir?>&hashtags=<?=SHAREDHASH?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')" title="Compartir en twitter"><li><i class="fab fa-twitter"></i></li></a>
                    <a href="#" onclick="window.open('http://www.linkedin.com/shareArticle?url=<?=$urlCompartir?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')" title="Compartir en linkedin"><li><i class="fab fa-linkedin-in"></i></li></a>
                    <a href="#" onclick="window.open('https://api.whatsapp.com/send?text=<?=$urlCompartir?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')" title="Compartir en whatsapp"><li><i class="fab fa-whatsapp"></i></li></a>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-5">
            <div class="col-lg-6 order-lg-1 order-md-5 order-sm-5">
                <div class="accordion pt-4" id="accordionExample">
                    <p><strong>Información adicional</strong></p>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Tiempos de producción
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              <ul>
                                <li>
                                    <p>Para marcos, retablos, y bastidores a medida, de acuerdo a la cantidad solicitada, se dará a conocer el tiempo estimado de producción
                                      a partir del siguiente día hábil de haber realizado y confirmado el pedido.
                                    </p>
                                </li>
                                <li>
                                    <p>Para obras de arte sobre lienzo disponibles en la tienda, su envío se realizará 2 días después a partir del siguiente día hábil de haber realizado
                                      y confirmado el pedido.
                                    </p>
                                </li>
                                <li>
                                    <p>Para obras de arte personalizadas nos pondremos en contacto para organizar los requisitos de la obra y el envío.
                                    </p>
                                </li>
                              </ul>
                              <a href="<?=base_url()?>/terminos" target="_blank">Más información</a>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Tiempos de entrega
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              Realizamos envíos directos en Villavicencio. Para zonas no cubiertas, realizamos envíos con diferentes transportadoras del país, 
                              buscando siempre la mejor opción para nuestros clientes, 
                              los tiempos pueden variar de 3 días hasta 5 días hábiles según la ciudad o municipio destino, 
                              normalmente en ciudades principales las transportadoras entregan máximo en 3 días hábiles. 
                              <a href="<?=base_url()?>/terminos" target="_blank">Más información</a>
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
                        <a href="<?=$urlProducto.$productosAl[$i]['route']?>"><h2><strong><?= $productosAl[$i]['title']?></strong></h2></a>
                        <h3><?= $productosAl[$i]['categoria']?></h3>
                        <p><?= $productosAl[$i]['subcategoria']?></p>
                        <?php if($productosAl[$i]['stock']==0){ ?>
                        <p class="text-danger">Agotado</p>
                        <?php }else{?>
                            <p><?= MS.$productosAl[$i]['price'].MD?></p>
                        <?php }?>
                    </div>
                </div>
                <?php }?>
            </div>
        </section>
       
    </main>
<?php 
    footerPage($data);
?>