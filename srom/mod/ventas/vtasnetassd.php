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
                        <label for="inputFechaIni">Ejercicio:</label>
                        <input type="text" class="form-control" id="TxtEjercicio" name="TxtEjercicio" value="<?php echo date("Y");?>" placeholder="Ingrese ejercicio">
                    </div>
                    <div class="form-group">
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
						  <label for="inputFechaIni">Moneda:</label>
						  <select id="CmbMoneda" name="CmbMoneda" class="form-control">
							  <option>PESOS</option>
							  <option>DOLARES</option>
						  </select>
					  </div>
                    <div class="form-group">
                        <label for="inputFechaIni">Ejercicio:</label>
                        <input type="hidden" class="form-control" id="TxtClave" name="TxtClave" value="" placeholder="Ingrese ejercicio">
                    </div>
                                        <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>                     <button type="button" id="btnExcel" class="btn btn-success btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Excel</button>                     <button type="button" id="btnPDF" class="btn btn-danger btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> PDF</button>                     <button type="button" id="btnPrint" class="btn btn-default btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
                </form>
                <div class="controles form-horizontal">

                </div>
                <div class="respuesta col-lg-12 col-sm-12 col-md-12 col-xs-12"></div>
                <?php echo MdlSearchLG('MdlMaqDet','MdlMaqDet');?>
                <div class="vtasdetalles col-lg-12 col-sm-12 col-md-12 col-xs-12"></div>
                <span id="TotalFac"></span>
                <div class="vtasfacturas col-lg-12 col-sm-12 col-md-12 col-xs-12"></div>
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
            $("form").on('submit', function(e) {
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
        
        $(document).on('click touchstart','td.btn_facturado',function(){
            /*
            var id = $(this).attr("id");
            alert(id);
            $("#TxtClave").val(id);
            */
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-vtasnetasfac.php',
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
        
        $(document).on('click touchstart','td.btn_devoluciones',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-vtasnetasdev.php',
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
        
         $(document).on('click touchstart','td.btn_descuentos',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-vtasnetasdes.php',
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
        
         $(document).on('click touchstart','td.btn_garantreem',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-vtasnetasrem.php',
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
        
         $(document).on('click touchstart','td.btn_garantianore',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-vtasnetasnre.php',
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

        $(document).on('click touchstart','td.btn_refacturacion',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-vtasnetasnre.php',
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

        $(document).on('click touchstart','td.btn_abonomes',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-vtasnetasabo.php',
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
        
        $(document).on('click touchstart','td.btn_devoproducto',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-vtasnetasdev.php',
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
        
        $(document).on('click touchstart','td.btn_devorefactutacion',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-vtasnetasref.php',
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
        
        $(document).on('click touchstart','td.btn_cobrado',function(){
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-vtasnetascob.php',
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
