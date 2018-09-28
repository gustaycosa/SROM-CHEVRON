<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Reporte Facturacion Diaria'); ?>
<?php
    $TituloPantalla = 'Reporte Facturacion Diaria';    
?>

    <body>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 id="cabecera">
                    <?php ECHO $TituloPantalla; /*Incluir modal nvo*/?>
                </h6>
            </div>
            <div class="panel-body">
                <form id="formulario" method="POST" class="form-inline">
                    <div class="form-group">
                        <label for="inputFechaIni">Moneda:</label>
                        <select id="CmbMoneda" name="CmbMoneda" class="form-control">
                            <option>PESOS</option>
                            <option>DOLARES</option>
                        </select>
                    </div>
                    <div class="input-group">
                      <input type="text" class="form-control" id="TxtCliente" name="TxtCliente" placeholder="Buscar cliente">
                      <span class="input-group-btn">
                        <button class="btn btn-sm btn-primary" id='ClientesPop' type="button" data-toggle="modal" data-target="#myModal">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                      </span>
                    </div>
                    <div class="form-group">
                        <label for="inputFechaIni">De:</label>
                        <input type="date" name="Fini" id="Fini" value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Rango Fecha Inicial" />
                    </div>
                    <div class="form-group">
                        <label for="inputFechaFin">A:</label>
                        <input type="date" name="Ffin" id="Ffin" value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Rango Fecha Final">
                    </div>
                    <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">Consultar</button>
                </form>
                <div class="controles form-horizontal">
            
                </div>
                <div class="respuesta"></div>
                <?php echo CargaGif();?>
            </div>
        </div>
    </body>

    <?php echo Script(); ?>

    <script type="text/javascript">
        $(function() {

            $("form").on('submit', function(e) {

                e.preventDefault();
                $('#CargaGif').show();
                $('#btnEnviar').attr('disabled', 'disabled')
                $.ajax({
                    type: "POST",
                    url: 'tabla-tallfactdiariataller.php',
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

        $(document).on('dblclick touchstart','.Seleccionado',function(){
            var id = $(this).attr("id");
            var name = $(this).attr("data-name");
            $("#TxtCliente").val(id);
            $("#title").html("Reporte cliente - " + id + " " + name);
            $("#cabecera").html("Reporte cliente - " + id + " " + name);
            $('#myModal').modal('hide');
        });

        $(document).on('click touchstart','#ClientesPop',function(){
            $('#CargaGif').show();
            //$('#btnEnviar').attr('disabled', 'disabled')
            $.ajax({
                type: "POST",
                url: 'TablaClientes.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    $('#CargaGif').hide();
                    $('#btnEnviar').removeAttr('disabled');
                    $(".respuesta").html(data); // Mostrar la respuestas del script PHP.
                    $(".respuesta").show();
                    $('#myModal').modal('show')
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });

            return false; // Evitar ejecutar el submit del formulario.
        });

        
        $('#gridpop').DataTable( {
            fixedHeader: true,          
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
            "language": {
                "sProcessing":    "Procesando...",
                "sLengthMenu":    "Mostrar _MENU_ registros",
                "sZeroRecords":   "No se encontraron resultados",
                "sEmptyTable":    "Ningún dato disponible en esta tabla",
                "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":   "",
                "sSearch":        "Buscar:",
                "sUrl":           "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
            }
        } );

    </script>

</html>
