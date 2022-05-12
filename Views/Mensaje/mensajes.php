<?php headerAdmin($data); ?>
    <main class="app-content" id="<?=$data['page_name']?>">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-picture-o"></i> <?=$data['page_title']?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#"><?=$data['page_title']?></a></li>
        </ul>
      </div>
      <div id="modalItem"></div>
      <div class="item_list" id="listItem" name="listItem">
          <div class="row">
            <div class="col-md-6">
              <input class="form-control" type="search" placeholder="buscar" aria-label="Search" id="search" name="search">
            </div>
            <div class="col-md-6">
              <select class="form-control form-control" aria-label="Default select example" id="orderBy" name="orderBy">
                <option value="1">Ordenar por más reciente</option>
                <option value="2">Ordenar por más antiguo</option>
                <option value="3">Ordenar por nombre</option>
              </select>
            </div>
          </div>
      </div>
    </main>
<?php footerAdmin($data); ?>