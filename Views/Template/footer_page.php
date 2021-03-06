<footer class="bg-light">
        <div class="container footer ">
            <div class="row text-center">
                <div class="col-lg-4 footer_description">
                    <a href="<?=base_url();?>">
                        <img src="<?=media();?>/template/Assets/images/uploads/icon.gif" alt="Logo">
                        <h5><strong>Buho's</strong></h5>
                        <h5><strong>Marquetería & Galería</strong></h5>
                    </a>
                    <p>Marquetería tradicional y Moderna para diplomas, fotografías, afiches, retablos, espejos y obras de arte. Venta de todo tipo de obra sobre lienzo.</p>
                </div>
                <div class="col-lg-4 footer_social mt-4">
                    <h5 class="position-relative underline"><strong>Nuestras redes sociales</strong></h5>
                    <ul>
                        <a href="https://www.facebook.com/BuhoMyG/" target="_blank"><li><i class="fab fa-facebook-f"></i></li></a>
                        <a href="https://www.instagram.com/buhos_myg/?hl=es-la" target="_blank"><li><i class="fab fa-instagram"></i></li></a>
                        <a href="https://api.whatsapp.com/send/?phone=573108714741" target="_blank"><li><i class="fab fa-whatsapp"></i></li></a>
                    </ul>
                </div>
                <div class="col-lg-4 footer_map mt-4">
                    <h5 class="position-relative underline"><strong>Empresa</strong></h5>
                    <ul>
                        <li><a href="<?=base_url();?>">Inicio</a></li>
                        <li><a href="<?=base_url();?>/nosotros">Nosotros</a></li>
                        <li><a href="<?=base_url();?>/catalogo/marqueteria">Marquetería</a></li>
                        <li><a href="<?=base_url();?>/catalogo/galeria">Galería</a></li>
                        <li><a href="<?=base_url();?>/servicios">Servicios</a></li>
                        <li><a href="<?=base_url();?>/contacto">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-lg-12 footer_legal p-4 d-flex flex-column">
                    <a href="<?=base_url()?>/politicas">Politica de privacidad - Política de Cookies</a>
                    <a href="<?=base_url()?>/terminos">Términos y condiciones</a>
                    <p>Copyright 2022 / Buho's Marquetería & Galería - Todos los derechos reservados</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const base_url = "<?= base_url(); ?>";
        const ms = "<?=MS;?>";
        const md = "<?=MD?>";
    </script>
    <!--Frameworks/plugins-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>
    <script src="<?=media();?>/template/Assets/js/jquery-3.6.0.min.js?n=1"></script>
    <script src="<?=media();?>/template/Assets/js/popper.min.js?n=1"></script>
    <script src="<?=media();?>/template/Assets/js/bootstrap.min.js?n=1"></script>
    <script src="<?=media();?>/template/Assets/js/simple-lightbox.min.js?n=1"></script>
    

    <!--My functions-->
    <script src="<?=media();?>/template/Assets/js/functions.js?n=1"></script>
    <script src="<?= media() ?>/js/functions_login.js?n=1"></script>
    <script src="<?= media() ?>/js/functions_admin.js?n=1"></script>

</body>
</html>