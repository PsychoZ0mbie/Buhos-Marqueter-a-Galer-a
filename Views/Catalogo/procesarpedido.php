<?php 
    headerPage($data);
    $total = 0;
    $subtotal=0;
    $medidas="";
    $tipo="";

    if(ENVIO > 0){
        $envio = MS.number_format(ENVIO,0,DEC,MIL)." ".MD;
    }else{
        $envio = "Pago contra entrega";
    }
    foreach ($_SESSION['arrCarrito'] as $key) {
        $total = $key['cantidad']* $key['precio'];
        $subtotal += $total;
    }
?>
<main>
    <div id="divLoading">
      <div>
          <img src="<?= media(); ?>/images/loading/loading.svg" alt="Loading">
      </div>
    </div>
    
    <section class="m-4">
        <div class="row">
            <div class="col-lg-6 order-lg-1 order-md-5 order-sm-5">
                <?php if(isset($_SESSION['login'])){
                    
                ?>
                <form id="formOrden" name="formOrden" class="bg-light p-4">
                    <input type="hidden" id="txtPrecio" name="txtPrecio" value="<?=$subtotal?>">
                    <h2>Datos</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtNombreOrden" class="form-label">Nombres</label>
                                <input type="text" class="form-control" id="txtNombreOrden" name="txtNombreOrden" placeholder="Jhon" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtApellidoOrden" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="txtApellidoOrden" name="txtApellidoOrden" placeholder="Doe" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="txtIdentificacion" class="form-label">Cédula de ciudadanía</label>
                        <input type="number" class="form-control" id="txtIdentificacion" name="txtIdentificacion" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="txtEmailOrden" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="txtEmailOrden" name="txtEmailOrden" placeholder="name@example.com" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="mb-3">
                            <label for="listDepartamento" class="form-label">Departamento</label>
                            <select class="form-select" id="listDepartamento" name="listDepartamento" aria-label="Default select example" required></select>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="mb-3">
                            <label for="listCiudad" class="form-label">Ciudad</label>
                            <select class="form-select" id="listCiudad" name="listCiudad" aria-label="Default select example" required></select>
                        </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="txtDireccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" placeholder="Carrera, calle, barrio, etc..." required>
                    </div>
                    <div class="mb-3">
                        <label for="txtTelefono" class="form-label">Teléfono</label>
                        <input type="number" class="form-control" id="txtTelefono" name="txtTelefono" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="txtComentario" class="form-label">Escribe un comentario (opcional)</label>
                        <textarea class="form-control" id="txtComentario" name="txtComentario" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn_content">Realizar pedido</button>
                </form>
                <?php }else{?>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="iniciar-tab" data-bs-toggle="tab" data-bs-target="#iniciar" type="button" role="tab" aria-controls="iniciar" aria-selected="true">Iniciar sesión</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="registrar-tab" data-bs-toggle="tab" data-bs-target="#registrar" type="button" role="tab" aria-controls="registrar" aria-selected="false">Registrarse</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="iniciar" role="tabpanel" aria-labelledby="iniciar-tab">
                            <form name="formLogin" id="formLogin" action="" class="p-4">
                                <div class="mb-3">
                                    <label for="txtEmail" class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" id="txtEmail" name="txtEmail" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3">
                                    <label for="txtPassword" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                                </div>
                                <button type="submit" class="btn_content">Iniciar sesión</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="registrar" role="tabpanel" aria-labelledby="registrar-tab">
                            <form id="formRegister" name="formRegister" class="p-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtNombreCliente" class="form-label">Nombres</label>
                                            <input type="text" class="form-control" id="txtNombreCliente" name="txtNombreCliente" placeholder="Jhon" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtApellidoCliente" class="form-label">Apellidos</label>
                                            <input type="text" class="form-control" id="txtApellidoCliente" name="txtApellidoCliente" placeholder="Doe" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtEmailCliente" class="form-label">Correo electrónico</label>
                                            <input type="email" class="form-control" id="txtEmailCliente" name="txtEmailCliente" aria-describedby="emailHelp" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtPasswordCliente" class="form-label">Contraseña</label>
                                            <input type="password" class="form-control" id="txtPasswordCliente" name="txtPasswordCliente" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkBox" name="checkBox" checked>
                                    <label class="form-check-label" for="flexCheckChecked">
                                        He leido y acepto los <a href="<?= base_url()?>/terminos" target="_blank">Términos y Condiciones </a>y la<a href="<?= base_url()?>/politicas" target="_blank"> Política de Privacidad y de Cookies.</a>
                                    </label>
                                </div>
                                <button type="submit" class="btn_content">Registrarse</button>
                            </form>
                        </div>
                    </div>
                <?php }?>
            </div>
            <div class="col-lg-6 order-lg-5 mb-4">
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
                                <p><strong id="resume_envio"><?=$envio?></strong></p>
                                <p><strong id="resume_total"><?=MS.number_format(($subtotal+ENVIO),0,DEC,MIL)." ".MD?></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
    footerPage($data);
?>