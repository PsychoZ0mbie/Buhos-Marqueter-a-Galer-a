<?php headerPage($data);?>

<main id="<?=$data['page_name']?>">
<?php if(isset($_SESSION['login'])){?>
    <div class="container text-center mt-4">
        <div class="account">
            <h2>Mi cuenta</h2>
            <i class="fas fa-user-circle"></i>
            <p class="mt-4">Desde tu cuenta puedes ver tus pedidos y el estado de ellos <br>como también actualizar todos tus datos personales</p>
            <a class="btn_content" href="<?=base_url()?>/usuarios/perfil" target="_blank" >Ver mi cuenta</a>
        </div>
    </div>
<?php }else{ ?>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <div id="divLoading">
                        <div>
                            <img src="<?= media(); ?>/images/loading/loading.svg" alt="Loading">
                        </div>
                    </div>
                    <h2 id="changeTitle">Soy cliente</h2>
                    <form name="formLogin" id="formLogin" action="" class="p-4">
                        <div class="mb-3">
                            <label for="txtEmail" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="txtEmail" name="txtEmail" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="txtPassword" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                        </div>
                        <div class="d-flex justify-content-between flex-wrap">
                            <button type="submit" class="btn_content" id="btnLogin">Iniciar sesión</button>
                            <a href="#" id="btnForget">¿Olvidaste la contraseña?</a>
                        </div>
                    </form>
                    <form name="formRecovery" id="formRecovery" action="" class="p-4 d-none">
                        <div class="mb-3">
                            <label for="txtEmail" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="txtEmailRecovery" name="txtEmailRecovery" aria-describedby="emailHelp">
                        </div>
                        <div class="d-flex justify-content-between flex-wrap">
                            <button type="submit" class="btn_content" id="btnForgetForm">Enviar</button>
                            <a href="#" id="btnBack">iniciar sesión</a>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <h2>Soy nuevo</h2>
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
                        <button type="button" class="btn_content mt-4" id="btnSendCode">Registrarse</button>
                    </form>
                    <form class="d-none p-4" id="sendCode">
                        <div class="mb-3">
                            <label for="intCodigo" class="form-label">Código de validación</label>
                            <input type="text" class="form-control" id="intCodigo" name="intCodigo" aria-describedby="emailHelp" required>
                        </div>
                        <button type="button" class="btn_content mt-4" id="btnRegister">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
        <?php }?>
</main>
<?php footerPage($data)?>

