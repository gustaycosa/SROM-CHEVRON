<?php
// Inicio session
   session_start();
// Compruebo q exista
   if(isset($_SESSION)){
     session_unset();
      session_destroy();
   } 
?>
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
            <form id="formulario" method="POST" class="form-inline">
                <div class="form-group">
                    <label for="inputtext3">Empresa:</label>
                    <select id="CmbEmpresa" name="CmbEstatus" class="form-control">
                        <option class="col-sm-12" value="EAGLE">EAGLE</option>
                        <option class="col-sm-12" value="LINCOLN">LINCOLN</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputtext3" class="col-sm-3 control-label">Sucursal:</label>
                    <div class="col-sm-9 ">
                        <?php echo CmbCualquieras('ID_SUCURSAL','SUCURSAL','SUCURSALES'); ?>
                    </div>
                </div>
                <div id="xxx" class="form-group">
                    <label for="inputFechaIni">Vendedor:</label>
                    <?php echo CmbCualquieras('id_vendedor','nombre','VENDEDORES'); ?>
                </div>
                <div class="form-group">
                    <?php echo TxtDateRango(); ?>
                </div>
                <button type="submit" id="btnEnviar" class="btn btn-info btn-block" onMouseOver="">
                    <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Cargar Coordenadas
                </button>
            </form>

            <div id="map" style="height: 400px;width: 100%;"></div>

            <?php echo CargaGif();?>
        </div>
    </div>



</body>

<?php echo Script1(); ?>

<script type="text/javascript">
    var map;
    var markers = [];

    function initMap() {
        var eagle = {
            lat: 25.557273199999997,
            lng: -103.4651153
        };
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: eagle
        });
        //var marker = new google.maps.Marker({position: eagle, map: map,title: 'Hello World!',icon:'../../images/green-dot.png'});
        addMarker(eagle);
    }
    // Adds a marker to the map and push to the array.
    function addMarker(location, title, icon) {
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title: title,
            icon: icon,
        });
        markers.push(marker);
    }

    // Sets the map on all markers in the array.
    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }

    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
        setMapOnAll(null);
    }

    // Shows any markers currently in the array.
    function showMarkers() {
        setMapOnAll(map);
    }

    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
        clearMarkers();
        markers = [];
    }

    function EndEvents() {
        $('#CargaGif').hide();
        $('#btnEnviar').removeAttr('disabled');
        $('#btnEnviar2').removeAttr('disabled');
    }

    function EnviarInfo() {
        $.ajax({
            type: "POST",
            url: 'tabla-verBitacora.php',
            data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
            success: function(data) {
                deleteMarkers();
                EndEvents();
                var res = JSON.parse(data);
                var i;
                for (i = 0; i < res.length; i++) {
                    var Lat = res[i].Latitud_Chekcin;
                    var Lng = res[i].Longitud_checkin;
                    var checkin = {
                        lat: parseFloat(Lat),
                        lng: parseFloat(Lng)
                    };
                    var checkout = {
                        lat: parseFloat(res[i].latitud_checkout),
                        lng: parseFloat(res[i].Longitud_Checkout)
                    };
                    var title = res[i].Nombre + "," + res[i].Fecha;
                    var icon1 = '../../images/green-dot.png';
                    var icon2 = '../../images/red-dot.png';
                    addMarker(checkin, title, icon1);
                    addMarker(checkout, title, icon2);
                }
            },
            error: function(error) {
                EndEvents();
                console.log(error);
                alert('Algo salio mal :S');
            }
        });
    }
    $('select#CmbEmpresa').on('change', function() {
        $('#CargaGif').show();
        $('#btnEnviar').attr('disabled', 'disabled');
        $.ajax({
            url: 'CmbGenerico.php',
            type: 'POST',
            async: true,
            data: $("#formulario").serialize(),
            success: function(data) {
                $("#xxx").html(data); // Mostrar la respuestas del script PHP.
            },
            error: function(error) {
                console.log(error);
                alert('Algo salio mal :S');
            }
        });
    });
    $('select#CmbSUCURSALES').on('change', function() {
        $('#CargaGif').show();
        $('#btnEnviar').attr('disabled', 'disabled');
        $.ajax({
            url: 'CmbGenerico.php',
            type: 'POST',
            async: true,
            data: $("#formulario").serialize(),
            success: function(data) {
                EndEvents();
                $("#xxx").html(data); // Mostrar la respuestas del script PHP.
            },
            error: function(error) {
                EndEvents();
                console.log(error);
                alert('Algo salio mal :S');
            }
        });
    });
    $("#formulario").on('submit', function(e) {
        e.preventDefault();
        $('#CargaGif').show();
        $('#btnEnviar').attr('disabled', 'disabled');
        EnviarInfo();
        return false; // Evitar ejecutar el submit del formulario.
    });
    $(document).ready(function() {
        initMap();
    });

</script>

<!--API KEY AIzaSyDutX6VI6cioGVArPDXXZx-JcpH_OcDCLw-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDutX6VI6cioGVArPDXXZx-JcpH_OcDCLw&callback=initMap" async defer></script>

</html>
