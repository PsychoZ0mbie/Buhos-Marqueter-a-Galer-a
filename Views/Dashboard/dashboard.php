
<?php headerAdmin($data);?>
<main class="app-content">
<?php
  if(empty($_SESSION['permisosMod']['r'])){
?>
  <p>Acceso denegado</p>
    <?php
      }else{?>
    
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> <?= $data['page_title'];?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?=base_url();?>/dashboard">Dashboard</a></li>
        </ul>
      </div>
      
      <?php
        }
      ?>
    </main>
    <?php footerAdmin($data);?>