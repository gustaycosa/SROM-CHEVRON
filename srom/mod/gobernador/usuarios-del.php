<div class="modal" id="UsuariosDel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Seleccionar cliente</h4>
            </div>
            <div class="modal-body">

                <form id="FormUserNvo" class="form-horizontal" method="POST" name="FormUserNvo">
                    <label for="exampleInputEmail1" class="col-sm-12">¿Esta seguro spbre eliminar el registro?</label>
                    <div class="col-sm-6 form-group">
                        <div class="col-sm-9">
                            <input type="hidden" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="Ingrese su Usuario" value="">
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
                        <div class="col-sm-9">
                            <input type="hidden" class="form-control" id="txtUsuarioFUM" name="txtUsuarioFUM" placeholder="Ingrese su UsuarioFUM" value="">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="BtnCancel" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input class="btn btn-primary" type="submit" id="btnModificar" name="btnModificar" value="Eliminar" />
                    </div>
                    <input type="text" class="form-control" id="txtId" name="txtId" value="" placeholder="hideeee" style="display:none;">
                    <div class="datos">

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
