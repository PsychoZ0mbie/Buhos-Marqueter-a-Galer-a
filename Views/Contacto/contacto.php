<?php headerPage($data)?>   
  <main>
    <div id="divLoading">
      <div>
          <img src="<?= media(); ?>/images/loading/loading.svg" alt="Loading">
      </div>
    </div>
       <section>
         <div class="container contact">
           <div class="row">
             <div class="col-lg-6 p-0">
                <form id="formContacto" name="formContacto" class="bg-light">
                  <h2>Envia un mensaje</h2>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="txtNombre" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Jhon" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="txtApellido" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="txtApellido" name="txtApellido" placeholder="Doe" required>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="txtEmail" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="name@example.com" required>
                  </div>
                  <div class="mb-3">
                      <label for="txtTelefono" class="form-label">Teléfono</label>
                      <input type="number" class="form-control" id="txtTelefono" name="txtTelefono" value="" required>
                  </div>
                  <div class="mb-3">
                    <label for="txtComentario" class="form-label">Escribe tu comentario</label>
                    <textarea class="form-control" id="txtComentario" name="txtComentario" rows="10" required></textarea>
                  </div>
                  <button type="submit" class="btn_content">Enviar</button>
                </form>
             </div>
             <div class="col-lg-6 p-0">
                <div class="contact_info">
                  <h2>Información de contacto</h2>
                  <ul>
                    <li><i class="fas fa-map-marker-alt"></i><p><?=DIRECCION?></p></li>
                    <li><i class="fas fa-envelope"></i><p><?=EMAIL_REMITENTE?></p></li>
                    <li><i class="fas fa-phone-alt"></i><p><?=TELEFONO?></p></li>
                  </ul>
                  <ul>
                    <li><a href="https://www.facebook.com/BuhoMyG/" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="https://www.instagram.com/buhos_myg/?hl=es-la" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="https://api.whatsapp.com/send/?phone=573108714741" target="_blank"><i class="fab fa-whatsapp"></i></i></a></li>
                  </ul>
                </div>
                <div class="contact_map">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m21!1m12!1m3!1d583.06741647677!2d-73.62875799031805!3d4.132266543628741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m6!3e0!4m0!4m3!3m2!1d4.1321414!2d-73.62862!5e0!3m2!1ses!2sco!4v1646357373848!5m2!1ses!2sco" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
           </div>
           
         </div>
       </section>
  </main>
<?php footerPage($data);?>