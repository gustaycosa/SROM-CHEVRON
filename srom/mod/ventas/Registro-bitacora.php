<?php
// Inicio session
   session_start();
// Compruebo q exista
   if(isset($_SESSION)){
     session_unset();
      session_destroy();
   } 
?>
<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php 
    include("../../funciones.php"); 
    $TituloPantalla = 'Bitacora';   
    echo Cabecera($TituloPantalla);  
?>

    <body id="bdy">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 id="cabecera">
                    <?php echo $TituloPantalla; ?>
                </h6>
            </div>
            <div class="panel-body">
                
                
                <form id="formulario" method="POST" class="form-inline" style="padding: 2em;">
                    <input type="hidden" name="lat"  id="lat">
                    <input type="hidden" name ="lon" id="lon">
                    <input type="hidden" name ="IdUsuario" value='<?php echo $_REQUEST["e"]; ?>'>
                    <input type="hidden" name="opt" id="opt" >
                    <button type="submit" id="btnEnviar" class="btn btn-primary btn-block" onMouseOver="">
                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Chek-in
                    </button>
                </form> 
                 <form id="frmcheckout" method="POST" class="form-inline" style="padding-bottom: 2em;padding-left: 2em;padding-right: 2em;">
                    <input type="hidden" name ="lat2" id="lat2" >
                    <input type="hidden" name ="lon2" id="lon2">
                        <div class="form-group">
                                <label for="comment">Comentarios:</label>
                                <textarea class="form-control" rows="5"  name = "comentarios" id="comentarios"></textarea>
                        </div>
                        <button type="submit" id="btnEnviar2" class="btn btn-success btn-block">
                            <span class="glyphicon glyphicon-share" aria-hidden="true"></span>  Check-Out
                        </button>
                </form>
                <?php echo CargaGif();?>
            </div>
        </div>
    </body>

    <?php echo Script1(); ?>

    <script type="text/javascript">
        function getLocation() {
                if (navigator.geolocation) {
                    
                    navigator.geolocation.getCurrentPosition(showPosition,function (error) { 
                        if (error.code == error.PERMISSION_DENIED){
                             alert("No es posible determinar su posición geográfica, Compruebe que se encuentre activada la localización del dispositivo");    
                        EndEvents();
                        }
                    });
                }
        }
        function showPosition(position) {
            $("#lat").val(position.coords.latitude);
            $("#lon").val(position.coords.longitude);
            $("#lat2").val(position.coords.latitude);
            $("#lon2").val(position.coords.longitude);
            EnviarInfo();
        }
        
        function EndEvents(){
             $('#CargaGif').hide();
             $('#btnEnviar').removeAttr('disabled');
             $('#btnEnviar2').removeAttr('disabled');
        }
        function EnviarInfo(){
            $.ajax({
                    type: "POST",
                    url: 'tablaRegistroBitacora.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        EndEvents();
                        res=JSON.parse(data);
                        alert(res.Mensaje);
                    },
                    error: function(error) {
                        EndEvents();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });  
        }
        
        $("#formulario").on('submit', function(e) {
            $("#opt").val(1);
            e.preventDefault();
            $('#CargaGif').show();
            $('#btnEnviar').attr('disabled', 'disabled');
            getLocation()
            return false; // Evitar ejecutar el submit del formulario.
        });
        
        $("#frmcheckout").on('submit', function(e) {
            e.preventDefault();    
             if ($("#comentarios").val() == ""){
                alert("Los Comentarios no pueden estar vacios");
                $("#comentarios").focus();
             }
            else{
                $('#CargaGif').show();
                $('#btnEnviar2').attr('disabled', 'disabled');
                $("#opt").val(2);
                getLocation();
                return false; // Evitar ejecutar el submit del formulario.
            }
        });
    </script>

</html>
