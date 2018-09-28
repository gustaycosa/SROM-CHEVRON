<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Folios checklist'); ?>
<?php
    $TituloPantalla = 'Folios checklist';    
?>
<body>

<?php include("navbarv.php"); ?>
    <div class="panel panel-default"> 
        <div class="panel-heading">
            <h6 id="cabecera"><?php ECHO $TituloPantalla; /*Incluir modal nvo*/?>
            </h6></div> 
        <div class="panel-body"> 

            <form id="formulario" method="POST" class="form-inline">
              <div class="form-group">
                <label for="inputFechaIni">Empleado:</label>
                <?php echo CmbCualquieras('id','nombre','NOMBRESUSUARIOWEB'); ?>
              </div>
              <div class="form-group">
                  <label for="inputFechaIni">Serie:</label>
                  <select id="CmbSerie" name="CmbSerie" class="form-control">
                        <option>H</option>
                        <option>S</option>
                        <option>T</option>
                        <option>D</option>
                        <option>DG</option>
                        <option>V</option>
                  </select>
              </div>
              <div class="form-group">
                <label for="inputFechaIni">De:</label>
                <input type="text"  name="txtde" id="txtde" value="" class="form-control" placeholder="De"/>
              </div>
              <div class="form-group">
                <label for="inputFechaFin">A:</label>
                <input type="text"  name="txta" id="txta" value="" class="form-control" placeholder="A"/>
              </div>
                                  <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>                     <button type="button" id="btnExcel" class="btn btn-success btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Excel</button>                     <button type="button" id="btnPDF" class="btn btn-danger btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> PDF</button>                     <button type="button" id="btnPrint" class="btn btn-default btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
            </form>
            <div class="respuesta"></div>                 
            <div class="form-inline">
                <label for="inputFechaIni">Filtro:</label>
                <input type="text" class="form-control" id="txtbusqueda" name="txtbusqueda" data-column-index='0' value="" placeholder="Busqueda rapida">
            </div>
        </div>
    </div>
</body>

<?php echo Script(); ?>
    
<script type="text/javascript"> 

        
     $(function () {       $( "#btnExcel" ).click(function() {$('.buttons-excel').click();});         $( "#btnPDF" ).click(function() {$('.buttons-pdf').click();});         $( "#btnPrint" ).click(function() {$('.buttons-print').click();});
         $("form").on('submit', function (e) {

         e.preventDefault();
         $('#btnEnviar').attr('disabled', 'disabled')
         $.ajax({
               type: "POST",
               url: 'tablaFoliosChecklist.php',
               data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
               success: function(data)
               {
                   $('#btnEnviar').removeAttr('disabled');
                   $(".respuesta").html(data); // Mostrar la respuestas del script PHP.
               },
                error: function(error) {
                    console.log(error);
                    alert('Algo salio mal :S');
                }
             });

        return false; // Evitar ejecutar el submit del formulario.
        });
        
        $('select#Cmbvendedores').on('change', function() {
            var id = $('#Cmbvendedores').val();
            var name = $('#Cmbvendedores option:selected').html();
            $("#title").html("Reporte ventas - CLAVE " + id + " - " + name);
            $("#cabecera").html("Reporte ventas - CLAVE " + id + " - " + name);
        });
    });

</script>

</html>