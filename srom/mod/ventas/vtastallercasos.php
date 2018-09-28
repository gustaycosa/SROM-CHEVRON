<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Mecanicos ventas casos abiertos'); ?>
<?php
    $TituloPantalla = 'Mecanicos ventas casos abiertos';  
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
                          <label for="inputFechaIni" >Mecanico:</label>

                           <select id='CmbMECAVENTAS' name='CmbMECAVENTAS' class='form-control'>
                               <option value='0'>MECANICOS VENTAS</option>
                               <option class='col-sm-12' value='RISA'>ANTONIO DE JESUS RIVERA SANCHEZ</option>
                               <option class='col-sm-12' value='ROMO'>OSCAR ALONSO ROJAS MUÑOZ</option>
                            </select>
                      </div>
                    <input type="hidden" class="form-control" id="TxtClave" name="TxtClave" value="TAYCOSA" placeholder="Ingrese ejercicio">
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
        var timer = 0;
        $(function() {        $( "#btnExcel" ).click(function() {$('.buttons-excel').click();});         $( "#btnPDF" ).click(function() {$('.buttons-pdf').click();});         $( "#btnPrint" ).click(function() {$('.buttons-print').click();});
            document.addEventListener('touchmove', function(e) {
                e.preventDefault();
                var touch = e.touches[0];
                //alert(touch.pageX + " - " + touch.pageY);
            }, false);

            $("form").on('submit', function(e) {
                e.preventDefault();
				$('#CargaGif').show();
                $('#btnEnviar').attr('disabled', 'disabled')
                $.ajax({
                    type: "POST",
                    url: 'tabla-vtastallercasos.php',
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
        });

        $('select#TxtMes').on('change', function() {
            var id = $('#TxtEjercicio').val();
            var name = $('#TxtMes option:selected').html();
            $("#title").html("Reporte ventas - CLAVE " + id + " - " + name);
            $("#cabecera").html("REPORTE DE ESTADOS - PERIODO " + name + " - " + id );
        });
        
        $(document).on('click touchstart','td.btn_refacciones',function(){
            if(timer == 0) {
                timer = 1;
                timer = setTimeout(function(){ timer = 0; }, 600);
            }
            else { 
                var id = $(this).parent().attr("id");
                $("#TxtClave").val(id);
                $('#CargaGif').show();
                $("#myModalLabel").text('DEVOLUCION REFACTURACION '+id);
                $.ajax({
                    type: "POST",
                    url: 'tabla-vtastallercasosref.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $(".vtasdetalles").html(data); // Mostrar la respuestas del script PHP.
                        $(".vtasdetalles").show();
                        //$('#MdlMaqDet').modal('show')
                        //$('#gridfact').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.	
            }
        });
        
        $(document).on('click touchstart','td.btn_horasmo',function(){
            if(timer == 0) {
                timer = 1;
                timer = setTimeout(function(){ timer = 0; }, 600);
            }
            else { 
                var id = $(this).parent().attr("id");
                $("#TxtClave").val(id);
                $('#CargaGif').show();
                $("#myModalLabel").text('DEVOLUCION REFACTURACION '+id);
                $.ajax({
                    type: "POST",
                    url: 'tabla-vtastallercasoshrs.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $(".vtasdetalles").html(data); // Mostrar la respuestas del script PHP.
                        $(".vtasdetalles").show();
                        //$('#MdlMaqDet').modal('show')
                        //$('#gridfact').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.	
            }
        });

    </script>

</html>
