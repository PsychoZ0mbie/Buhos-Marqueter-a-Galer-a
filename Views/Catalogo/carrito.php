<?php 
    headerPage($data);
    $total = 0;
    $subtotal=0;
    $medidas="";
    $tipo="";
?>

<main>
        <?php
            if(isset($_SESSION['arrCarrito']) && !empty($_SESSION['arrCarrito'])){
        ?>
    <section class="m-4">
        <form>
            <div class="row">
                <div class="col-lg-6">
                    <div class="row confirm">
                        <div class="col-4">
                            <p><strong>Producto</strong></p>
                        </div>
                        <div class="col-2">
                            <p><strong>Cant</strong></p>
                        </div>
                        <div class="col-3">
                            <p><strong>Precio</strong></p>
                        </div>
                        <div class="col-3">
                            <p><strong>Total</strong></p>
                        </div>
                    </div> 
                    <?php
                            //dep($_SESSION['arrCarrito']);
                            foreach ($_SESSION['arrCarrito'] as $key) {
                                $antes =$key['cantidad']* $key['precio'];
                                if($key['cantidad']>= 12){
                                    $total = $key['cantidad']* $key['precio'];
                                    $total = $total * 0.9;
                                }else{
                                    $total = $key['cantidad']* $key['precio'];
                                }
                                $subtotal += $total;
                                $idProducto = openssl_encrypt($key['idproducto'],ENCRIPTADO,KEY);
                                $idAtributo = $key['idatributo'];
                                $largo = $key['largo'];
                                $ancho = $key['ancho'];
                                $strAtr = "at".$idAtributo;
                                $strLar ="l".$largo;
                                $strAnc = "a".$ancho;
                                $strProducto=$strAtr.$strLar.$strAnc.$idProducto;
                    ?>      <hr>
                    <div class="row mt-2 align-items-center">
                        <div class="col-4 ">
                            <div class="row confirm_product">
                                <div class="col-md-6 position-relative">
                                    <img src="<?=$key['imagen']?>">
                                    <button class="btn_del" idpr="<?=$idProducto?>" idat="<?=$idAtributo?>" lar="<?=$largo?>" anc="<?=$ancho?>" onclick="deleteCar(this)">x</button>
                                </div>
                                <div class="col-md-6">
                                <p><strong><?=$key['nombre']?></strong></p>
                                <?php
                                    if($key['largo'] > 0 && $key['ancho'] > 0 || $key['idatributo']>0){
                                    
                                ?>
                                <p class="text-secondary"><?=$key['largo']?>cm x <?=$key['ancho']?>cm</p>
                                <p class="text-secondary"><?=$key['tipo']?></p>
                                <p class="text-secondary"><?=$key['categoria']?></p>
                                <p class="text-secondary"><?=$key['subcategoria']?></p>
                                <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 confirm_qty">
                            <input class="carCant" type="number" value="<?=$key['cantidad']?>" idpr="<?=$idProducto?>" idat="<?=$idAtributo?>" lar="<?=$largo?>" anc="<?=$ancho?>">
                        </div>
                        <div class="col-3 confirm_price">
                            <p class="m-0"><?=MS.number_format($key['precio'],0,DEC,MIL)?></p>
                        </div>
                        <div class="col-3 confirm_price">
                            <?php if($key['cantidad']>= 12){
                            ?>
                            <p class="m-0 confirm_total text-decoration-line-through"><?=MS.number_format($antes,0,DEC,MIL)?></p>
                            <p class="m-0 confirm_total <?=$strProducto?>"><?=MS.number_format($total,0,DEC,MIL)?></p>
                            <span class="text-danger">10% de descuento aplicado al por mayor!</span>
                            <?php }else{

                            ?>
                            <p class="m-0 confirm_total <?=$strProducto?>"><?=MS.number_format($total,0,DEC,MIL)?></p>
                            <?php }?>
                        </div>
                    </div>
                    <?php }?>
                    <hr>
                </div>
                <div class="col-lg-6">
                    <div class="resume bg-light">
                        <div class="resume_total p-4">
                            <h2>Resumen</h2>
                            <hr>
                            <div class="row">
                                <div class="col-5">
                                    <p><strong>Subtotal</strong></p>
                                    <p><strong>Envio</strong></p>
                                    <p><strong>Total</strong></p>
                                </div>
                                <div class="col-7">
                                    <p><strong id="resume_subtotal"><?=MS.number_format($subtotal,0,DEC,MIL)." ".MD?></strong></p>
                                    <p><strong id="resume_envio"><?=MS.number_format(ENVIO,0,DEC,MIL)." ".MD;?></strong></p>
                                    <p><strong id="resume_total"><?=MS.number_format(($subtotal+ENVIO),0,DEC,MIL)." ".MD?></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="bg-info p-2 border border-1 border-primary rounded">
                        <strong>Nota:</strong>
                        <p>Después de recibir tu pedido, nos comunicaremos contigo para confirmar sus datos y organizar el pago.</p>
                    </div>
                    <hr>
                    <a href="<?=base_url()?>/catalogo/procesarPedido" class="btn_content" id="btn_pedido">Procesar pedido</a>
                </div>
            </div>
        </form>
        <?php }else{?>
        <div class="container mt-4">
            <div class="alert alert-danger " role="alert">
                <h3 class="pb-4">No hay productos en el carrito</h3>
                <a href="<?=base_url();?>/catalogo/marqueteria" class="btn_content">Ver marquetería</a>
                <a href="<?=base_url();?>/catalogo/galeria" class="btn_content">Ver galería</a>
            </div>
        </div>
        <?php }?>
    </section>
</main>
<?php
    footerPage($data);
?>