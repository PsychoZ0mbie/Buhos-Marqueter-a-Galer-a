<?php
    headerPage($data);
?>
    <main id="<?=$data['page_name']?>">
       <section>
        <div class="container mt-4" >
          <div class="row">
            <div class="col-lg-6 mb-5">
              <div class="product_left mt-4">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item ">
                      <img src="" class="d-block w-100" alt="">
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
              </div>
            </div>
            <div class="col-lg-6 mb-5">
              <div class="product_right mt-4">
                <div class="product_info">
                  <h1 class="position-relative underline"><strong>Título</strong></h1>
                  <p class="fs-5 pt-4" id="price"><strong>Precio:</strong></p>
                  <ul class="mb-3">
                    <li><i class="fas fa-check-circle text-success"></i>Categoria:</li>
                  </ul>
                  <p id="description"></p>
                </div>
                <hr>
                <div class="product_social">
                  <p><strong>Compartir en:</strong></p>
                  <!--<ul>
                    <a href="#" onclick="window.open('http://www.facebook.com/sharer.php?u=<?=$urlCompartir?>&t=<?=$producto[0]['title'];?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')" title="Compartir en facebook"><li><i class="fab fa-facebook-f"></i></li></a>
                    <a href="#"  onclick="window.open('https://twitter.com/intent/tweet?text=<?=$producto[0]['title'];?>&url=<?=$urlCompartir?>&hashtags=<?=SHAREDHASH?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')" title="Compartir en twitter"><li><i class="fab fa-twitter"></i></li></a>
                    <a href="#" onclick="window.open('http://www.linkedin.com/shareArticle?url=<?=$urlCompartir?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')" title="Compartir en linkedin"><li><i class="fab fa-linkedin-in"></i></li></a>
                    <a href="#" onclick="window.open('https://api.whatsapp.com/send?text=<?=$urlCompartir?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')" title="Compartir en whatsapp"><li><i class="fab fa-whatsapp"></i></li></a>
                  </ul>-->
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
                <div class="d-flex justify-content-center mt-2 ">
                    <input  type="number" id="addCant" class="me-4 text-center" value="1" min="1">
                    <button type="button" class="btn_content addCart"><i class="fas fa-shopping-cart"></i> Agregar</button>
                </div>
            </div>
          </div> 
       </section>
       <section>
            <div class="container text-center mt-5 cover_presentation">
                <h2><strong>También te puede interesar</strong></h2>
            </div>
            <div class="catalog">
                
            </div>
        </section>
       
    </main>
<?php 
    footerPage($data);
?>