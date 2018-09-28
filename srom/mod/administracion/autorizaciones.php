<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Autorizaciones de compra'); ?>
<?php
    $TituloPantalla = 'Autorizaciones de compra';  

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
                    <input type="hidden" class="form-control" id="TxtEjercicio" name="TxtEjercicio" value="<?php $id = $_GET["e"]; echo $id;?>" >    
                    <input type="hidden" class="form-control" id="TxtEmpresa" name="TxtEmpresa" value="<?php $emp = $_GET["a"]; echo $emp;?>" >
                    <input type="hidden" class="form-control" id="TxtRow" name="TxtRow" value="" > 
                    <input type="hidden" class="form-control" id="TxtMov" name="TxtMov" value="" > 
                    <div class="col-sm-6 ">
                        <label for="inputtext3" class="col-sm-3 control-label">Estatus:</label>
                        <div class="col-sm-9">
                            <select id="CmbEstatus" name="CmbEstatus" class="col-sm-12 form-control">
                                <option value="TODOS">TODO</option>
                                <option class="col-sm-12" value="AUTORIZADO">AUTORIZADO</option>
                                <option class="col-sm-12" value="PENDIENTE">PENDIENTE</option>
                                <option class="col-sm-12" value="RECHAZADO">RECHAZADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <label for="inputtext3" class="col-sm-3 control-label">Sucursal:</label>
                        <div class="col-sm-9 ">
                            <?php echo CmbCualquieras('ID_SUCURSAL','SUCURSAL','SUCURSALES'); ?>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <label for="inputtext3" class="col-sm-3 control-label">Solicitante:</label>
                        <div class="col-sm-9 ">
                            <?php echo CmbCualquieras('ID','NOMBRE','NOMBRESUSUARIOWEB'); ?>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <label for="inputtext3" class="col-sm-3 control-label">Depto gasto:</label>
                        <div class="col-sm-9">
                            <select id="CmbDepto" name="CmbDepto" class="col-sm-12 form-control">
                                <option value="TODOS">TODO</option>
                                <option class="col-sm-12" value="GASTOS">GASTOS</option>
                                <option class="col-sm-12" value="PENDIENTE">PENDIENTE</option>
                                <option class="col-sm-12" value="RECHAZADO">RECHAZADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <label for="inputtext3" class="col-sm-3 control-label">Periodo fecha:</label>
                        <div class="col-sm-9 ">
                            <input type="date" name="txtFechaIni" id="txtFechaIni" value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Rango Fecha Final">
                            <input type="date" name="txtFechaFin" id="txtFechaFin" value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Rango Fecha Final">
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <label for="inputtext3" class="col-sm-3 control-label">elemento:</label>
                        <div id="ArrayCap" class="col-sm-9 ">
                            
                        </div>
                    </div>
                    <div class="col-sm-12 ">

                        <button type="submit" id="btnEnviar2" class="btn btn-primary btn-sm" onMouseOver="">Consultar</button>
                        <button type="button" id="btnNuevo" class="btn btn-primary btn-sm" onMouseOver="" data-toggle="modal" data-target="#mdlnvo">Nuevo</button>
                    <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">                         
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>
                    <button type="button" id="btnExcel" class="btn btn-success btn-sm" onMouseOver="">                         
                        <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Excel</button>
                    <button type="button" id="btnPDF" class="btn btn-danger btn-sm" onMouseOver="">
                        <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> PDF</button>
                    <button type="button" id="btnPrint" class="btn btn-default btn-sm" onMouseOver="">                         
                        <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
                    </div>
                  
                </form>
                <div class="respuesta"></div>                 

            
                </div>
              </div>
                <?php echo CargaGif();?>
        <?php echo Script(); ?>
    </body>

    <script type="text/javascript">
        
        $(function() {        
            $( "#btnExcel" ).click(function() {$('.buttons-excel').click();});         
            $( "#btnPDF" ).click(function() {$('.buttons-pdf').click();});         
            $( "#btnPrint" ).click(function() {$('.buttons-print').click();});           
            $("form#formulario").on('submit', function(e) {  
                var id = $("#TxtTarea").val();
                $("#TxtTareaCom").val(id);
                e.preventDefault();
                $('#CargaGif').show();
                //$('#btnEnviar').attr('disabled', 'disabled')
                $.ajax({
                    type: "POST",
                    url: 'tabla-autorizaciones.php',
                    data: $("form#formulario").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        $('#CargaGif').hide();
                        $(".respuesta").html(data);
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

        });

        $("form#frmrecoment").on('submit', function(e) {
            var id = $("#TxtTarea").val();
            $("#TxtTareaCom").val(id);
            e.preventDefault();
            $('#CargaGif').show();
            //$('#btnEnviar').attr('disabled', 'disabled')
            $.ajax({
                type: "POST",
                url: 'tabla-autorizaciones.php',
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
        
        $(document).on('click','td.autok',function(){
            var id = $(this).parent().attr("id");
            var mov = $(this).parent().attr("mov");
            $("#TxtRow").val(id);
            $("#TxtMov").val(mov);
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'nvo-autok.php',
                data: $("#formulario").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    alert('Autorizacion exitosa');
                    $('#btnEnviar2').click();
                    //$('#gridcom').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        });        
        
        $(document).on('click','td.autcn',function(){
            var id = $(this).parent().attr("id");
            var mov = $(this).parent().attr("mov");
            $("#TxtRow").val(id);
            $("#TxtMov").val(mov);
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'nvo-autcn.php',
                data: $("#formulario").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    alert('Autorizacion exitosa');
                    $('#btnEnviar2').click();
                    //$('#gridcom').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        }); 
        
        $(document).ready(function() { 
            $('#CargaGif').show();
            $('#btnEnviar2').click();
        });

    </script>

</html>
