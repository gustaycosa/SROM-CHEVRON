<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Mecanicos ventas bitacora'); ?>
<?php
    $TituloPantalla = 'Mecanicos ventas bitacora';  
	//$Arreglo = array("Nombre","Saldo");
	//echo PasaArreglo($Arreglo);
?>

    <style>
        table tbody tr td {
            text-align: right !important;
        }
    </style>
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
                      <label for="inputFechaIni">Mecanico:</label>

                       <select id='CmbMECAVENTAS' name='CmbMECAVENTAS' class='form-control'><option value='0'>MECANICOS VENTAS</option>
                            <option class='col-sm-12' value='RISA'>ANTONIO DE JESUS RIVERA SANCHEZ</option>
                           <option class='col-sm-12' value='ROMO'>OSCAR ALONSO ROJAS MUÑOZ</option>
                        </select>
                  </div>
                    <div class="form-group">
                        <?php echo TxtDateRango();?>
                    </div>
<!--                    <div class="form-group">
                        <label for="inputFechaIni">Mes:</label>
                        <select id="TxtMes" name="TxtMes" class="form-control">
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputFechaIni">Ejercicio:</label>
                        <input type="text" class="form-control" id="TxtEjercicio" name="TxtEjercicio" value="<?php echo date("Y");?>" placeholder="Ingrese ejercicio">
                    </div>-->
                                        <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>                     <button type="button" id="btnExcel" class="btn btn-success btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Excel</button>                     <button type="button" id="btnPDF" class="btn btn-danger btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> PDF</button>                     <button type="button" id="btnPrint" class="btn btn-default btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
                </form>
                <div class="respuesta"></div>                 
                <div class="form-inline">
                    <label for="inputFechaIni">Filtro:</label>
                    <input type="text" class="form-control" id="txtbusqueda" name="txtbusqueda" data-column-index='0' value="" placeholder="Busqueda rapida">
                </div>
				<?php echo CargaGif();?>
            </div>
        </div>
        <?php echo Script(); ?>
    </body>

    <script type="text/javascript">
        $(function() {        $( "#btnExcel" ).click(function() {$('.buttons-excel').click();});         $( "#btnPDF" ).click(function() {$('.buttons-pdf').click();});         $( "#btnPrint" ).click(function() {$('.buttons-print').click();});
            document.addEventListener('touchmove', function(e) {
                e.preventDefault();
                var touch = e.touches[0];
                //alert(touch.pageX + " - " + touch.pageY);
            }, false);
/*            $("form").on('submit', function(e) {
                e.preventDefault();
				$('#CargaGif').show();
                $('#btnEnviar').attr('disabled', 'disabled')
                $.ajax({
                    type: "POST",
                    url: 'tabla-vtasnetas.php',
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
            });*/

/*            $('tr.vendedor').dblclick(function() {
                var id = $(this).attr("id");
                alert(id);
                $("#TxtClave").val(id);
                $('#CargaGif').show();
                $.ajax({
                    type: "POST",
                    url: 'tabla-vtasnetasdet.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $(".vtasdetalles").html(data); // Mostrar la respuestas del script PHP.
                        $(".vtasdetalles").show();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });*/
            $("form").on('submit', function(e) {
                e.preventDefault();
				$('#CargaGif').show();
                $('#btnEnviar').attr('disabled', 'disabled')
                $.ajax({
                    type: "POST",
                    url: 'tabla-vtastallerbit.php',
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
            
/*            $('tr.vendedor').click(function() {
                var id = $(this).attr("id");
                $("#TxtClave").val(id);
                //$('#CargaGif').show();// Evitar ejecutar el submit del formulario.
            });*/
        });

        $('select#TxtMes').on('change', function() {
            var id = $('#TxtEjercicio').val();
            var name = $('#TxtMes option:selected').html();
            $("#title").html("Reporte ventas - CLAVE " + id + " - " + name);
            $("#cabecera").html("REPORTE DE ESTADOS - PERIODO " + name + " - " + id );
        });
        
        $(document).on('dblclick touchstart','tr.vendedor',function(){
            var id = $(this).attr("id");
            $("#TxtClave").val(id);
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-vtasnetasdet.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $(".vtasdetalles").html(data); // Mostrar la respuestas del script PHP.
                    $(".vtasdetalles").show();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        });

    </script>

</html>
