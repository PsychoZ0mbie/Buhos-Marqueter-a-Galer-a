<?php 
    headerPage($data);
?>
    <main id="<?=$data['page_name']?>">
       <section>
        <div class="cover">
          <img src="<?=media();?>/template/Assets/images/uploads/banner2.gif" alt="Obras cargadas con emoción y creatividad">
          <h1 class="text-center"><strong>Galería</strong></h1>
        </div>
        <div class="container">
          <div class="row mt-4">
            <aside class="col-lg-2 mt-4">
              <p class="text__color fs-3 text-center">Filtros</p>
              <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Por categorias
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <ul class="list-group">
                        <li id="topic1" class="list-group-item item_hover">Abstracto</li>
                        <li id="topic2" class="list-group-item item_hover">Animales</li>
                        <li id="topic3" class="list-group-item item_hover">Bodegón</li>
                        <li id="topic4" class="list-group-item item_hover">Desnudos</li>
                        <li id="topic5" class="list-group-item item_hover">Flores</li>
                        <li id="topic6" class="list-group-item item_hover">Naturaleza</li>
                        <li id="topic7" class="list-group-item item_hover">Paisajismo</li>
                        <li id="topic8" class="list-group-item item_hover">Religión</li>
                        <li id="topic9" class="list-group-item item_hover">Retrato</li>
                        <li id="topic10" class="list-group-item item_hover">Urbanismo</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                      Por técnicas
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <ul class="list-group">
                        <li id="tech1" class="list-group-item item_hover">Acrílico</li></a>
                        <li id="tech2" class="list-group-item item_hover">Lienzografía</li></a>
                        <li id="tech3" class="list-group-item item_hover">Mixta</li></a>
                        <li id="tech4" class="list-group-item item_hover">Óleo</li></a>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </aside>
            <div class="col-md-10 mt-4">
              <div class="row mb-4">
                <div class="col-md-6 mb-2">
                  <input class="form-control" type="search" placeholder="buscar" aria-label="Search" id="search" name="search">
                </div>
                <div class="col-md-6 mb-2">
                  <select class="form-control form-control" aria-label="Default select example" id="orderBy" name="orderBy">
                    <option value="1">Ordenar por</option>
                    <option value="2">Ordenar por mayor precio</option>
                    <option value="3">Ordenar por por menor precio</option>
                  </select>
                </div>
              </div>
              <div class="row mb-5" id="itemsGallery"></div>
              </div>
            </div>
          </div>
        </div>
       </section>
    </main>
<?php
    footerPage($data);
?>