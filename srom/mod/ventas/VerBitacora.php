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
    $TituloPantalla = 'VerBitacora';   
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
                    <button type="submit" id="btnEnviar" class="btn btn-info btn-block" onMouseOver="">
                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Cargar Coordenadas
                    </button>
                </form>
                
                <div id="map" style="height: 400px;width: 100%;"></div>
                
                <?php echo CargaGif();?>
            </div>
        </div>
<!--        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuugxmoQ9dyQBfaYExuWAHjKrW1ARalXQ&callback=initMap" async defer></script>-->
            <!--API KEY AIzaSyA3Vr5QkRid8gCNM0BplsaSdIMlaiAE3RQ-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3Vr5QkRid8gCNM0BplsaSdIMlaiAE3RQ&callback=initMap"
        async defer></script>        
    </body>

    <?php echo Script1(); ?>

    <script type="text/javascript">
         var map;
        function initMap() {
            var uluru = {lat: 25.557273199999997, lng: -103.4651153};
            map = new google.maps.Map(document.getElementById('map'), {zoom: 12, center: uluru});
            //var marker = new google.maps.Marker({position: uluru, map: map,title: 'Hello World!',icon:'../../images/green-dot.png'});
        }
        function EndEvents(){
             $('#CargaGif').hide();
             $('#btnEnviar').removeAttr('disabled');
             $('#btnEnviar2').removeAttr('disabled');
        }
        function EnviarInfo(){
            $.ajax({
                    type: "POST",
                    url: 'tabla-verBitacora.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        EndEvents();
                    var res = JSON.parse(data);
                        var i ;
                        for (i = 0; i < res.length; i++) { 
                            var Lat=res[i].Latitud_Chekcin;
                            var Lng =res[i].Longitud_checkin;
                            var checkin = {lat: parseFloat(Lat), lng:parseFloat(Lng) };
                            var checkout = {lat: parseFloat(res[i].latitud_checkout), lng: parseFloat(res[i].Longitud_Checkout)};        
                            var marker = new google.maps.Marker({position: checkin, map: map,title: res[i].Nombre +","+ res[i].Fecha ,icon:'../../images/green-dot.png'});
                            var marker = new google.maps.Marker({position: checkout, map: map,title: res[i].Nombre +","+ res[i].Fecha  ,icon:'../../images/red-dot.png'});
                       }
                    },
                    error: function(error) {
                        EndEvents();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });  
        }
        $("#formulario").on('submit', function(e) {
            e.preventDefault();
            $('#CargaGif').show();
            $('#btnEnviar').attr('disabled', 'disabled');
            EnviarInfo();
            return false; // Evitar ejecutar el submit del formulario.
        });        
        $( document ).ready(function() {
                initMap();
        });
    </script>

</html>
