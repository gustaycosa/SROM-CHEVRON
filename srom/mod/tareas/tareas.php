<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Mis tareas Taycosa'); ?>
<?php
    $TituloPantalla = 'Mis tareas Taycosa';  
	//$Arreglo = array("Nombre","Saldo");
	//echo PasaArreglo($Arreglo);
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
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="TxtEjercicio" name="TxtEjercicio" value="<?php $id = $_GET["e"]; echo $id;?>" placeholder="Ingrese ejercicio">
                    </div>
                    <!--                    <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>                     <button type="button" id="btnExcel" class="btn btn-success btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Excel</button>                     <button type="button" id="btnPDF" class="btn btn-danger btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> PDF</button>                     <button type="button" id="btnPrint" class="btn btn-default btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>-->
                    <button type="submit" id="btnEnviar2" class="btn btn-primary btn-sm" onMouseOver="">Consultar</button>
                    <button type="button" id="btnNuevo" class="btn btn-primary btn-sm" onMouseOver="" data-toggle="modal" data-target="#mdlnvo">Nuevo</button>
                    <!--<button type="button" id="addRow" class="btn btn-primary btn-sm" onMouseOver="" data-target="#mdlnvo">Comentario</button>-->                    
                </form>
                <div class="controles form-horizontal">

                </div>
                <div class="col-sm-6"><h3>Mis Pendientes</h3></div>
                <div class="col-sm-6"><h3>Mis Asignaciones</h3></div>                
                <div class="respuesta col-sm-6"></div>
                <div class="solicita col-sm-6"></div>
            <div class='modal' id='mdlnvo' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
              <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    <h4 class='modal-title' id='myModalLabel'>Solicitar tarea</h4>
                  </div>
                  <div id='mdldivnvo' class='modal-body'>
                    <form id="frmnvo" class="form-horizontal" method="POST">
                    <input type="hidden" class="form-control" id="TxtIdSolicita" name="TxtIdSolicita" value="<?php $id = $_GET["e"]; echo $id;?>" placeholder="Ingrese ejercicio">
<!--                <div class="form-group">
                        <label for="inputFechaIni">Departamento:</label>
                        <select id="TxtDpto" name="TxtDpto" class="form-control">
                            <option value="1">Enero</option>
                        </select>
                      </div>-->
                    <div class="form-group">
                        <label for="inputtext3" class="col-sm-2 control-label">Empleado:</label>
                        <div class="col-sm-10">
                            <?php echo CmbCualquierasId('ID','NOMBRE','NOMBRESUSUARIOWEB','Todos','0'); ?>
                        </div>
                    </div>
                      <div class="form-group">
                        <label for="inputtext3" class="col-sm-2 control-label">Fecha solicita:</label>
                        <div class="col-sm-10">
                            <input type="date" name="txtFecha" id="txtFecha" value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Rango Fecha Final">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputtext3" class="col-sm-2 control-label">Descripcion:</label>
                        <div class="col-sm-10">
                          <input type="text" name="TxtDescripcion" class="form-control" id="TxtDescripcion" placeholder="Agregue su descripcion">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputtext3" class="col-sm-2 control-label">Asunto:</label>
                        <div class="col-sm-10">
                          <input type="text" name="TxtAsunto" class="form-control" id="TxtAsunto" placeholder="Agrege su asunto">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-default" id="btnagregar">agregar</button>
                        </div>
                      </div>
                        <div class="result"></div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class='modal' id='mdlcom' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
              <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    <h4 class='modal-title' id='myModalLabel'>Responder comentario</h4>
                  </div>
                  <div id='divmdlcom' class='modal-body'>
                    <form id="frmcoment" class="form-horizontal" method="POST">
                        <input type="hidden" class="form-control" id="TxtTarea" name="TxtTarea" value="" placeholder="Ingrese ejercicio">
                        <input type="hidden" class="form-control" id="Txtidsolicita" name="Txtidsolicita" value="<?php $tarea = $_GET["e"]; echo $id;?>" placeholder="Ingrese ejercicio">
                    <div class="comentarios"></div>

                    </form>
                    <form id="frmrecoment" class="form-horizontal" method="POST">
                        <input type="hidden" class="form-control" id="TxtTareaCom" name="TxtTareaCom" value="" placeholder="Ingrese ejercicio">
                        <input type="hidden" class="form-control" id="Txtidsolicita" name="Txtidsolicitacom" value="<?php $tarea = $_GET["e"]; echo $id;?>" placeholder="Ingrese ejercicio">
                      <div class="form-group">
                        <label for="inputtext3" class="col-sm-2 control-label">Comentario:</label>
                        <div class="col-sm-10">
                            <input type="date" name="txtFechaCom" id="txtFechaCom" value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Rango Fecha Final" style="display:none">
                          <input type="text" name="TxtComentario" class="form-control" id="TxtComentario" placeholder="text">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-12">
                          <button type="submit" class="btn btn-primary" id="addRow">agregar comentario</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="closecom">cerrar</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            
            </div>
        </div>
        <?php echo CargaGif();?>
        <?php echo Script(); ?>
    </body>

    <script type="text/javascript">

        
        $(function() {        $( "#btnExcel" ).click(function() {$('.buttons-excel').click();});         $( "#btnPDF" ).click(function() {$('.buttons-pdf').click();});         $( "#btnPrint" ).click(function() {$('.buttons-print').click();});           
            $("form#formulario").on('submit', function(e) {  
                $('#CargaGif').show();
                e.preventDefault();
                getData1();
                $('#CargaGif').show();               
                //sreturn false; // Evitar ejecutar el submit del formulario.
            });            

        });

        $( "#closecom" ).click(function() {
          $('#mdlcom').modal('hide');
        }); 
        
        $(document).on('dblclick touchstart','tr.tar',function(){
            var id = $(this).attr("id");
            $("#TxtClave").val(id);
        });
        
        $("form#frmnvo").on('submit', function(e) {
            e.preventDefault();
            $('#CargaGif').show();
            //$('#btnEnviar').attr('disabled', 'disabled')
            $.ajax({
                type: "POST",
                url: 'nvo-tareastar.php',
                data: $("form#frmnvo").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    $('#CargaGif').hide();
                    $('#mdlnvo').modal('hide');
                    $(".result").html(data);
                    alert('Tarea agregada :)');
                    $("#frmnvo")[0].reset();
                    $('#btnEnviar2').click();
                    //$('#grid').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.
        });
        
        $("form#frmrecoment").on('submit', function(e) {
            var id = $("#TxtTarea").val();
            $("#TxtTareaCom").val(id);
            e.preventDefault();
            $('#CargaGif').show();
            //$('#btnEnviar').attr('disabled', 'disabled')
            $.ajax({
                type: "POST",
                url: 'nvo-tareascom.php',
                data: $("form#frmrecoment").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    $('#CargaGif').hide();
                    $('#mdlcom').modal('hide');
                    //$(".result").html(data);
                    alert('Tarea agregada :)');
                    //$('#grid').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.
        });
        
        $(document).on('click touchstart','tr.tar',function(){
            var id = $(this).attr("id");
            $("#TxtTarea").val(id);
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'nvo-tareascomselect.php',
                data: $("#frmcoment").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $(".comentarios").html(data); // Mostrar la respuestas del script PHP.
                    $("#frmcoment")[0].reset();
                    $('#btnEnviar2').click();
                    //$("#mdlcom").show();
                    //$('.comentarios').modal('show')
                    $('#gridcom').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false;// Evitar ejecutar el submit del formulario.	
        });
        
        $(document).on('click touchstart','td.fin',function(){
            var id = $(this).parent().attr("id");
            $("#TxtTarea").val(id);
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'nvo-tareasfin.php',
                data: $("#frmcoment").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    alert('Registro borrado exitosamente');
                    $('#btnEnviar2').click();
                    $('#gridcom').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        });
        
        $(document).on('click touchstart','td.ter',function(){
            var id = $(this).parent().attr("id");
            $("#TxtTarea").val(id);
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'nvo-tareaster.php',
                data: $("#frmcoment").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    alert('Tarea terminada :)');
                    $('#btnEnviar2').click();
                    $('#gridcom').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        });
        
        function getData2(){
                $.ajax({
                    type: "POST",
                    url: 'tabla-tareassoli.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        
                        $('#CargaGif').hide();
                        $('#btnEnviar2').removeAttr('disabled');
                        $(".solicita").html(data); // Mostrar la respuestas del script PHP.
                        $(".solicita").show();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
        }
         function getData1(){
                $.ajax({
                    type: "POST",
                    url: 'tabla-tareaspend.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        
                        $('#CargaGif').hide();
                        $('#btnEnviar').removeAttr('disabled');
                        $(".respuesta").html(data); // Mostrar la respuestas del script PHP.
                        $(".respuesta").show();
                        getData2(); 
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
        }
        
        $(document).ready(function() { 
            $('#CargaGif').show();
            $('#btnEnviar2').click();
        });
    </script>

</html>
