<?php headerAdmin($data); ?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> <?=$data['page_title']?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#"><?=$data['page_title']?></a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-lg-6">
            <div id="modalItem"></div>
            <div id="interface" class="mt-4"></div>
        </div>
        <div class="col-lg-6">
            <div class="item_list" id="listItem" name="listItem">
                <input class="form-control" type="search" placeholder="buscar" aria-label="Search" id="search" name="search">
            </div>
        </div>
      </div>
    </main>
<?php footerAdmin($data); ?>
    