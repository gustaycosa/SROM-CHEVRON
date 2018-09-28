<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php 
    <?php include("../../funciones.php"); 
    $TituloPantalla = 'Usuarios';
    echo Cabecera($TituloPantalla);    
?>

    <body>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 id="cabecera">
                    <?php echo $TituloPantalla; /*Incluir modal nvo*/?>
                </h6>
            </div>
            <div class="panel-body">
                <form id="formulario" method="POST" class="form-inline">
                    <input type="hidden" id="TxtClave" name="TxtClave">
                                        <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>                     <button type="button" id="btnExcel" class="btn btn-success btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Excel</button>                     <button type="button" id="btnPDF" class="btn btn-danger btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> PDF</button>                     <button type="button" id="btnPrint" class="btn btn-default btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
                    <button type="button" id="btnNuevo" class="btn btn-primary btn-sm" onMouseOver="" data-toggle="modal" data-target="#mdlnvo">Nuevo</button>
                    <button type="button" id="btnEliminar" class="btn btn-primary btn-sm" onMouseOver="">Eliminar</button>
                </form>
                <div class="respuesta"></div>                 
                <div class="form-inline">
                    <label for="inputFechaIni">Filtro:</label>
                    <input type="text" class="form-control" id="txtbusqueda" name="txtbusqueda" data-column-index='0' value="" placeholder="Busqueda rapida">
                </div>
				<?php echo CargaGif();?>
            </div>
        </div>
        <div class='modal' id='mdlnvo' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
              <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    <h4 class='modal-title' id='myModalLabel'>Agregar usuario</h4>
                  </div>
                  <div id='mdldivnvo' class='modal-body'>
                    <form id="frmnvo" class="form-horizontal" method="POST">
                      <div class="form-group">
                        <label for="inputtext3" class="col-sm-2 control-label">Nombre:</label>
                        <div class="col-sm-10">
                          <input type="text" name="txtnombre" class="form-control" id="txtnombre" placeholder="text">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputtext3" class="col-sm-2 control-label">Usuario:</label>
                        <div class="col-sm-10">
                          <input type="text" name="txtusuario" class="form-control" id="txtusuario" placeholder="text">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputtext3" class="col-sm-2 control-label">Password:</label>
                        <div class="col-sm-10">
                          <input type="text" name="txtpass" class="form-control" id="txtpass" placeholder="text">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputtext3" class="col-sm-2 control-label">Perfil:</label>
                        <div class="col-sm-10">
                          <input type="text" name="cmbperfil" class="form-control" id="cmbperfil" placeholder="text">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputtext3" class="col-sm-2 control-label">Grupo:</label>
                        <div class="col-sm-10">
                          <input type="text" name="cmbgrupo" class="form-control" id="cmbgrupo" placeholder="text">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputtext3" class="col-sm-2 control-label">Telefono:</label>
                        <div class="col-sm-10">
                          <input type="text" name="txttel" class="form-control" id="txttel" placeholder="text">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputtext3" class="col-sm-2 control-label">Correo:</label>
                        <div class="col-sm-10">
                          <input type="text" name="txtcorreo" class="form-control" id="txtcorreo" placeholder="text">
                        </div>
                      </div>  
                      <div class="form-group">
                        <label for="inputtext3" class="col-sm-2 control-label">Pass Correo:</label>
                        <div class="col-sm-10">
                          <input type="text" name="txtpasscorreo" class="form-control" id="txtpasscorreo" placeholder="text">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-default" id="btnagregar">agregar</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

        <?php echo MdlSearch('MdlMaqDet','Detalle maquinaria');?>
        <?php echo Script(); ?>
    </body>

    <script type="text/javascript">
        $(function() {        $( "#btnExcel" ).click(function() {$('.buttons-excel').click();});         $( "#btnPDF" ).click(function() {$('.buttons-pdf').click();});         $( "#btnPrint" ).click(function() {$('.buttons-print').click();});

            $("form#formulario").on('submit', function(e) {
                e.preventDefault();
				$('#CargaGif').show();
                $('#btnEnviar').attr('disabled', 'disabled')
                $.ajax({
                    type: "POST",
                    url: 'tabla-gobusr.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
						$('#CargaGif').hide();
                        $('#btnEnviar').removeAttr('disabled');
                        $(".respuesta").html(data); // Mostrar la respuestas del script PHP.
                        $(".respuesta").show();
                    },
                    error: function(error) {
						$('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });
            
            $("form#frmnvo").on('submit', function(e) {
                e.preventDefault();
				$('#CargaGif').show();
                //$('#btnEnviar').attr('disabled', 'disabled')
                $.ajax({
                    type: "POST",
                    url: 'nvo-gobusr.php',
                    data: $("form#frmnvo").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
						$('#CargaGif').hide();
                        $('#mdlnvo').modal('hide');
                        alert('Usuario agregado :)');
                        $('#grid').DataTable().draw();
                    },
                    error: function(error) {
						$('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });
        });
        
        $(document).on('click','#BtnNuevo',function(){
            var id = $(this).attr("id");
            $("#TxtClave").val(id);
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-tallmaqusadadet.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $("#DivMdlMaqDet").html(data); // Mostrar la respuestas del script PHP.
                    $("#DivMdlMaqDet").show();
                    $('#MdlMaqDet').modal('show')
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        }); 
        
        $(document).on('click','#btnEliminar',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'del-gobusr.php',
                data: $("form#formulario").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    alert('Usuario eliminado :)');
                    $('#grid').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        }); 
        
        $(document).on('dblclick','#grid tr',function(){
            var id = $(this).attr("id");
            $("#TxtClave").val(id);
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-tallmaqusadadet.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $("#DivMdlMaqDet").html(data); // Mostrar la respuestas del script PHP.
                    $("#DivMdlMaqDet").show();
                    $('#MdlMaqDet').modal('show')
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        });
        $(document).on('click','#grid tr',function(){
            var id = $(this).attr("id");
            $("#TxtClave").val(id);
        });
    </script>

</html>

