    
    <script>
        const base_url = "<?= base_url(); ?>";
    </script>
    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js?n=1"></script>
    <script src="<?= media(); ?>/js/popper.min.js?n=1"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js?n=1"></script>
    <script src="<?= media(); ?>/js/main.js?n=1"></script>
    <script src="<?= media();?>/js/fontawesome.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert.min.js?n=1"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/tinymce/tinymce.min.js?n=1"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/jquery.plugin.js?n=1"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/jquery.maxlength.js?n=1"></script>

    <!-- Data table plugin-->
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/jquery.dataTables.min.js?n=1"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/dataTables.bootstrap.min.js?n=1"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/bootstrap-select.min.js?n=1"></script>

    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js?n=1"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js?n=1"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js?n=1"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js?n=1"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js?n=1"></script>

	<script type="text/javascript" src="<?= media(); ?>/js/functions_admin.js?n=1"></script>
	<script type="text/javascript" src="<?= media(); ?>/js/<?=$data['page_functions']."?n=1"; ?>"></script>
  </body>
</html>