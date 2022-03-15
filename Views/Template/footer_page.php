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
                        <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href=""><i class="fab fa-instagram"></i></a></li>
                        <li><a href=""><i class="fab fa-whatsapp"></i></i></a></li>
                    </ul>
                </div>
                <div class="col-lg-4 footer_map mt-4">
                    <h5 class="position-relative underline"><strong>Empresa</strong></h5>
                    <ul>
                        <li><a href="">Inicio</a></li>
                        <li><a href="">Nosotros</a></li>
                        <li><a href="">Catálogo</a></li>
                        <li><a href="">Servicios</a></li>
                        <li><a href="">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-lg-12 footer_legal p-4">
                    <a href="">Politica de privacidad - Política de Cookies</a>
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
    <script src="<?=media();?>/template/Assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?=media();?>/template/Assets/js/popper.min.js"></script>
    <script src="<?=media();?>/template/Assets/js/bootstrap.min.js"></script>
    <script src="<?=media();?>/template/Assets/js/simple-lightbox.min.js"></script>
    

    <!--My functions-->
    <script src="<?=media();?>/template/Assets/js/functions.js"></script>
</body>
</html>