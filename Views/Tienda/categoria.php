<?php 
    headerPage($data);
    $productCategoria = $data['productC'];
    $categoria = $data['categoria'];
    $subcategoria = $data['subcategoria'];
    $tecnica =$data['tecnicas'];

    $urlProducto = base_url()."/catalogo/producto/";
    $url = base_url()."/catalogo/".$categoria[0]['route']."/";
?>
    <main>
       <section>
        <div class="cover">
          <?php if($categoria[0]['idtopic'] == 1){ ?>
            <img src="<?=media();?>/template/Assets/images/uploads/banner1.gif" alt="Dale estilo a tus cuadros con las mejores molduras">
          <?php }else{ ?>
            <img src="<?=media();?>/template/Assets/images/uploads/banner2.gif" alt="Obras cargadas con emoción y creatividad">
          <?php }?>
            <h1 class="text-center"><strong><?=$categoria[0]['title'];?></strong></h1>
        </div>
        <div class="row mt-4 p-4">
          <aside class="col-lg-3 mt-4">
            <div class="accordion" id="accordionExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="true" aria-controls="collapse">
                    Catálogo
                  </button>
                </h2>
                <div id="collapse" class="accordion-collapse collapse show" aria-labelledby="heading" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <ul class="list-group">
                      <a href="<?=base_url()."/catalogo/marqueteria"?>"><li class="list-group-item">Marquetería</li></a>
                      <a href="<?=base_url()."/catalogo/galeria"?>"><li class="list-group-item">Galería</li></a>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Categorias
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <ul class="list-group">
                      <?php
                        for ($i=0; $i < count($subcategoria) ; $i++) { 
                      ?>
                      <a href="<?=$url.$subcategoria[$i]['route']?>"><li class="list-group-item"><?= $subcategoria[$i]['title']?></li></a>
                      <?php }?>
                      <a href="<?=base_url()."/catalogo/".$categoria[0]['route'];?>"><li class="list-group-item">Ver todo</li></a>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    Subcategorias
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <ul class="list-group">
                      <?php
                        for ($i=0; $i < count($tecnica) ; $i++) { 
                      ?>
                      <a href="<?=$url.$tecnica[$i]['route']?>"><li class="list-group-item"><?= $tecnica[$i]['title']?></li></a>
                      <?php }?>
                      <a href="<?=base_url()."/catalogo/".$categoria[0]['route'];?>"><li class="list-group-item">Ver todo</li></a>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </aside>
          <div class="catalog col-md-9">
            <?php
              for ($i=0; $i < count($productCategoria) ; $i++) { 
              
            ?>
            <div class="catalog_product shadow p-3 mb-5 bg-body rounded">
              <div class="catalog_product_image">
                <img src="<?=$productCategoria[$i]['url_image']?>" alt="<?= $productCategoria[$i]['title']?>">
                <a href="<?=$urlProducto.$productCategoria[$i]['route']?>" class="btn_content">Ver más</a>
              </div>
              <div class="catalog_product_text">
                <a href="<?=$urlProducto.$productCategoria[$i]['route']?>"><h2><strong><?= $productCategoria[$i]['title']?></strong></h2></a>
                <h3><?= $productCategoria[$i]['categoria']?></h3>
                <?php
                  if($productCategoria[$i]['subtopicid'] != 6){
                ?>
                <p><?= $productCategoria[$i]['subcategoria']?></p>
                <?php }?>
                <?php if($productCategoria[$i]['stock']==0){ ?>
                <p class="text-danger">Agotado</p>
                <?php }else{?>
                    <p><?= MS.$productCategoria[$i]['price'].MD?></p>
                <?php }?>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
       </section>
    </main>
<?php
    footerPage($data);
?>