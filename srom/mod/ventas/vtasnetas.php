<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Ventas netas (sin IVA)'); ?>
<?php
    $TituloPantalla = 'Ventas netas (sin IVA)';  
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
                        <?php echo TxtPeriodo();?>
                    </div>
                    <div class="form-group">
                        <?php echo CmbMes();?>
                    </div>
				    <div class="form-group">
                        <?php echo CmbMoneda();?>
				    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="TxtClave" name="TxtClave" value="" placeholder="Ingrese ejercicio">
                    </div>
                    <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>                     <button type="button" id="btnExcel" class="btn btn-success btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Excel</button>                     <button type="button" id="btnPDF" class="btn btn-danger btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> PDF</button>                     <button type="button" id="btnPrint" class="btn btn-default btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
                </form>
                <div class="respuesta col-lg-12 col-sm-12 col-md-12 col-xs-12"></div>
                <div class="respuesta2 col-lg-12 col-sm-12 col-md-12 col-xs-12"></div>
                <?php echo MdlSearchLG('MdlMaqDet','MdlMaqDet');?>
                <div class="vtasdetalles col-lg-12 col-sm-12 col-md-12 col-xs-12"></div>
                <span id="TotalFac"></span>
                <div class="vtasfacturas col-lg-12 col-sm-12 col-md-12 col-xs-12"></div>             
                <div class="form-inline">
                    <label for="inputFechaIni">Filtro:</label>
                    <input type="text" class="form-control" id="txtbusqueda" name="txtbusqueda" data-column-index='0' value="" placeholder="Busqueda rapida">
                </div>
                <div style="padding-top: 1em;">
                  <form id="frmVtsPorEmpleado" method="POST" class="form-inline">
                    <div class="form-group">
                        <label for="inputFechaIni">Empleado:</label>
                        <?php echo CmbCualquieras('id_vendedor','nombre','VENDEDORES'); ?>
                    </div>
                    <div class="form-group">
                        <label for="inputFechaIni">De:</label>
                        <input type="date" name="Fini" id="Fini" value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Rango Fecha Inicial" />
                    </div>
                    <div class="form-group">
                        <label for="inputFechaFin">A:</label>
                        <input type="date" name="Ffin" id="Ffin" value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Rango Fecha Final">
                    </div>
                                        <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>                     <button type="button" id="btnExcel" class="btn btn-success btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Excel</button>                     <button type="button" id="btnPDF" class="btn btn-danger btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> PDF</button>                     <button type="button" id="btnPrint" class="btn btn-default btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
                </form>
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
            }, false);
                      
            $("form").on('submit', function(e) {
                e.preventDefault();
                $('#CargaGif').show();
                e.preventDefault();
                getData1(); 
            });
                      
         $("frmVtsPorEmpleado").on('submit', function(e) {
                e.preventDefault();
                $('#CargaGif').show();
                e.preventDefault();
                getData1(); 
            });
        });

        $('select#TxtMes').on('change', function() {
            var id = $('#TxtEjercicio').val();
            var name = $('#TxtMes option:selected').html();
            $("#title").html("Reporte ventas - CLAVE " + id + " - " + name);
            $("#cabecera").html("REPORTE DE ESTADOS - PERIODO " + name + " - " + id );
        });
        
        $(document).on('click touchstart','td.btn_facturado',function(){
            if(timer == 0) {
                timer = 1;
                timer = setTimeout(function(){ timer = 0; }, 600);
            }
            else { 
                var id = $(this).parent().attr("id");
                $("#TxtClave").val(id);
                $('#CargaGif').show();
                $("#myModalLabel").text('FACTURADO '+id);
                $.ajax({
                    type: "POST",
                    url: 'tabla-vtasnetasfac.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        $('#CargaGif').hide();
                        $(".vtasdetalles").html(data); // Mostrar la respuestas del script PHP.
                        $(".vtasdetalles").show();
                        $('#gridfact').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
                timer = 0; 
            }
	
        });
        
        function getData2(){
                $.ajax({
                    type: "POST",
                    url: 'tabla-vtasnetasnew.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
						$('#CargaGif').hide();
                        $('#btnEnviar').removeAttr('disabled');
                        $(".respuesta2").html(data); // Mostrar la respuestas del script PHP.
                        $(".respuesta2").show();
                    },
                    error: function(error) {
						$('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
               // return false; // Evitar ejecutar el submit del formulario.
        }
        function getData1(){
                $.ajax({
                    type: "POST",
                    url: 'tabla-vtasnetasnew2.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
						//$('#CargaGif').hide();
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
                //return false; // Evitar ejecutar el submit del formulario.
        }
    </script>
</html>
