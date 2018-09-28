<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php");
    $TituloPantalla = "Reporte de Existencias";
    echo Cabecera($TituloPantalla);
?>

    <body>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6><?php echo $TituloPantalla; /*Incluir modal nvo*/?></h6>
            </div>
            <div class="panel-body">
                <form id="formulario" method="POST" action="/" class="form-inline">
                    <div class="form-group">
                        <?php echo CmbCualquieras('depto','nombre',"deptos"); ?>
                    </div>
                    <div class="form-group">
                        <?php echo CmbCualquieras("division","nombre","divisiones"); ?>
                    </div>
                    <div id="xxx" class="form-group">
                        <?php echo CmbGenerico(' ',' '); ?>
                    </div>
                    <div class="form-group">
                        <input type="text" name="Txtfiltro" id="Txtfiltro" value="" class="form-control" placeholder="Palabras clave" />
                    </div>
                    <div class="form-group">
                        <input type="submit" id="btnEnviar" name="action" class="btn btn-primary btn-sm" value="Consultar" onMouseOver="" />
                    </div>
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
        $(document).ready(function() {
            var Txtfiltro = new LiveValidation('Txtfiltro');
            Txtfiltro.add( Validate.Presence );
            Txtfiltro.add( Validate.Length, { minimum: 3, maximum: 15 } );
        });
    </script>
    <script type="text/javascript">
        $( "#Txtfiltro" ).focusout(function() {
            if ($( "#Txtfiltro" ).text = ''){
                $('#btnEnviar').attr('disabled', 'disabled');
            }else{
                $('#btnEnviar').removeAttr('disabled');
            }
        });

        $('select#Cmbdivisiones').on('change', function() {
            $.ajax({
                url: 'cmbgenerico.php',
                type: 'POST',
                async: true,
                data: $("form").serialize(),
                success: function(data) {
                    $("#xxx").html(data); // Mostrar la respuestas del script PHP.
                },
                error: function(error) {
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
        });

        $('select#Cmbdeptos').on('change', function() {
            $.ajax({
                url: 'cmbgenerico.php',
                type: 'POST',
                async: true,
                data: $("form").serialize(),
                success: function(data) {
                    $("#xxx").html(data); // Mostrar la respuestas del script PHP.
                },
                error: function(error) {
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
        });

        $("form").on('submit', function(e) {
            if ($( "#Txtfiltro" ).text = ''){
                $('#btnEnviar').attr('disabled', 'disabled');
            }else{
                $('#btnEnviar').removeAttr('disabled');
                e.preventDefault();
                $('#CargaGif').show();
                $('#btnEnviar').attr('disabled', 'disabled')
                $.ajax({
                    type: "POST",
                    url: 'tabla-admexistencias.php',
                    data: $("form").serialize(),
                    success: function(data) {
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
            }

        });
    
        /*
                $("#enlaceajax").click(function(evento){
                  evento.preventDefault();
                  $("#cargando").css("display", "inline");
                  $("#destino").load("pagina-lenta.php", function(){
                     $("#cargando").css("display", "none");
                });
        */

    </script>

</html>
