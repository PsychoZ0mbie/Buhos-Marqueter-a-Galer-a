
<div class="modal fade" id="modalSesion" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#iniciar" role="tab" aria-controls="home" aria-selected="true">Iniciar sesión</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#crear" role="tab" aria-controls="profile" aria-selected="false">Crear cuenta</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#recuperar" role="tab" aria-controls="password" aria-selected="false">Recuperar cuenta</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="iniciar" role="tabpanel" aria-labelledby="home-tab">
                <div class="tile mt-4">
                    <div class="tile-body">
                        <form class="form-horizontal" id="formLogin" name="formLogin">
                            <div class="form-group row">
                                <label class="control-label col-md-3">Email</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="email" id="txtEmail" name="txtEmail"  placeholder="johndoe@example.com">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Contraseña</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="password" id="txtPassword" name="txtPassword"  placeholder="contraseña">
                                </div>
                                <hr>
                            </div>
                            <hr>
                            <div class="tile-footer">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-3">
                                        <button class="btn btn-primary" type="submit">Ingresar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="crear" role="tabpanel" aria-labelledby="profile-tab">
                <div class="tile mt-4">
                    <div class="tile-body">
                        <form class="form-horizontal" id="formRegister" name="formRegister">
                            <div class="form-group row">
                                <label class="control-label col-md-3">Usuario</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="txtUsuario" id="txtUsuario" placeholder="John Doe">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Email</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="email" name="txtEmailRegister" id="txtEmailRegister" placeholder="johndoe@example.com">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Contraseña</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="password" name="txtPasswordRegister" id="txtPasswordRegister" placeholder="contraseña">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Confirmar Contraseña</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="password" name="txtPasswordConfirm" id="txtPasswordConfirm" placeholder="confirmar contraseña">
                                </div>
                            </div>
                            <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="check" name="check">
                                    <label class="form-check-label" for="exampleCheck1">He leido y acepto la<a href="<?=base_url();?>/publicaciones/Mas"> política de privacidad</a></label>
                            </div>
                            <div class="tile-footer">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-3">
                                        <button class="btn btn-primary" type="submit">Registrarse</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="tab-pane fade" id="recuperar" role="tabpanel" aria-labelledby="profile-tab">
                <div class="tile mt-4">
                    <div class="tile-body">
                        <form class="form-horizontal" id="formResetPass" name="formResetPass">
                            <div class="form-group row">
                                <label class="control-label col-md-3">Email</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="email" name="txtEmailReset" id="txtEmailReset" placeholder="johndoe@example.com">
                                </div>
                            </div>
                            <div class="tile-footer">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-3">
                                        <button class="btn btn-primary" type="submit">Recuperar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>