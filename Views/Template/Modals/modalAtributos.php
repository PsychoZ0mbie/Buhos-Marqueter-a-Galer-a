<div class="modal fade" id="modalFormAtributo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formAtributos" name="formAtributos" class="form-horizontal">
              <input type="hidden" id="idAtributo" name="idAtributo" value="">
              <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Nombre <span class="required">*</span></label>
                      <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre" required="">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label for = "listCategoria">Categoría <span class="required"></span></label>
                    <select name="listCategoria" id="listCategoria" class="form-control" required="" data-live-search="true"></select>
                </div>
                <div class="form-group col-md-12">
                      <label class="control-label">Precio</label>
                      <input class="form-control" id="txtPrecio" name="txtPrecio" type="text"  required="">
                </div>
              </div>
              <hr>
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>