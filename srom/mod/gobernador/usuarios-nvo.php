<div class="modal" id="UserNvo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Seleccionar cliente</h4>
            </div>
            <div class="modal-body">

                <form id="FormUserNvo" class="form-horizontal" method="POST" name="FormUserNvo">
                    <div class="col-sm-6 form-group">
                        <label for="exampleInputEmail1" class="col-sm-3 control-label">Usuario:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="Ingrese su Usuario" value="">
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="exampleInputEmail1" class="col-sm-3 control-label">Contraseña:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="txtContrasena" name="txtContrasena" placeholder="Ingrese su contraseña" value="">
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="exampleInputEmail1" class="col-sm-3 control-label">Nombre:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Ingrese su Nombre" value="">
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="exampleInputEmail1" class="col-sm-3 control-label">Celular:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="txtCelular" name="txtCelular" placeholder="Ingrese su Celular" value="">
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="exampleInputEmail1" class="col-sm-3 control-label">Empresa:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="txtEmpresa" name="txtEmpresa" placeholder="Ingrese su Empresa" value="">
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="exampleInputEmail1" class="col-sm-3 control-label">Grupo:</label>
                        <div class="col-sm-9">
                            <?php echo CmbCualquieras('Id_Grupo','Grupo',"Grupos"); ?>
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="exampleInputEmail1" class="col-sm-3 control-label">Perfil:</label>
                        <div class="col-sm-9">
                            <?php echo CmbCualquieras('Id_Perfil','Perfil',"perfiles"); ?>
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="exampleInputEmail1" class="col-sm-3 control-label">Correo:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="txtCorreo" name="txtCorreo" placeholder="Ingrese su Correo" value="">
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="exampleInputEmail1" class="col-sm-3 control-label">Contraseña Correo:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="txtContrasenaCorreo" name="txtContrasenaCorreo" placeholder="Ingrese su contraseña correo" value="">
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="exampleInputEmail1" class="col-sm-3 control-label">UsuarioFUM:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="txtUsuarioFUM" name="txtUsuarioFUM" placeholder="Ingrese su UsuarioFUM" value="">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="BtnCancel" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <input class="btn btn-default" type="submit" id="btnModificar" name="btnModificar" value="Enviar formulario" />
                    </div>
                    <input type="text" class="form-control" id="txtId" name="txtId" value="" placeholder="hideeee" style="display:none;">
                    <div class="datos">

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
