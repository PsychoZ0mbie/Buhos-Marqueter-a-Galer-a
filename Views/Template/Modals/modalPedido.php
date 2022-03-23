<div class="modal fade" id="modalFormPedido" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="titleModal">Actualizar pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formPedido" name="formPedido" class="form-horizontal">
              <input type="hidden" id="idPedido" name="idPedido" value="">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="pedido">No. de orden</label>
                        <p id="pedido"></p>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="cliente">Cliente</label>
                        <p id="cliente"></p>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="totalpedido">Total</label>
                        <p id="totalpedido"></p>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="listEstado">Estado</label>
                        <select class="form-control" data-live-search="true" id="listEstado" name="listEstado" required >
                        </select>
                    </div>
                </div>
              <hr>
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-info" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>