<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php 
    include("../../funciones.php"); 
    $TituloPantalla = 'Comisiones mecanicos (VENTAS)';
    echo Cabecera($TituloPantalla); 
    
?>
<body>

    <div class="panel panel-default"> 
        <div class="panel-heading"><h6 id="cabecera"><?php echo $TituloPantalla; /*Incluir modal nvo*/?></h6></div> 
        <div class="panel-body"> 

            <form id="formulario" method="POST" class="form-inline">
              <div class="form-group">
                  <label for="inputFechaIni">Mecanico:</label>
                  
                   <select id='CmbMECAVENTAS' name='CmbMECAVENTAS' class='form-control'><option value='0'>TODO CmbMECAVENTAS</option>
                        <option class='col-sm-12' value='RISA'>ANTONIO DE JESUS RIVERA SANCHEZ</option>
                       <option class='col-sm-12' value='ROMO'>OSCAR ALONSO ROJAS MUÑOZ</option>
                    </select>
              </div>
              <div class="form-group">
                  <?php echo TxtDateRango() ?>
              </div>
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
</body>

<?php echo Script(); ?>
    
<script type="text/javascript"> 

     $(function () {       $( "#btnExcel" ).click(function() {$('.buttons-excel').click();});         $( "#btnPDF" ).click(function() {$('.buttons-pdf').click();});         $( "#btnPrint" ).click(function() {$('.buttons-print').click();});
         $("form").on('submit', function (e) {
             e.preventDefault();
             $('#CargaGif').show();
             $('#btnEnviar').attr('disabled', 'disabled')
             $.ajax({
                   type: "POST",
                   url: 'tabla-admcommecanicosvtas.php',
                   data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                   success: function(data)
                   {
                       $('#CargaGif').hide();
                       $('#btnEnviar').removeAttr('disabled');
                       $(".respuesta").html(data); // Mostrar la respuestas del script PHP.
                   },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
             });
             return false; // Evitar ejecutar el submit del formulario.
         });
        
        $('select#Cmbnomempleados').on('change', function() {
            var id = $('#Cmbnomempleados').val();
            var name = $('#Cmbnomempleados option:selected').html();
            $("#title").html("Reporte comision - MECANICO " + id + " - " + name);
            $("#cabecera").html("Reporte comision - MECANICO " + id + " - " + name);
        });
    });

</script>

</html>