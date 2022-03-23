<?php headerPage($data); ?>
    <main>
        <div class="container mt-4 mb-4 p-0">
            <div class="shadow-sm p-3 mb-5 bg-body rounded confirm_order text-center">
                <h1>Pedido confirmado!</h1>
                <p>Se ha creado la orden No.<?=$data['orden']?></p><br>
                <p>Puedes confirmar la orden<br>
                    en tu correo electrónico o en tu perfil.
                </p>
                <a href="<?=base_url();?>" class="btn_content">Regresar</a>
            </div>
        </div>
        
    </main>
<?php footerPage($data); ?>