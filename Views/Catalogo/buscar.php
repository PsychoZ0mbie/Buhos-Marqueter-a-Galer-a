<?php 
    headerPage($data);
    $resultados = empty($data['resultados']['total']) ? $data['resultados']['total'] = 0 : $data['resultados']['total'];
    $productos = empty($data['productos']) ? "" : $data['productos'];
    $urlProducto = base_url()."/catalogo/producto/";
?>
    <main>
       <section>
        <div class="container mt-4 search">
          <form class="d-flex" method="GET" action="<?=base_url()?>/catalogo/search">
              <input type="hidden" name="p">
              <input class="form-control me-2" type="search" name="s" placeholder="Buscar" aria-label="Search">
              <button class="btn_content" type="submit"><i class="fas fa-search"></i></button>
          </form>
        </div>
        
        <div class="row mt-4 p-4">
            <p class="fs-2 text-center">Se ha encontrado <?=$resultados?> resultados.</p>
          <div class="catalog col-md-12">
            <?php
            if(!empty($productos)){

            
              for ($i=0; $i < count($productos) ; $i++) { 
              
            ?>
            <div class="catalog_product shadow p-3 mb-5 bg-body rounded">
              <div class="catalog_product_image">
                <img src="<?=$productos[$i]['url_image']?>" alt="<?= $productos[$i]['title']?>">
                <a href="<?=$urlProducto.$productos[$i]['route']?>" class="btn_content">Ver más</a>
              </div>
              <div class="catalog_product_text">
                <a href=""><h2><strong><?= $productos[$i]['title']?></strong></h2></a>
                <h3><?= $productos[$i]['categoria']?></h3>
                <?php
                  if($productos[$i]['subtopicid'] != 6){
                ?>
                <p><?= $productos[$i]['subcategoria']?></p>
                <?php }?>
                <?php if($productos[$i]['stock']==0){ ?>
                <p class="text-danger">Agotado</p>
                <?php }else{?>
                    <p><?= MS.$productos[$i]['price'].MD?></p>
                <?php }?>
              </div>
            </div>
            <?php } 
            
            } ?>
          </div>
        </div>
       </section>
    </main>
<?php
    footerPage($data);
?>