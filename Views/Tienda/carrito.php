<?php 
    headerPage($data);
    $total = 0;
    $subtotal=0;
    $medidas="";
    $tipo="";
?>

<main id="<?=$data['page_name']?>">
    <section class="m-4">
        <form id="with" class="d-none">
            <div class="row">
                <div class="col-lg-8">
                    <div class="table-responsive-md">
                        <table class="text-break table-responsive-sm table align-middle">
                            <thead>
                                <tr class="text__color">
                                    <th scope="col">Producto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody" class="text__size">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="resume bg-light">
                        <div class="resume_total p-4">
                            <h2>Resumen</h2>
                            <hr>
                            <div class="row">
                                <div class="col-5">
                                    <p><strong>Subtotal</strong></p>
                                    <!--<p><strong>Envio</strong></p>-->
                                    <p><strong>Total</strong></p>
                                </div>
                                <div class="col-7">
                                    <p><strong id="subtotal"></strong></p>
                                    <!--<p><strong id="resume_envio"></strong></p>-->
                                    <p><strong id="total"></strong></p>
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
                    <a href="<?=base_url()?>/tienda/procesarPedido" class="btn_content" id="btn_pedido">Procesar pedido</a>
                </div>
            </div>
        </form>
        <div class="container mt-4 d-none" id="without">
            <div class="alert alert-danger " role="alert">
                <h3 class="pb-4">No hay productos en el carrito</h3>
                <a href="<?=base_url();?>/tienda/marqueteria" class="btn_content">Ver marquetería</a>
                <a href="<?=base_url();?>/tienda/galeria" class="btn_content">Ver galería</a>
            </div>
        </div>
    </section>
</main>
<?php
    footerPage($data);
?>