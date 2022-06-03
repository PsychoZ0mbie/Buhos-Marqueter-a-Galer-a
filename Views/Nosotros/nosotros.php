<?php headerPage($data)?>   
   <main>
       <section>
        <div class="cover bg-dark">
          <h1 class="text-center"><strong>Conócenos</strong></h1>
        </div>
        <div class="container mb-5 ">
          <div class="row mt-5">
            <div class="col-md-6 mb-3">
              <h2 class="fw-bold">¿Por qué <strong class="text__color">nosotros</strong>?</h2>
              <p class="text-break mt-4"><strong>Buhos Marquetería y galería </strong>inició en 1999 en el barrio San benito de villavicencio, donde empíricamente se empezó a cortar,
            armar y pintar marcos para todos los cuadros. Con más de 20 años de experiencia, hemos entregado trabajos de calidad a nuestros clientes.</p>
              <ul>
                <li>Todos nuestros materiales son escogidos para garantizar la conservación de todos nuestros trabajos.</li>
                <li>Todos nuestros marcos y obras son hechos a mano y a las medidas requeridas por el cliente.</li>
                <li>Ofrecemos las mejores soluciones para las necesidades de nuestros clientes, garantizando siempre el gusto y la satisfacción por nuestro trabajo.</li>
              </ul>
            </div>
            <div class="col-md-6">
              <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Misión
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                    Nuestra misión es lograr la satisfacción total de las necesidades y expectativas de
                  nuestros clientes, brindándoles productos de alta calidad, pero lo más importante, prestándoles 
                  un excelente servicio
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Visión
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                    Ser reconocidos en el mercado a nivel nacional e internacional como una empresa líder
                    en marquetería y arte, siendo así una marca reconocida y posicionada en el mercado
                    al que pertenecemos.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container mb-5">
          <div class="row">
            <h2 class="text-right fw-bold">Nuestro <strong class="text__color">equipo</strong></h2>
            <div class="col-md-4">
              <div class="team">
                <img src="<?=media();?>/template/Assets/images/uploads/miembro1.png" alt="Miembro 1">
                <p class="fs-4 fw-bold mb-0">Oswaldo Parrado</p>
                <p class="text__color fs-5">Marquetero y artista</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="team">
                <img src="<?=media();?>/template/Assets/images/uploads/miembro2.png" alt="Miembro 2">
                <p class="fs-4 fw-bold mb-0">Alejandro Zapata</p>
                <p class="text__color fs-5">Marquetero y pintor</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="team">
                <img src="<?=media();?>/template/Assets/images/uploads/miembro3.png" alt="Miembro 3">
                <p class="fs-4 fw-bold mb-0">David Parrado</p>
                <p class="text__color fs-5">Artista</p>
              </div>
            </div>
          </div>
        </div>
        <div class="about d-flex justify-content-center align-items-center flex-column">
          <div>
              <h3 class="text-center text-white">Empieza con nosotros ahora</h3>
          </div>
          <div class="d-flex justify-content-center flex-wrap">
            <a href="<?=base_url()?>/tienda/marquetería" class="btn_content mt-3 me-3">Marquetería</a>
            <a href="<?=base_url()?>/tienda/marquetería" class="btn_content mt-3 ms-3">Galería</a>
          </div>
        </div>
       </section>
    </main>
<?php footerPage($data);?>