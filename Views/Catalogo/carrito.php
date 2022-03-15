<?php 
    headerPage($data);
    $total = 0;
    $subtotal=0;
    $medidas="";
    $tipo="";
?>

<main>
    <section>
    <div class="container mt-4" >
        <div class="row">
        <div class="col-lg-6">
            <div class="row confirm">
            <div class="col-6">
                <p><strong>Producto</strong></p>
            </div>
            <div class="col-3">
            <p><strong>Cantidad</strong></p>
            </div>
            <div class="col-3">
            <p><strong>Precio</strong></p>
            </div>
            </div> 
    <?php
        if(isset($_SESSION['arrCarrito']) && $_SESSION['arrCarrito']>0){
            //dep($_SESSION['arrCarrito']);
            foreach ($_SESSION['arrCarrito'] as $key) {
                $total = $key['cantidad']* $key['precio'];
                $subtotal += $total;
                $idProducto = openssl_encrypt($key['idproducto'],ENCRIPTADO,KEY);
                
            
    ?>      <hr>
            <div class="row mt-2 align-items-center">
                <div class="col-6 ">
                    <div class="row confirm_product">
                        <div class="col-6 position-relative">
                            <img src="<?=$key['imagen']?>">
                            <button class="btn_del">x</button>
                        </div>
                        <div class="col-6">
                        <p><strong><?=$key['nombre']?></strong></p>
                        <?php
                            if($key['largo'] > 0 && $key['ancho'] > 0 && $key['idatributo']>0){
                            
                        ?>
                        <p class="text-secondary"><?=$key['largo']?>cm x <?=$key['ancho']?>cm</p>
                        <p class="text-secondary"><?=$key['tipo']?></p>
                        <?php }?>
                        </div>
                    </div>
                </div>
                <div class="col-3 confirm_qty">
                    <input type="number" value="<?=$key['cantidad']?>">
                </div>
                <div class="col-3">
                    <p class="m-0"><?=MS.number_format($key['precio'],0,DEC,MIL)." ".MD?></p>
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
                    <p><strong>Costo de envio</strong></p>
                    <p><strong>Total</strong></p>
                </div>
                <div class="col-7">
                    <p><strong><?=MS.number_format($subtotal,0,DEC,MIL)." ".MD?></strong></p>
                    <p><strong><?=MS.number_format(ENVIO,0,DEC,MIL)." ".MD?></strong></p>
                    <p><strong><?=MS.number_format(($subtotal+ENVIO),0,DEC,MIL)." ".MD?></strong></p>
                </div>
                </div>
                
            </div>
            </div>
            <hr>
            <form action="" class="bg-light p-4">
            <h2>Datos</h2>
            <div class="row">
                <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nombres</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Jhon">
                </div>
                </div>
                <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Apellidos</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Doe">
                </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Cédula de ciudadanía</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" >
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <div class="row">
                <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Departamento</label>
                    <select class="form-select" aria-label="Default select example"></select>
                </div>
                </div>
                <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Ciudad</label>
                    <select class="form-select" aria-label="Default select example"></select>
                </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Cra, cll, barrio, etc..." >
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Teléfono</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Escribe un comentario</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
            </div>
            <button type="submit" class="btn_content">Realizar pedido</button>
            </form>
        </div>
        </div>
    </div>
    </section>
</main>
<?php }else{?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            No hay productos en tu carrito.<br>
            <a href="">Ver marquetería</a>
            <a href="">Ver galería</a>
        </div>
    </div>
<?php }?>
<?php
    footerPage($data);
?>