<?php 
  headerAdmin($data); 

  $img="";

  if($_SESSION['userData']['picture'] ==""){
    $img = media()."/images/uploads/avatar.png";
  }else{
    $img = media()."/images/uploads/".$_SESSION['userData']['picture'];
  }
  
?>
    <main class="app-content" id="<?=$data['page_name']?>">
      <div class="row user">
        <div class="col-md-3">
          <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
              <li class="nav-item"><a class="nav-link active" href="#user-timeline" data-toggle="tab">Mi perfil</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content">
            <div class="tab-pane active" id="user-timeline">
              <div class="timeline-post">
                <div class="post-media">
                    <h5>Datos personales</h5>
                </div>
                <form id="formPerfil" name="formPerfil" class="form-horizontal mt-4">
                  <input type="hidden" id="idUser" name="idUser" value="<?= $_SESSION['idUser']?>" required="">
                  <div class="profile-image">
                    <img src="<?= $img;?>">
                    <label for="profile-img"><i class="fas fa-cloud-upload-alt"></i></label>
                    <input type="file" id="profile-img" name="profile-img">
                  </div>
                  <div class="form-row mt-4">
                      <div class="form-group col-md-6">
                          <label for="txtNombre">Nombre <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?= $_SESSION['userData']['firstname']; ?>" required="">
                      </div>
                      <div class="form-group col-md-6">
                          <label for="txtApellido">Apellido <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="txtApellido" name="txtApellido" value="<?= $_SESSION['userData']['lastname']; ?>" required="">
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="txtEmail">Email <span class="text-danger">*</span></label>
                          <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" value="<?= $_SESSION['userData']['email']; ?>" required="" readonly disabled >
                      </div>
                      <div class="form-group col-md-6">
                          <label for="txtTelefono">Teléfono <span class="text-danger">*</span></label>
                          <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" value="<?= $_SESSION['userData']['phone']; ?>" required="" onkeypress="return controlTag(event);">
                      </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for ="listDepartamento">Departamento <span class="text-danger">*</span></label>
                        <select name="listDepartamento" id="listDepartamento" class="form-control" data-live-search="true"></select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for ="listCiudad">Ciudad <span class="text-danger">*</span></label>
                        <select name="listCiudad" id="listCiudad" class="form-control" data-live-search="true"></select>
                    </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="txtDir">Dirección</label>
                          <input type="text" class="form-control" id="txtDir" name="txtDir" value="<?=$_SESSION['userData']['address']?>" required="">
                      </div>

                      <div class="form-group col-md-6">
                          <label for="txtId">Cédula de ciudadania <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="txtId" name="txtId" value="<?=$_SESSION['userData']['identification']?>" required="">
                      </div>
                  </div>
                  <div class="post-media mt-4">
                    <h5>Cambiar contraseña</h5>
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="txtPassword">Contraseña</label>
                          <input type="password" class="form-control" id="txtPassword" name="txtPassword" >
                      </div>
                      <div class="form-group col-md-6">
                          <label for="txtPasswordConfirm">Confirmar contraseña</label>
                          <input type="password" class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm" >
                      </div>
                  </div>
                  <div class="tile-footer">
                      <button id="btnActionForm" class="btn btn-info" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Actualizar</span></button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
<?php footerAdmin($data); ?>