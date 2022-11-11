<?php
    $social = getSocialMedia();
?>
<main>
    <div class="service">
        <img src="assets/images/slide1.jpg" alt="">
        <h1 class="service--title">Obras de arte sobre lienzo personalizadas</h1>
    </div>
    <section class="mt-5">
            <h2 class="section--title">Nuestro instagram</h2>
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6 mb-3">
                    <div class="instagram">
                        <a href="<?=$social[3]['link']?>" target="_blank">
                            <div class="instagram-img">
                                <img src="<?=media()?>/images/uploads/instagram1.png" alt="Cuadros y enmarcaciones en linea">
                                <div><i class="fab fa-instagram"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6 mb-3">
                    <div class="instagram">
                        <a href="<?=$social[3]['link']?>" target="_blank">
                            <div class="instagram-img">
                                <img src="<?=media()?>/images/uploads/instagram2.png" alt="Cuadros y enmarcaciones en linea">
                                <div><i class="fab fa-instagram"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6 mb-3">
                    <div class="instagram">
                        <a href="<?=$social[3]['link']?>" target="_blank">
                            <div class="instagram-img">
                                <img src="<?=media()?>/images/uploads/instagram3.png" alt="Cuadros y enmarcaciones en linea">
                                <div><i class="fab fa-instagram"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6 mb-3">
                    <div class="instagram">
                        <a href="<?=$social[3]['link']?>" target="_blank">
                            <div class="instagram-img">
                                <img src="<?=media()?>/images/uploads/instagram4.png" alt="Cuadros y enmarcaciones en linea">
                                <div><i class="fab fa-instagram"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
</div>