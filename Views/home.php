<?php
    headerPage($data);
    
    $slider = $data['slider'];
    $categories1 = $data['category1'];
    $categories2 = $data['category2'];
    $products = $data['products'];
    $popProducts = $data['popProducts'];
    $recPosts = $data['recPosts'];
    //dep($slider);exit;
?>
    <div id="modalItem"></div>
    <div id="modalPoup"></div>
    <main>
        <div id="mainSlider" class="carousel slide" data-bs-ride="carousel" data-bs-touch="false" >
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="main--show">
                        <div class="show--text">
                            <h2>Imprime y Enmarca tus fotos favoritas sin salir de casa</h2>
                            <a href="#" class="btn btn-bg-1">Empieza ahora</a>
                        </div>
                        <div class="show--img">
                            <img src="assets/images/slide1.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="main--show">
                        <div class="show--text">
                            <h2>Imprime y Enmarca tus fotos favoritas sin salir de casa</h2>
                            <a href="#" class="btn btn-bg-1">Empieza ahora</a>
                        </div>
                        <div class="show--img">
                            <img src="assets/images/slide1.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </main>
    <div class="container">
        <section class="mt-5">
            <h2 class="section--title">Enmarca lo que quieras</h2>
            <div id="carouselEnmarcar" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="enmarcaciones">
                            <div class="card--enmarcar shadow">
                                <div class="card--enmarcar-img">
                                    <a href="#"><img src="assets/images/producto.gif" alt=""></a>
                                </div>
                                <div class="card--enmarcar-info">
                                    <a href="#">
                                        <h3 class="enmarcar--title">Diplomas y títulos</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                    </a>
                                </div>
                            </div>
                            <div class="card--enmarcar shadow">
                                <div class="card--enmarcar-img">
                                    <a href="#"><img src="assets/images/producto.gif" alt=""></a>
                                </div>
                                <div class="card--enmarcar-info">
                                    <a href="#">
                                        <h3 class="enmarcar--title">Diplomas y títulos</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                    </a>
                                </div>
                            </div>
                            <div class="card--enmarcar shadow">
                                <div class="card--enmarcar-img">
                                    <a href="#"><img src="assets/images/producto.gif" alt=""></a>
                                </div>
                                <div class="card--enmarcar-info">
                                    <a href="#">
                                        <h3 class="enmarcar--title">Diplomas y títulos</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                    </a>
                                </div>
                            </div>
                            <div class="card--enmarcar shadow">
                                <div class="card--enmarcar-img">
                                    <a href="#"><img src="assets/images/producto.gif" alt=""></a>
                                </div>
                                <div class="card--enmarcar-info">
                                    <a href="#">
                                        <h3 class="enmarcar--title">Diplomas y títulos</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="enmarcaciones">
                            <div class="card--enmarcar shadow">
                                <div class="card--enmarcar-img">
                                    <a href="#"><img src="assets/images/producto.gif" alt=""></a>
                                </div>
                                <div class="card--enmarcar-info">
                                    <a href="#">
                                        <h3 class="enmarcar--title">Diplomas y títulos</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                    </a>
                                </div>
                            </div>
                            <div class="card--enmarcar shadow">
                                <div class="card--enmarcar-img">
                                    <a href="#"><img src="assets/images/producto.gif" alt=""></a>
                                </div>
                                <div class="card--enmarcar-info">
                                    <a href="#">
                                        <h3 class="enmarcar--title">Diplomas y títulos</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                    </a>
                                </div>
                            </div>
                            <div class="card--enmarcar shadow">
                                <div class="card--enmarcar-img">
                                    <a href="#"><img src="assets/images/producto.gif" alt=""></a>
                                </div>
                                <div class="card--enmarcar-info">
                                    <a href="#">
                                        <h3 class="enmarcar--title">Diplomas y títulos</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                    </a>
                                </div>
                            </div>
                            <div class="card--enmarcar shadow">
                                <div class="card--enmarcar-img">
                                    <a href="#"><img src="assets/images/producto.gif" alt=""></a>
                                </div>
                                <div class="card--enmarcar-info">
                                    <a href="#">
                                        <h3 class="enmarcar--title">Diplomas y títulos</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselEnmarcar" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselEnmarcar" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="text-center">
                <a href="#" class="btn btn-bg-2">Ver todo</a>
            </div>
            <div class="section--cta">
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center mb-3">
                        <div class="cta-info">
                            <h4>Dale vida a tus obras</h4>
                            <p>Enmarca tus pinturas, dale estilo y personalidad con nuestros mejores marcos</p>
                            <a href="#" class="btn btn-bg-1 mt-3">Enmarcar ahora</a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="cta-img">
                            <img src="assets/images/slide1.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-5">
            <h2 class="section--title">¿Cómo funciona?</h2>
            <div class="row">
                <div class="col-md-6 how-img mb-3 d-flex align-items-center">
                    <img src="assets/images/slide1.jpg" alt="">
                </div>
                <div class="col-md-6 how-list mb-3 d-flex align-items-start flex-column">
                    <ol>
                        <li>
                            <p>Elige lo que quieres enmarcar</p>
                            <p>Escoge entre los tipos de enmarcación que más se adapte a ti</p>
                        </li>
                        <li>
                            <p>Personaliza tu marco</p>
                            <p>Elige el material, colores, bordes y más mientras se visualiza como queda tu marco</p>
                        </li>
                        <li>
                            <p>Recibelo en tu puerta</p>
                            <p>Enviamos la enmarcación a tu domicilio o puedes recogerlo en nuestro local</p>
                        </li>
                    </ol>
                    <a href="#" class="btn btn-bg-1 mt-3">Empieza a enmarcar ahora</a>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="card--plus shadow">
                        <i class="fas fa-certificate"></i>
                        <h3>Trabajo de calidad</h3>
                        <p>Nuestros materiales y mano de obra  te garantiza un producto de calidad que te hará volver.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card--plus shadow">
                        <i class="fas fa-receipt"></i>
                        <h3>Pagos seguros</h3>
                        <p>Todas las transacciones están seguras y protegidas a través de la pasarela de mercadopago.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card--plus shadow">
                        <i class="fas fa-dollar-sign"></i>
                        <h3>Precios claros</h3>
                        <p>El precio se basa en el material y tamaño del marco.</p>
                    </div>
                </div>
            </div>
            <div class="section--cta">
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center mb-3">
                        <div class="cta-info">
                            <h4>Decora tu alrededor</h4>
                            <p>Decora tu sala, oficina o habitación con nuestros cuadros abstractos, paisajes y más</p>
                            <a href="#" class="btn btn-bg-1 mt-3">Ver tienda</a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="cta-img">
                            <img src="assets/images/slide1.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-5">
            <h2 class="section--title">Algunos de nuestros productos</h2>
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card--product">
                        <div class="card--product-img">
                            <a href="#">
                                <img src="assets/images/slide1.jpg" alt="">
                            </a>
                        </div>
                        <div class="card--product-info">
                            <h4><a href="#">Cuadro xd</a></h4>
                            <div class="card--price">
                                <span class="current">$20.000</span>
                            </div>
                        </div>
                        <div class="card--product-btns">
                            <button type="button" class="btn btn-bg-1">Agregar <i class="fa-solid fa-cart-shopping"></i></button>
                            <button type="button" class="btn btn-bg-4">Vista rápida</button>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card--product">
                        <div class="card--product-img">
                            <a href="#">
                                <span class="discount">-30%</span>
                                <img src="assets/images/slide1.jpg" alt="">
                            </a>
                        </div>
                        <div class="card--product-info">
                            <h4><a href="#">Cuadro xdaaaaaaaaaaaaaaaa</a></h4>
                            <div class="card--price">
                                <span class="current sale">$20.000</span>
                                <span class="compare">$20.000</span>
                            </div>
                        </div>
                        <div class="card--product-btns">
                            <button type="button" class="btn btn-bg-1">Agregar <i class="fa-solid fa-cart-shopping"></i></button>
                            <button type="button" class="btn btn-bg-4">Vista rápida</button>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card--product">
                        <div class="card--product-img">
                            <a href="#">
                                <img src="assets/images/slide1.jpg" alt="">
                            </a>
                        </div>
                        <div class="card--product-info">
                            <h4><a href="#">Cuadro xd</a></h4>
                            <div class="card--price">
                                <span class="current">$20.000</span>
                            </div>
                        </div>
                        <div class="card--product-btns">
                            <button type="button" class="btn btn-bg-1">Agregar <i class="fa-solid fa-cart-shopping"></i></button>
                            <button type="button" class="btn btn-bg-4">Vista rápida</button>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card--product">
                        <div class="card--product-img">
                            <a href="#">
                                <span class="discount">-30%</span>
                                <img src="assets/images/slide1.jpg" alt="">
                            </a>
                        </div>
                        <div class="card--product-info">
                            <h4><a href="#">Cuadro xdaaaaaaaaaaaaaaaa</a></h4>
                            <div class="card--price">
                                <span class="current sale">$20.000</span>
                                <span class="compare">$20.000</span>
                            </div>
                        </div>
                        <div class="card--product-btns">
                            <button type="button" class="btn btn-bg-1">Agregar <i class="fa-solid fa-cart-shopping"></i></button>
                            <button type="button" class="btn btn-bg-4">Vista rápida</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="#" class="btn btn-bg-2">Ver todo</a>
            </div>
        </section>
        <section class="mt-5">
            <div class="section--contact">
                <h2 class="section--title">¿No encuentras lo que buscas? <br> Contáctanos</h2>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <form class="form--contact">
                            <p>Nos encontramos en la ciudad de Villavicencio/Meta/Colombia en la Cra 36 #15a-03 Barrio Nuevo Ricaurte</p> 
                            <div class="form--contact-data">
                                <label>¿Cuál es tu nombre?</label>
                                <input type="text" placeholder="Nombre">
                                <span class="form-focus-effect"></span>
                            </div>
                            <div class="form--contact-data">
                                <label>¿Cuál es tu teléfono?</label>
                                <input type="text" placeholder="310 123 1234">
                                <span class="form-focus-effect"></span>
                            </div>
                            <div class="form--contact-data">
                                <label>¿Cuál es tu correo?</label>
                                <input type="text" placeholder="micorreo@ejemplo.com">
                                <span class="form-focus-effect"></span>
                            </div>
                            <div class="form--contact-data">
                                <label>Tu mensaje</label>
                                <textarea name="" id="" rows="3" placeholder="Escribe tu mensaje"></textarea>
                                <span class="form-focus-effect"></span>
                            </div>
                            <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap">
                                <button type="submit" class="btn btn-bg-1 mb-3">Enviar mensaje</button>
                                <ul class="social mb-3">
                                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-whatsapp"></i></a></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 mb-3">
                        <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d497.43094086071005!2d-73.62887549945499!3d4.132008249047646!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3e2e72bdc34df1%3A0xd7ff9e6fdd7a5cbb!2sCra.%2036%20%2315a3%2C%20Villavicencio%2C%20Meta!5e0!3m2!1ses!2sco!4v1665440386579!5m2!1ses!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-5">
            <h2 class="section--title">Nuestro instagram</h2>
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6 mb-3">
                    <div class="instagram">
                        <a href="#">
                            <div class="instagram-img">
                                <img src="assets/images/producto.gif" alt="">
                                <div><i class="fa-brands fa-instagram"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6 mb-3">
                    <div class="instagram">
                        <a href="#">
                            <div class="instagram-img">
                                <img src="assets/images/producto.gif" alt="">
                                <div><i class="fa-brands fa-instagram"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6 mb-3">
                    <div class="instagram">
                        <a href="#">
                            <div class="instagram-img">
                                <img src="assets/images/producto.gif" alt="">
                                <div><i class="fa-brands fa-instagram"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6 mb-3">
                    <div class="instagram">
                        <a href="#">
                            <div class="instagram-img">
                                <img src="assets/images/producto.gif" alt="">
                                <div><i class="fa-brands fa-instagram"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php
    footerPage($data);
?>
    