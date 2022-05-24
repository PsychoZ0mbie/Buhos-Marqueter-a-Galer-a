<?php headerPage();?>
<div class="container mt-4 d-none" id="without">
    <div class="alert alert-danger " role="alert">
        <h3 class="pb-4 text-center">Oops! ha ocurrido un problema, inténtelo más tarde.</h3>
        <div class="d-flex justify-content-center flex-wrap">
            <a href="<?=base_url();?>/tienda/marqueteria" class="btn_content m-2">Ver marquetería</a>
            <a href="<?=base_url();?>/tienda/galeria" class="btn_content m-2">Ver galería</a>
        </div>
    </div>
</div>
<?php footerPage();?>