<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Comisiones vendedores'); ?>
<?php
    $TituloPantalla = 'Comisiones vendedores';    
?>
<body>

    <div class="panel panel-default"> 
        <div class="panel-heading">
            <h6 id="cabecera"><?php ECHO $TituloPantalla; /*Incluir modal nvo*/?>
            </h6></div> 
        <div class="panel-body"> 

            <form id="formulario" method="POST" class="form-inline">
              <div class="form-group">
                  <label for="inputFechaIni">Empresa:</label>
                  <select id="CmbEmpresa" name="CmbEmpresa" class="form-control">
                      <option>TAYCOSA</option>
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
                <label for="inputFechaIni">De:</label>
                <input type="date"  name="Fini" id="Fini"  value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Rango Fecha Inicial"/>
              </div>
              <div class="form-group">
                <label for="inputFechaFin">A:</label>
                <input type="date" name="Ffin" id="Ffin" value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Rango Fecha Final" >
              </div>
                                  <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>                     <button type="button" id="btnExcel" class="btn btn-success btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Excel</button>                     <button type="button" id="btnPDF" class="btn btn-danger btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> PDF</button>                     <button type="button" id="btnPrint" class="btn btn-default btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
                
                <input type="text"  name="TotalComisiones" id="TotalComisiones" class="form-control">
                
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
         $('#btnEnviar').attr('disabled', 'disabled')
         $.ajax({
               type: "POST",
               url: 'comvendedores-tabla.php',
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