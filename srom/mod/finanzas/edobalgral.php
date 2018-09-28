<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Reporte de edos. balance general'); ?>
<?php
    $TituloPantalla = 'Reporte de edos. balance general';    
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
                        <?php echo TxtPeriodo();?>
                    </div>
                    <div class="form-group">
                        <?php echo CmbMes();?>
                    </div>

                                        <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>                     <button type="button" id="btnExcel" class="btn btn-success btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Excel</button>                     <button type="button" id="btnPDF" class="btn btn-danger btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> PDF</button>                     <button type="button" id="btnPrint" class="btn btn-default btn-sm" onMouseOver="">                         <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
                    
                    <button id="BtnAnaCli" class="btn btn-primary" type="button" data-toggle="modal" data-target="#MdlAntCli">
                        Clientes
                    </button>
                    <button id="BtnAnaDeu" class="btn btn-primary" type="button" data-toggle="modal" data-target="#MdlAnaDeu">
                        Deudores
                    </button>
                    <button id="BtnAnaAnt" class="btn btn-primary" type="button" data-toggle="modal" data-target="#MdlAnaAnt">
                        Anticipos
                    </button>
                    <button id="BtnAnaAcr" class="btn btn-primary" type="button" data-toggle="modal" data-target="#MdlAnaAcr">
                        Acreedores
                    </button>
                    <button id="BtnAnaPro" class="btn btn-primary" type="button" data-toggle="modal" data-target="#MdlAnaPro">
                        Proveedores
                    </button>
                    
                </form>
                <div class="respuesta"></div>                 
                <div class="form-inline">
                    <label for="inputFechaIni">Filtro:</label>
                    <input type="text" class="form-control" id="txtbusqueda" name="txtbusqueda" data-column-index='0' value="" placeholder="Busqueda rapida">
                </div>
                <?php echo CargaGif();?>
            </div>

            <?php echo MdlSearch('MdlAntCli','Clientes');?>
            <?php echo MdlSearch('MdlAnaAnt','Anticipos clientes');?>
            <?php echo MdlSearch('MdlAnaDeu','Deudores diversos');?>
            <?php echo MdlSearch('MdlAnaAcr','Acreedores diversos');?>
            <?php echo MdlSearch('MdlAnaPro','Proveedores');?>
        </div>
    </body>

    <?php echo Script(); ?>

    <script type="text/javascript">
        $(function() {        $( "#btnExcel" ).click(function() {$('.buttons-excel').click();});         $( "#btnPDF" ).click(function() {$('.buttons-pdf').click();});         $( "#btnPrint" ).click(function() {$('.buttons-print').click();});
            $('#BtnAnaCli').click(function() {
                //$('#btnEnviar').attr('disabled', 'disabled')
                $('#CargaGif').show();
                $.ajax({
                    type: "POST",
                    url: 'TablaAnaCli.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $("#DivMdlAntCli").html(data); // Mostrar la respuestas del script PHP.
                        $("#DivMdlAntCli").show();
                        $('#MdlAntCli').modal('show');
                        $('#gridcli').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });
            
            $('#BtnAnaDeu').click(function() {
                //$('#btnEnviar').attr('disabled', 'disabled')
                $('#CargaGif').show();
                $.ajax({
                    type: "POST",
                    url: 'TablaAnaDeu.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $("#DivMdlAnaDeu").html(data); // Mostrar la respuestas del script PHP.
                        $("#DivMdlAnaDeu").show();
                        $('#MdlAnaDeu').modal('show');
                        $('#griddeu').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });
            
            $('#BtnAnaPro').click(function() {
                //$('#btnEnviar').attr('disabled', 'disabled')
                $('#CargaGif').show();
                $.ajax({
                    type: "POST",
                    url: 'TablaAnaPro.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $("#DivMdlAnaPro").html(data); // Mostrar la respuestas del script PHP.
                        $("#DivMdlAnaPro").show();
                        $('#MdlAnaPro').modal('show');
                        $('#gridpro').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });
            
            $('#BtnAnaAnt').click(function() {
                //$('#btnEnviar').attr('disabled', 'disabled')
                $('#CargaGif').show();
                $.ajax({
                    type: "POST",
                    url: 'TablaAnaAnt.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $("#DivMdlAnaAnt").html(data); // Mostrar la respuestas del script PHP.
                        $("#DivMdlAnaAnt").show();
                        $('#MdlAnaAnt').modal('show');
                        $('#gridant').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });

            $('#MdlAnaAcr').click(function() {
                //$('#btnEnviar').attr('disabled', 'disabled')
                $('#CargaGif').show();
                $.ajax({
                    type: "POST",
                    url: 'TablaAnaAcr.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $("#DivMdlAnaAcr").html(data); // Mostrar la respuestas del script PHP.
                        $("#DivMdlAnaAcr").show();
                        $('#MdlAnaAcr').modal('show');
                        $('#gridacr').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });
            
            $("form").on('submit', function(e) {
                e.preventDefault();
                $('#CargaGif').show();
                $('#btnEnviar').attr('disabled', 'disabled')
                $.ajax({
                    type: "POST",
                    url: 'tabla-edobalgral.php',
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

        $('.Seleccionado').dblclick(function() {
            var id = $(this).attr("data-id");
            var name = $(this).attr("data-name");
            $("#TxtCliente").val(id);
            $("#title").html("Reporte cliente - " + id + " " + name);
            $("#cabecera").html("Reporte cliente - " + id + " " + name);
            $('#myModal').modal('hide');
        });

    </script>
</html>
