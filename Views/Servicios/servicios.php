<?php headerPage($data)?>   

    <main>
       <section>
        <div class="cover">
          <img class="img-fluid" src="<?=media();?>/template/Assets/images/uploads/banner3.gif" alt="Servicios">
          <h2 class="text-center"><strong>Servicios</strong></h2>
        </div>
        <div class="container text-center mt-4 cover_presentation">
          <h2><strong>¿Qué podemos hacer por ti?</strong></h2>
        </div>
        <div class="container services">
          <div class="row">
            <div class="col-lg-4">
              <div class="services_item">
                <i class="fas fa-crop-alt"></i>
                <h3>Marquetería</h3>
                <p>Marquetería tradicional y moderna para diplomas, fotografías, afiches y obras de arte. Fabricamos
                  bastidores y retablos.
                </p>
                <a href="<?=base_url()?>/contacto" class="btn_content">Contactar</a>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="services_item">
                <i class="fas fa-palette"></i>
                <h3>Obras personalizadas</h3>
                <p>Obras de arte a tu gusto, trae tu boceto o imágen y nosotros te aportamos
                  la mejor solución.</p>
                  <a href="<?=base_url()?>/contacto" class="btn_content">Contactar</a>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="services_item">
                <i class="fas fa-undo"></i>
                <h3>Restauración</h3>
                <p>Restauramos tus obras de arte, esculturas, marcos, muebles y objetos artísticos.</p>
                <a href="<?=base_url()?>/contacto" class="btn_content">Contactar</a>
              </div>
            </div>
          </div>
          
        </div>
       </section>
       <section class="m-4">
            <div class="container why_content">
                <div class="container text-center mt-4 cover_presentation">
                    <h2><strong>¿Por qué nosotros?</strong></h2>
                </div>
                <div class="row justify-content-center mt-4">
                    <div class="col-lg-4 ">
                        <div class="why_card shadow-lg p-3 mb-5 bg-body rounded">
                            <img src="https://static.wixstatic.com/media/89a690_b92948f1fa75471da79345a5f825add4.jpg/v1/fill/w_250,h_187,al_c,q_90/89a690_b92948f1fa75471da79345a5f825add4.jpg" alt="">
                            <h3 class="mt-4"><strong>Material de calidad</strong></h3>
                            <p class="mt-3 mb-4">Todos nuestros materiales son escogidos para garantizar la conservación de todos nuestros trabajos.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="why_card shadow-lg p-3 mb-5 bg-body rounded">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT8atnieLUiDJY5ThlF539_PLeyeqVnwhI_0w&usqp=CAU" alt="">
                            <h3 class="mt-4"><strong>Hecho a mano y a medida</strong></h3>
                            <p class="mt-3 mb-4">Todos nuestros marcos y obras son hechos a mano y a las medidas requeridas por el cliente.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="why_card shadow-lg p-3 mb-5 bg-body rounded">
                            <img src="https://i0.wp.com/arteyalgomas.com/wp-content/uploads/2020/06/El-%C3%A1ngel-herido-Hugo-Simberg.jpg?fit=1024%2C818&ssl=1" alt="">
                            <h3 class="mt-4"><strong>Satisfacción garantizada</strong></h3>
                            <p class="mt-3 mb-4">Ofrecemos las mejores soluciones para las necesidades de nuestros clientes, garantizando siempre el gusto y la satisfacción de nuestros clientes por nuestro trabajo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php footerPage($data);?>