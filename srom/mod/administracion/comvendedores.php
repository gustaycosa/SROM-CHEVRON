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
                  <?php echo CmbMoneda();?>
              </div>
              <div class="form-group">
                <?php echo TxtDateRango() ?>
              </div>
                                  <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>                     <button type="button" id="btnExcel" class="btn btn-success btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Excel</button>                     <button type="button" id="btnPDF" class="btn btn-danger btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> PDF</button>                     <button type="button" id="btnPrint" class="btn btn-default btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
              <input type="hidden" name="TxtClave" id="TxtClave" value="">
            </form>
            <div class="respuesta"></div>                 
            <div class="form-inline">
                <label for="inputFechaIni">Filtro:</label>
                <input type="text" class="form-control" id="txtbusqueda" name="txtbusqueda" data-column-index='0' value="" placeholder="Busqueda rapida">
            </div>
            <label id="lbltotal" style="font-size: 20px; background: yellow;"></label>
            <?php echo MdlSearchLG('MdlVenDet','Detalle vendedor');?>
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
               url: 'tabla-comvendedoressum.php',
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
        
        $('select#Cmbvendedores').on('change', function() {
            var id = $('#Cmbvendedores').val();
            var name = $('#Cmbvendedores option:selected').html();
            $("#title").html("Reporte ventas - CLAVE " + id + " - " + name);
            $("#cabecera").html("Reporte ventas - CLAVE " + id + " - " + name);
        });
        
        $(document).on('dblclick','tr.vendedor',function(){
            var id = $(this).attr("id");
            $("#TxtClave").val(id);
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'comvendedores-tabla.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $("#DivMdlVenDet").html(data); // Mostrar la respuestas del script PHP.
                    $("#DivMdlVenDet").show();
                    $('#MdlVenDet').modal('show');
                    $('#gridvend').DataTable().draw();
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

</script>

</html>