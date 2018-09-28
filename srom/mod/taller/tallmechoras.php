<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Bitacora horas mecanicos'); ?>
<?php
    $TituloPantalla = 'Bitacora horas mecanicos';  
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
                        <input type="hidden" id="TxtClave" name="TxtClave" value="">
                    </div>
                                        <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>                     <button type="button" id="btnExcel" class="btn btn-success btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Excel</button>                     <button type="button" id="btnPDF" class="btn btn-danger btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> PDF</button>                     <button type="button" id="btnPrint" class="btn btn-default btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
                </form>
                <div class="respuesta"></div>                 
                <div class="form-inline">
                    <label for="inputFechaIni">Filtro:</label>
                    <input type="text" class="form-control" id="txtbusqueda" name="txtbusqueda" data-column-index='0' value="" placeholder="Busqueda rapida">
                </div>
                <?php echo MdlSearchLG('MdlMaqDet','MdlMaqDet');?>
				<?php echo CargaGif();?>
            </div>
        </div>
        <?php echo Script(); ?>
    </body>

    <script type="text/javascript">
        $(function() {        $( "#btnExcel" ).click(function() {$('.buttons-excel').click();});         $( "#btnPDF" ).click(function() {$('.buttons-pdf').click();});         $( "#btnPrint" ).click(function() {$('.buttons-print').click();});

            $("form").on('submit', function(e) {
                e.preventDefault();
				$('#CargaGif').show();
                $('#btnEnviar').attr('disabled', 'disabled')
                $.ajax({
                    type: "POST",
                    url: 'tabla-tallmechoras.php',
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

            $('tr.vendedor').dblclick(function() {
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
            });
        });
        
        $(document).on('click touchstart','tr.mec',function(){
            var id = $(this).attr("id");
            $("#TxtClave").val(id);
        });

        $(document).on('dblclick touchstart','td.btn_SERVICIOTALLER',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-tallmechorasservicio.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $("#DivMdlMaqDet").html(data); // Mostrar la respuestas del script PHP.
                    $("#DivMdlMaqDet").show();
                    $('#MdlMaqDet').modal('show')
                    $('#gridfact').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        });
        
        $(document).on('dblclick touchstart','td.btn_MANTENIMIENTO',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-tallmechorasmtto.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $("#DivMdlMaqDet").html(data); // Mostrar la respuestas del script PHP.
                    $("#DivMdlMaqDet").show();
                    $('#MdlMaqDet').modal('show')
                    $('#gridfact').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        });
                
        $(document).on('dblclick touchstart','td.btn_PERMISOS',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-tallmechoraspermisos.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $("#DivMdlMaqDet").html(data); // Mostrar la respuestas del script PHP.
                    $("#DivMdlMaqDet").show();
                    $('#MdlMaqDet').modal('show')
                    $('#gridfact').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        });
        
        $(document).on('dblclick touchstart','td.btn_CAPACITACION',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-tallmechorascapacit.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $("#DivMdlMaqDet").html(data); // Mostrar la respuestas del script PHP.
                    $("#DivMdlMaqDet").show();
                    $('#MdlMaqDet').modal('show')
                    $('#gridfact').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        });
        
        $(document).on('dblclick touchstart','td.btn_TRASLADOS',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-tallmechorastraslado.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $("#DivMdlMaqDet").html(data); // Mostrar la respuestas del script PHP.
                    $("#DivMdlMaqDet").show();
                    $('#MdlMaqDet').modal('show')
                    $('#gridfact').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        });
        
        $(document).on('dblclick touchstart','td.btn_APOYODEMO',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-tallmechorasaprdemo.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $("#DivMdlMaqDet").html(data); // Mostrar la respuestas del script PHP.
                    $("#DivMdlMaqDet").show();
                    $('#MdlMaqDet').modal('show')
                    $('#gridfact').DataTable().draw();
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        });
        
        $(document).on('dblclick touchstart','td.btn_APOYOTALLER',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-tallmechorasapser.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $("#DivMdlMaqDet").html(data); // Mostrar la respuestas del script PHP.
                    $("#DivMdlMaqDet").show();
                    $('#MdlMaqDet').modal('show')
                    $('#gridfact').DataTable().draw();
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
