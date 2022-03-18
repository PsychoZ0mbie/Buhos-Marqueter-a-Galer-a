<?php 
    headerPage($data);
?>
<div class="container text-center">
	<main class="app-content">
    <div class="alert alert-danger " role="alert">
        <h3 class="pb-4">No existe la página</h3>
        <a href="<?=base_url();?>" class="btn_content">Regresar</a>
    </div>
  </main>
</div>
<?php footerPage($data); ?>

