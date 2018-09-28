<?php include("validasesion.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Existencias'); ?>
<?php
	$TituloPantalla = "Catalogo de usuarios";//TITULO EN PANTALLA
?>
    <?php
	$Columnas = array("id", "usuario","Tipo","nombre","Perfil","grupo","telefono");//COLUMNAS GRID
	$CamposNvo = array("Usuario","Pass","Nombre","Celular","Empresa","Grupo","Perfil","Correo","PassCorreo","UsuarioFUM");//CAMPOS MODAL NUEVO
	$CamposNvoTipo = array("txt","txt","txt","txt","txt","txt","txt","txt","txt","txt");//CAMPOS MODAL TIPOS
    $WSFucntion = "Usuarios" ;
?>

        <body>

            <?php include("navbarv.php"); ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6>
                        <?php echo $TituloPantalla; /*Incluir modal nvo*/?>
                    </h6>
                </div>
                <div class="panel-body">
                    <?php $Columnas; /*Incluir modal nvo*/?>
                    <form id="formulario" method="POST" class="form-horizontal">
                        <!--<input type="submit" id="btnEnviar" class="btn btn-primary btn-sm col-sm-2" value="Consultar" onMouseOver="">-->
            <button id="BtnRefrescar" type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#myModal">
              <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
              Nuevo
          </button>
                        <button id="BtnModificar" type="button" class="btn btn-sm btn-default" disabled data-toggle="modal" data-target="#UserNvo">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
              Modificar
          </button>
                        <button id="BtnEliminar" type="button" class="btn btn-sm btn-default" disabled data-toggle="modal" data-target="#UsuariosDel">
              <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
              Eliminar
          </button>
                    </form>
                    <div class="controles form-horizontal">
                        <?php include("FormModificar.php"); ?>
                        <?php include("usuarios-nvo.php"); ?>
                        <?php include("usuarios-del.php"); ?>
                    </div>
                    <div class="respuesta ">
                        <?php include("tabla.php"); ?>
                    </div>
                </div>
                <?php 
        //$Columnas = array ("id", "usuario","Tipo","nombre","Perfil","grupo","telefono");
        //echo PasaArreglo($Columnas); 
    ?>
                <?php $CamposNvo; /*Incluir modal nvo*/?>
                <?php $CamposNvoTipo; /*Incluir modal nvo*/?>

        </body>


        <?php echo Script(); ?>
        <script type="text/javascript">
            $('.identificador').click(function() {
                //alert('Fila = '+id);
                $('#BtnModificar').removeAttr('disabled');
                $('#BtnEliminar').removeAttr('disabled');
                var id = $(this).attr("data-id");
                $.ajax({
                    url: "Modificar.php",
                    type: "POST",
                    async: true,
                    data: {
                        Data1: $(this).attr("data-id")
                    },
                    success: function(data) {
                        //do somthing here
                        var id = $(this).attr("data-id");
                        $("#txtId").val(id);
                        $('.datos').html(data);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $("#Controles").submit(function(e) {
                $.ajax({
                    url: "usuarios-wsupdate.php",
                    type: "POST",
                    async: false,
                    data: $("form").serialize(),
                    success: function(data) {
                        alert('success Algo salio bien :)');
                        $(".controles").html(data); // Mostrar la respuestas del script PHP.
                        $('#BtnModificar').attr('disabled', 'disabled')
                        $('#BtnEliminar').attr('disabled', 'disabled')
                    },
                    error: function(error) {
                        console.log(error);
                        alert('error Algo salio mal :S');
                    }
                });
                //return false; // Evitar ejecutar el submit del formulario.
                e.preventDefault();
            });
            
            $("#FormUserNvo").submit(function(e) {
                $.ajax({
                    url: "usuarios-wsinsert.php",
                    type: "POST",
                    async: false,
                    data: $("form").serialize(),
                    success: function(data) {
                        alert('success Algo salio bien :)');
                        $(".controles").html(data); // Mostrar la respuestas del script PHP.
                    },
                    error: function(error) {
                        console.log(error);
                        alert('error Algo salio mal :S');
                    }
                });
                //return false; // Evitar ejecutar el submit del formulario.
                e.preventDefault();
            });

            $("#FormUserDel").submit(function(e) {
                $.ajax({
                    url: "usuarios-wsdelete.php",
                    type: "POST",
                    async: false,
                    data: $("form").serialize(),
                    success: function(data) {
                        alert('success Algo salio bien :)');
                        $(".controles").html(data); // Mostrar la respuestas del script PHP.
                    },
                    error: function(error) {
                        console.log(error);
                        alert('error Algo salio mal :S');
                    }
                });
                //return false; // Evitar ejecutar el submit del formulario.
                e.preventDefault();
            });
            
            /*
            $('input#btnModificar').click( function(e) {
                $.ajax({
                    url: 'ModElemento.php',
                    type: 'POST',
                    dataType: 'application/json',
                    data: $('form#Controles').serialize(),
                    success: function(data) {
                       alert('Algo salio bien :)');
                    }
                });
                e.preventDefault();
            });                                                                                                                                         
            */
            <?php include("grid_full.php"); ?>

        </script>

</html>
