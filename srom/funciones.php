<?php
    $WebService = 'http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl';
    $Empresa = 'TAYCOSA';

    function CmbMes(){
        echo '<label for="inputFechaIni">Mes:</label>';
        echo '<select id="TxtMes" name="TxtMes" class="form-control">';
        echo '<option value="1">Enero</option>';
        echo '<option value="2">Febrero</option>';
        echo '<option value="3">Marzo</option>';
        echo '<option value="4">Abril</option>';
        echo '<option value="5">Mayo</option>';
        echo '<option value="6">Junio</option>';
        echo '<option value="7">Julio</option>';
        echo '<option value="8">Agosto</option>';
        echo '<option value="9">Septiembre</option>';
        echo '<option value="10">Octubre</option>';
        echo '<option value="11">Noviembre</option>';
        echo '<option value="12">Diciembre</option>';
        echo '</select>';
    }

    function TxtPeriodo(){
        echo '<label for="inputFechaIni">Ejercicio:</label>';
        echo '<input type="text" class="form-control" id="TxtEjercicio" name="TxtEjercicio" ';
        echo 'value="'. date("Y").'" placeholder="Ingrese ejercicio">';
    }

    function CmbMoneda(){
        echo '<label for="inputFechaIni">Moneda:</label>';
        echo '<select id="CmbMoneda" name="CmbMoneda" class="form-control">';
          echo '<option>PESOS</option>';
          echo '<option>DOLARES</option>';
        echo '</select>';
    }

    function TxtDateRango(){
        echo '<label for="inputFechaIni">De:</label>';
        echo '<input type="date"  name="Fini" id="Fini"  value="'.date("Y"."-"."m"."-"."01").'" class="form-control" placeholder="Rango Fecha Inicial"/>';
        echo '<label for="inputFechaFin">A:</label>';
        echo '<input type="date" name="Ffin" id="Ffin" value="'.date("Y-m-d").'" class="form-control" placeholder="Rango Fecha Final" >';
    }

    function CmbClientes(){
        echo '<div class="input-group-btn">';
        echo '<button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        echo '<span class="glyphicon glyphicon-search"></span></button>';
        echo '<ul id="CmbClientes" class="dropdown-menu">';
        echo '<li><a href="#">Ninguno</a></li>';
        echo '<li role="separator" class="divider"></li>';
        echo '<li><a href="#">Separated link</a></li>';
        echo '</ul>';
        echo '</div><!-- /btn-group -->';
        echo '<input type="text" class="form-control" id="TxtCliente" name="TxtCliente" placeholder="Buscar cliente o ID cliente">';
        echo '<div class="input-group-btn"> ';
        echo '<button type="button" id="btninfocliente" class="btn btn-default btn-sm" style="width: 200px; position: relative;white-space: nowrap; ';echo 'overflow: hidden; text-overflow: ellipsis;">Info cliente</button> ';
        echo '</div> ';
    }

    function JqueryCmbClientes(){
        echo 'var typingTimer;
        var doneTypingInterval = 2500;
        $("#TxtCliente").keyup(function(){
            clearTimeout(typingTimer);
            if ($("#TxtCliente").val()) {
               typingTimer = setTimeout(doneTyping, doneTypingInterval);
            }
        });
        
        function doneTyping (){
            var value = $("#TxtCliente").val();
            $("#TxtClave").text( value );
            $("#CargaGif").show();
            $.ajax({
                type: "POST",
                url: "CmbClientes.php",
                data: $("form").serialize(), 
                success: function(data) {
                    $("#CargaGif").hide();
                    $(".dropdown-menu").html(data); 
                    $(".dropdown-menu").show();
                },
                error: function(error) {
                    $("#CargaGif").hide();
                    console.log(error);
                    alert("Algo salio mal :S");
                }
            });
            return false;
        }
        
        $(document).on("click touchstart",".dropdown-menu li a",function(){
            var infocliente = $( this ).text();
            var idcliente = $( this ).attr("id");
            $("#btninfocliente").text( idcliente + "-" + infocliente );
            $("#TxtClave").val( idcliente );
            $(".dropdown-menu").hide();
        });
        ';
    }


    function CmbGenerico($sWhere1,$sWhere2){
        try{ 
            $WebService="http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl";
            //parametros de la llamada

            $parametros = array();
            $parametros['sWhere1'] = $sWhere1;
            $parametros['sWhere2'] = $sWhere2;
            //Invocación al web service
            $WS = new SoapClient($WebService,$parametros);
            //recibimos la respuesta dentro de un objeto
            $result = $WS->CBO_ALM_FAMILIAS($parametros);
            $xml = $result->CBO_ALM_FAMILIASResult->any;
            $obj = simplexml_load_string($xml);
            $Datos = $obj->NewDataSet->Table;

        } catch(SoapFault $e){
          var_dump($e);
        }
        $Cmb = "<select id='Cmbfamilia' name='Cmbfamilia' class='col-sm-12 form-control'><option value='0'>TODO ()</option>"; 
         for($i=0; $i<count($Datos); $i++){
            $Cmb = $Cmb."<option value='".$Datos[$i]->C1."'>".$Datos[$i]->C2."</option>";
        }
        $Cmb = $Cmb."</select>";

        echo $Cmb;
    }

    function CmbGenerico2($sWhere1,$sWhere2){
        try{ 
            $WebService="http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl";
            //parametros de la llamada

            $parametros = array();
            $parametros['sWhere1'] = $sWhere1;
            $parametros['sWhere2'] = $sWhere2;
            //Invocación al web service
            $WS = new SoapClient($WebService,$parametros);
            //recibimos la respuesta dentro de un objeto
            $result = $WS->CBO_ALM_MODELO($parametros);
            $xml = $result->CBO_ALM_MODELOResult->any;
            $obj = simplexml_load_string($xml);
            $Datos = $obj->NewDataSet->Table;

        } catch(SoapFault $e){
          var_dump($e);
        }
        $Cmb = "<select id='CmbModelo name='CmbModelo' class='col-sm-12 form-control'><option value='0'>TODO ()</option>"; 
         for($i=0; $i<count($Datos); $i++){
            $Cmb = $Cmb."<option value='".$Datos[$i]->C1."'>".$Datos[$i]->C2."</option>";
        }
        $Cmb = $Cmb."</select>";
        //return $Cmb;
        echo $Cmb;
    }


    function CmbCualquieras($sID,$sNombre,$sTabla){
        try{ 
            $WebService="http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl";
            //parametros de la llamada
            $parametros = array();
            $parametros['sID'] = $sID;
            $parametros['sNombre'] = $sNombre;
            $parametros['sTabla'] = $sTabla;
            //Invocación al web service
            $WS = new SoapClient($WebService,$parametros);
            //recibimos la respuesta dentro de un objeto
            $result = $WS->CmbCualquiera($parametros);
            $xml = $result->CmbCualquieraResult->any;
            $obj = simplexml_load_string($xml);
            $Datos = $obj->NewDataSet->Table;
        } catch(SoapFault $e){
          var_dump($e);
        }
        $Cmb = "<select id='Cmb".$sTabla."' name='Cmb".$sTabla."' class='form-control'><option value='0'>TODO (".$sTabla.")</option>"; 
         for($i=0; $i<count($Datos); $i++){
            $Cmb = $Cmb."<option class='col-sm-12' value='".$Datos[$i]->$sID."'>".$Datos[$i]->$sNombre."</option>";
        }
        $Cmb = $Cmb."</select>";
        return $Cmb;
    }

    function CmbCualquieraVtas($sPuesto,$sDepto){
        try{ 
            $WebService="http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl";
            //parametros de la llamada
            $parametros = array();
            $parametros['sPuesto'] = $sPuesto;
            $parametros['sDepto'] = $sDepto;
            //Invocación al web service
            $WS = new SoapClient($WebService,$parametros);
            //recibimos la respuesta dentro de un objeto
            $result = $WS->CmbCualquieraVtas($parametros);
            $xml = $result->CmbCualquieraVtasResult->any;
            $obj = simplexml_load_string($xml);
            $Datos = $obj->NewDataSet->Table;
        } catch(SoapFault $e){
          var_dump($e);
        }
        $Cmb = "<select id='CmbMECAVENTAS' name='CmbMECAVENTAS' class='form-control'><option value='0'>TODO CmbMECAVENTAS</option>"; 
         for($i=0; $i<count($Datos); $i++){
            $Cmb = $Cmb."<option class='col-sm-12' value='".$Datos[$i]->id_empleado."'>".$Datos[$i]->Nombre."</option>";
        }
        $Cmb = $Cmb."</select>";
        return $Cmb;
    }

    function CmbCualquieraNomb($sID,$sNombre,$sTabla){
        try{ 
            $WebService="http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl";
            //parametros de la llamada
            $parametros = array();
            $parametros['sID'] = $sID;
            $parametros['sNombre'] = $sNombre;
            $parametros['sTabla'] = $sTabla;
            //Invocación al web service
            $WS = new SoapClient($WebService,$parametros);
            //recibimos la respuesta dentro de un objeto
            $result = $WS->CmbCualquiera($parametros);
            $xml = $result->CmbCualquieraResult->any;
            $obj = simplexml_load_string($xml);
            $Datos = $obj->NewDataSet->Table;
        } catch(SoapFault $e){
          var_dump($e);
        }
        $Cmb = "<select id='Cmb".$sTabla."' name='Cmb".$sTabla."' class='form-control'><option value='0'>TODO (".$sTabla.")</option>"; 
         for($i=0; $i<count($Datos); $i++){
            $Cmb = $Cmb."<option class='col-sm-12'>".$Datos[$i]->$sNombre."</option>";
        }
        $Cmb = $Cmb."</select>";
        return $Cmb;
    }

    function CmbCualquierasMod($sID,$sNombre,$sTabla,$Text,$Value){
        try{ 
            $WebService="http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl";
            //parametros de la llamada
            $parametros = array();
            $parametros['sID'] = $sID;
            $parametros['sNombre'] = $sNombre;
            $parametros['sTabla'] = $sTabla;
            //Invocación al web service
            $WS = new SoapClient($WebService,$parametros);
            //recibimos la respuesta dentro de un objeto
            $result = $WS->CmbCualquiera($parametros);
            $xml = $result->CmbCualquieraResult->any;
            $obj = simplexml_load_string($xml);
            $Datos = $obj->NewDataSet->Table;
        } catch(SoapFault $e){
          var_dump($e);
        }
        $Cmb = "<select id='Cmb".$sTabla."' name='Cmb".$sTabla."' class='form-control col-sm-12'><option value='".$Value."'>".$Text."</option>"; 
         for($i=0; $i<count($Datos); $i++){
            $Cmb = $Cmb."<option class='col-sm-12' value='".$Datos[$i]->$sID."'>".$Datos[$i]->$sNombre."</option>";
        }
        $Cmb = $Cmb."</select>";
        return $Cmb;
    }

    function CmbCualquierasId($sID,$sNombre,$sTabla,$IdCmb,$Value){
        try{ 
            $WebService="http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl";
            //parametros de la llamada
            $parametros = array();
            $parametros['sID'] = $sID;
            $parametros['sNombre'] = $sNombre;
            $parametros['sTabla'] = $sTabla;
            //Invocación al web service
            $WS = new SoapClient($WebService,$parametros);
            //recibimos la respuesta dentro de un objeto
            $result = $WS->CmbCualquiera($parametros);
            $xml = $result->CmbCualquieraResult->any;
            $obj = simplexml_load_string($xml);
            $Datos = $obj->NewDataSet->Table;
        } catch(SoapFault $e){
          var_dump($e);
        }
        $Cmb = "<select id='Cmb".$IdCmb."' name='Cmb".$IdCmb."' class='form-control col-sm-12'><option value='".$Value."'>".$IdCmb."</option>"; 
         for($i=0; $i<count($Datos); $i++){
            $Cmb = $Cmb."<option class='col-sm-12' value='".$Datos[$i]->$sID."'>".$Datos[$i]->$sNombre."</option>";
        }
        $Cmb = $Cmb."</select>";
        return $Cmb;
    }
    function Cabecera($Titulo){
        echo '<head>';
        echo '<title id="title">'.$Titulo.'</title>';
        echo '<meta charset=utf-8>';
        echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> ';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">';
        echo '<meta name="description" content="" />';
        echo '<meta name="keywords" content="" />';
        echo '<meta name="author" content="TAYCO SA DE CV" />';
        echo '<link rel="stylesheet" type="text/css" href="../../css/normalize.css" />';
        echo '<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css"  />';
        echo '<link rel="stylesheet" type="text/css" href="../../css/PushMenu.css"/>';
        echo '<link rel="stylesheet" type="text/css" href="../../css/ThemeBlue.css"  />';
        echo '<link rel="stylesheet" type="text/css" href="../../css/barratareas.css"  />';
        echo '<link rel="stylesheet" type="text/css" href="../../css/CargaGif.css"  />';
        echo '<link rel="shortcut icon" href="favicon.ico">';
        echo '</head>';
    }

    function Script(){
        echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>';
        echo '<script type="text/javascript" src="../../js/jquery.min.js"></script>';
        echo '<script type="text/javascript" src="../../js/bootstrap.js"></script>';
        echo '<script type="text/javascript" src="../../js/validaciones.js"></script>';
        echo '<link rel="stylesheet" type="text/css" href="../../css/dataTables.bootstrap.min.css">';
        echo '<script type="text/javascript" src="../../js/jeditable.min.js" ></script>';
        echo '<script type="text/javascript" src="../../js/jquery.dataTables.min.js" ></script>';
        echo '<script type="text/javascript" src="../../js/dataTables.bootstrap.min.js" ></script>';
        echo '<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>';
        echo '<script type="text/javascript" src="../../js/dataTables.buttons.min.js"></script>';
        echo '<script type="text/javascript" src="../../js/buttons.flash.min.js"></script>';
        echo '<script type="text/javascript" src="../../js/jszip.min.js"></script>';
        echo '<script type="text/javascript" src="../../js/pdfmake.min.js"></script>';
        echo '<script type="text/javascript" src="../../js/vfs_fonts.js"></script>';
        echo '<script type="text/javascript" src="../../js/buttons.html5.min.js"></script>';
        echo '<script type="text/javascript" src="../../js/buttons.print.min.js"></script>';
        echo '<script type="text/javascript" src="../../js/modernizr.custom.js"></script>';
        echo '<script type="text/javascript" src="../../js/classie.js"></script>';
        //echo '<script type="text/javascript" src="../../js/canvasjs.min.js"></script>';
    }



    function GraphScript(){
        echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>';
        echo '<script type="text/javascript" src="jquery.min.js"></script>';
        echo '<script type="text/javascript" src="../../js/bootstrap.js"></script>';
        echo '<script type="text/javascript" src="../../js/canvasjs.min.js"></script>';
    }

    function Barra(){
        $ptr = '<nav id="navbar" class="navbar navbar-default "> 
            <div class="navbar-header"> 
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-9" aria-expanded="false"> 
                <span class="sr-only">Toggle navigation</span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> <span class="icon-bar"></span> 
                </button> 
                <a class="navbar-brand logoTayco" href="default"></a> 
            </div>  
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-9"> 
            <ul class="nav navbar-nav AntiFL"> 
                <li class="active"><a href="default">Reporteador TAYCOSA</a></li> 

                <!--<li><a href="#InxServicios">Servicios</a></li> 
                <li><a href="http://dwh.taycosa.mx/dwh/login.aspx" target="blank">DWH</a></li>
                --> 
            <li id="fat-menu1" class="dropdown"> 
            <a id="drop5" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Pantallas <span class="caret"></span> </a> 
                <ul class="dropdown-menu" aria-labelledby="drop5"> 
                    <li><a href="Gobernador.php" type="button" class="list-group-item">Usuarios</a></li>
                    <li><a href="Existencias.php" type="button" class="list-group-item">Existenacias</a></li>
                    <li><a href="Asistencias.php" type="button" class="list-group-item">Asistencias</a></li>
                    <li><a href="Gobernador.php" type="button" class="list-group-item">Usuarios</a></li>
                </ul> 
            </li> 
            <li id="fat-menu2" class="dropdown"> 
            <a id="drop5" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Bienvenido <?php echo $_SESSION["NombreUsuario"] ?><span class="caret"></span> </a>
    <ul class="dropdown-menu" aria-labelledby="drop5">
        <li><a href="salir.php">Cerrar sesión</a></li>
    </ul>
    </li>
    </ul>
    </div>
    </nav>'; return $ptr; } 
function Grid(){ $ptr = "$('#grid').DataTable( { fixedHeader: true, dom: 'lfBrtip', buttons: [ { extend: 'colvis', columns: ':not(:first-child)', collectionLayout: 'fixed two-column', text: 'Ocultar columnas' }, { extend: 'copy', message: 'Copiado!.', text: 'Copiar', exportOptions: { modifier: { page: 'all' } } }, { extend: 'pdf', text: 'PDF', customize: function ( doc ) { // Splice the image in after the header, but before the table doc.content.splice( 1, 0, { margin: [ 0, 0, 0, 12 ], alignment: 'center',
    <?php include('ImgHeader.php'); ?> } ); // Data URL generated by http://dataurl.net/#dataurlmaker }, filename: 'Impresion-grid', extension: '.pdf', exportOptions: { modifier: { page: 'all' } } }, { extend: 'excel', message: 'PDF creado desde el sistema\n en linea del tayco.', text: 'XLS', filename: 'Impresion-grid', extension: '.xlsx', exportOptions: { modifier: { page: 'all' } } }, { extend: 'print', message: 'PDF creado desde el sistema\n en linea taycosa.', text: 'Imprimir', exportOptions: { stripHtml: false, modifier: { page: 'all' } } }, ], 'pagingType': 'full_numbers', 'lengthMenu': [[-1, 10, 25, 50], ['Todo', 10, 25, 50]], 'language': { 'sProcessing': 'Procesando...', 'sLengthMenu': 'Mostrar _MENU_ registros', 'sZeroRecords': 'No se encontraron resultados', 'sEmptyTable': 'Ningún dato disponible en esta tabla', 'sInfo': 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros', 'sInfoEmpty': 'Mostrando registros del 0 al 0 de un total de 0 registros', 'sInfoFiltered': '(filtrado de un total de _MAX_ registros)', 'sInfoPostFix': '', 'sSearch': 'Buscar:', 'sUrl': '', 'sInfoThousands': ',', 'sLoadingRecords': 'Cargando...', 'oPaginate': { 'sFirst': 'Primero', 'sLast': 'Último', 'sNext': 'Siguiente', 'sPrevious': 'Anterior' }, 'oAria': { 'sSortAscending': '', 'sSortDescending': '' } }, 'scrollY': '50vh', 'scrollX': true, 'paging': true } );"; return $ptr; } 

function Txt($Nombre,$Placeholder,$Max){ $txt = '<input type="text" class="form-control" id="Txt'. $Nombre .'" name="Txt'. $Nombre . '" placeholder="'. $Placeholder .'" maxlength="'.$Max.'">'; return $txt; } 

function AjaxClic($Componente,$NombreUrl,$A,$Target){ $ptr = "$('".$Componente."').click(function() { $.ajax({ type: 'POST', async: true, url:'".$NombreUrl."', data: $('".$A."').serialize(), success: function(data) { $('".$Target."').html(data); // Mostrar la respuestas del script PHP. alert('listo listo'); }, error: function(error) { console.log(error); } }); });"; return $ptr; } 

function AjaxSubmit($Componente,$NombreUrl,$A,$Target){ $ptr = "$('".$Componente."').on('submit', function (e) { $.ajax({ type: 'POST', url:'".$NombreUrl."', data: $('".$A."').serialize(), success: function(data) { $('".$Target."').html(''); // Mostrar la respuestas del script PHP. alert('Hecho'); }, error: function(error) { console.log(error); } }); return false; });"; return $ptr; } 

function BorraTodo($Clic,$Target){ $ptr = "$('".$Clic."').click(function() { $('".$Target."').html(''); });"; return $ptr; } 

function PasaArreglo($Arreglo){ $ptr = "
    <script>
        alert('";

                for ($i = 0; $i < count($Arreglo); $i++) {
                    $ptr = $ptr.$Arreglo[$i].
                    "<br />";
                }
                $ptr = $ptr.
                "');

    </script>"; return $ptr; } 

function Inclusion($Include){ $ptr = 'include("'.$Include.'.php")'; return $ptr; } 

function Oculta($Componente,$Target,$Accion){ $ptr = "$('".$Componente."').click(function() {"; if ($Accion == "1"){ $ptr = $ptr.'$( "'.$Target.'" ).show();'; $ptr = $ptr.'$( ".respuesta" ).hide();'; }elseif ($Accion == "2"){ $ptr = $ptr.'$( "'.$Target.'" ).hide();'; $ptr = $ptr.'$( ".respuesta" ).show();'; } $ptr = $ptr."});"; return $ptr; } 

function GridPop(){ $ptr = '$("#gridpop").DataTable( { "pagingType": "full_numbers", "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]], "language": { "sProcessing": "Procesando...", "sLengthMenu": "Mostrar _MENU_ registros", "sZeroRecords": "No se encontraron resultados", "sEmptyTable": "Ningún dato disponible en esta tabla", "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros", "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros", "sInfoFiltered": "(filtrado de un total de _MAX_ registros)", "sInfoPostFix": "", "sSearch": "Buscar:", "sUrl": "", "sInfoThousands": ",", "sLoadingRecords": "Cargando...", "oPaginate": { "sFirst": "Primero", "sLast": "Último", "sNext": "Siguiente", "sPrevious": "Anterior" }, "oAria": { "sSortAscending": ": Activar para ordenar la columna de manera ascendente", "sSortDescending": ": Activar para ordenar la columna de manera descendente" }, } } );'; return $ptr; } 


function contador()
{
    $archivo = "contador.txt"; //el archivo que contiene en numero
    $f = fopen($archivo, "r"); //abrimos el archivo en modo de lectura
    if($f)
    {
        $contador = fread($f, filesize($archivo)); //leemos el archivo
        $contador = $contador + 1; //sumamos +1 al contador
        fclose($f);
    }
    $f = fopen($archivo, "w+");
    if($f)
    {
        fwrite($f, $contador);
        fclose($f);
    }
    return $contador;
}

function GrdRpt($sGridNomb,$sWsNomb,$aColumnas,$aTitulos){
    $Grd = "$(document).ready(function() {
         var table = $('".$sGridNomb."').DataTable({
            data:datos,
            columns: [";
            for ($i = 0; $i < count($aColumnas); $i++) {

                if($i <> (count($aColumnas)-1)){
                    $Grd = $Grd."{ data: '".$aColumnas[$i]."' },";
                }else{
                    $Grd = $Grd."{ data: '".$aColumnas[$i]."' }";
                }
            }
        $Grd = $Grd."],
            columnDefs: [";
            for ($j = 0; $j < count($aTitulos); $j++) {

                if($j <> (count($aTitulos)-1)){
                    $Grd = $Grd."{ 'title': '".$aTitulos[$j]."', 'targets': ".$j."},";
                }else{
                    $Grd = $Grd."{ 'title': '".$aTitulos[$j]."', 'targets': ".$j."}";
                }
            }					
        $Grd = $Grd."],
            dom: 'lfBrtip',    
            paging: false,
            searching: true,
            ordering: false,
            buttons: [
                {
                    extend: 'copy',
                    message: 'PDF created by PDFMake with Buttons for DataTables.',
                    text: 'Copiar',
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    customize: function ( doc ) {
                        // Splice the image in after the header, but before the table
                        doc.content.splice( 1, 0, {
                            margin: [ 0, 0, 0, 12 ],
                            alignment: 'center'
                        } );
                        // Data URL generated by http://dataurl.net/#dataurlmaker
                    },
                    filename: '".$sWsNomb."',
                    extension: '.pdf',       
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    header:'true',
                    filename: '".$sWsNomb."',
                    extension: '.csv',       
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'excel',
                    message: 'PDF creado desde el sistema en linea del tayco.',
                    text: 'XLS',
                    filename: '".$sWsNomb."',
                    extension: '.xlsx', 
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    },
                    customize: function( xlsx ) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row:first c', sheet).attr( 's', '42' );
                    }
                },
                {
                    extend: 'print',
                    message: 'PDF creado desde el sistema en linea del tayco.',
                    text: 'Imprimir',
                    exportOptions: {
                        stripHtml: false,
                        modifier: {
                            page: 'all'
                        }
                    }
                },
            ],
            'pagingType': 'full_numbers',
            'lengthMenu': [[-1], ['Todo']],
            'language': {
                'sProcessing':    'Procesando...',
                'sLengthMenu':    'Mostrar _MENU_ registros',
                'sZeroRecords':   'No se encontraron resultados',
                'sEmptyTable':    'Ningún dato disponible en esta tabla',
                'sInfo':          'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                'sInfoEmpty':     'Mostrando registros del 0 al 0 de un total de 0 registros',
                'sInfoFiltered':  '(filtrado de un total de _MAX_ registros)',
                'sInfoPostFix':   '',
                'sSearch':        'Buscar:',
                'sUrl':           '',
                'sInfoThousands':  ',',
                'sLoadingRecords': 'Cargando...',
                'oPaginate': {
                    'sFirst':    'Primero',
                    'sLast':    'Último',
                    'sNext':    'Siguiente',
                    'sPrevious': 'Anterior'
                },
                'oAria': {
                    'sSortAscending':  ': Activar para ordenar la columna de manera ascendente',
                    'sSortDescending': ': Activar para ordenar la columna de manera descendente'
                }
            },
            'scrollY': '50vh',
            'scrollX': true,
            'paging': false,
            responsive: true,
        } );
    } );";

    return $Grd;
}

function GrdRptShort($sGridNomb,$sWsNomb,$aColumnas,$aTitulos){
    $Grd = "$(document).ready(function() {
         var table = $('".$sGridNomb."').DataTable({
            data:datos,
            columns: [";
            for ($i = 0; $i < count($aColumnas); $i++) {

                if($i <> (count($aColumnas)-1)){
                    $Grd = $Grd."{ data: '".$aColumnas[$i]."' },";
                }else{
                    $Grd = $Grd."{ data: '".$aColumnas[$i]."' }";
                }
            }
        $Grd = $Grd."],
            columnDefs: [";
            for ($j = 0; $j < count($aTitulos); $j++) {

                if($j <> (count($aTitulos)-1)){
                    $Grd = $Grd."{ 'title': '".$aTitulos[$j]."', 'targets': ".$j."},";
                }else{
                    $Grd = $Grd."{ 'title': '".$aTitulos[$j]."', 'targets': ".$j."}";
                }
            }					
        $Grd = $Grd."],
            dom: 'lfBrtip',    
            paging: false,
            searching: false,
            ordering: false,
            buttons: [
                {
                    extend: 'copy',
                    message: 'PDF created by PDFMake with Buttons for DataTables.',
                    text: 'Copiar',
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    customize: function ( doc ) {
                        // Splice the image in after the header, but before the table
                        doc.content.splice( 1, 0, {
                            margin: [ 0, 0, 0, 12 ],
                            alignment: 'center'
                        } );
                        // Data URL generated by http://dataurl.net/#dataurlmaker
                    },
                    filename: '".$sWsNomb."',
                    extension: '.pdf',       
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    header:'true',
                    filename: '".$sWsNomb."',
                    extension: '.csv',       
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'excel',
                    message: 'PDF creado desde el sistema en linea del tayco.',
                    text: 'XLS',
                    filename: '".$sWsNomb."',
                    extension: '.xlsx', 
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    },
                    customize: function( xlsx ) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row:first c', sheet).attr( 's', '42' );
                    }
                },
                {
                    extend: 'print',
                    message: 'PDF creado desde el sistema en linea del tayco.',
                    text: 'Imprimir',
                    exportOptions: {
                        stripHtml: false,
                        modifier: {
                            page: 'all'
                        }
                    }
                },
            ],
            'pagingType': 'full_numbers',
            'lengthMenu': [[-1], ['Todo']],
            'language': {
                'sProcessing':    'Procesando...',
                'sLengthMenu':    'Mostrar _MENU_ registros',
                'sZeroRecords':   'No se encontraron resultados',
                'sEmptyTable':    'Ningún dato disponible en esta tabla',
                'sInfo':          'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                'sInfoEmpty':     'Mostrando registros del 0 al 0 de un total de 0 registros',
                'sInfoFiltered':  '(filtrado de un total de _MAX_ registros)',
                'sInfoPostFix':   '',
                'sSearch':        'Buscar:',
                'sUrl':           '',
                'sInfoThousands':  ',',
                'sLoadingRecords': 'Cargando...',
                'oPaginate': {
                    'sFirst':    'Primero',
                    'sLast':    'Último',
                    'sNext':    'Siguiente',
                    'sPrevious': 'Anterior'
                },
                'oAria': {
                    'sSortAscending':  ': Activar para ordenar la columna de manera ascendente',
                    'sSortDescending': ': Activar para ordenar la columna de manera descendente'
                }
            },
            'paging': false,
            responsive: true,
        } );
    } );";

    return $Grd;
}

    function GrdPopD($sNombre){
        $Grd = "$(document).ready(function() {
            var table = $('.gridpop').DataTable({
                dom: 'lfBrtip',    
                paging: false,
                searching: true,
                ordering: false,
                buttons: [
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        customize: function ( doc ) {
                            // Splice the image in after the header, but before the table
                            doc.content.splice( 1, 0, {
                                margin: [ 0, 0, 0, 12 ],
                                alignment: 'center'
                            } );
                            // Data URL generated by http://dataurl.net/#dataurlmaker
                        },
                        filename: '".$sNombre."',
                        extension: '.pdf',       
                        exportOptions: {
                            columns: ':visible',
                            modifier: {
                                page: 'all'
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        message: 'PDF creado desde el sistema en linea del tayco.',
                        text: 'XLS',
                        filename: '".$sNombre."',
                        extension: '.xlsx', 
                        exportOptions: {
                            columns: ':visible',
                            modifier: {
                                page: 'all'
                            }
                        },
                        customize: function( xlsx ) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row:first c', sheet).attr( 's', '42' );
                        }
                    },
                    {
                        extend: 'print',
                        message: 'PDF creado desde el sistema en linea del tayco.',
                        text: 'Imprimir',
                        exportOptions: {
                            stripHtml: false,
                            modifier: {
                                page: 'all'
                            }
                        }
                    },
                ],
                'pagingType': 'full_numbers',
                'lengthMenu': [[-1], ['Todo']],
                'language': {
                    'sProcessing':    'Procesando...',
                    'sLengthMenu':    'Mostrar _MENU_ registros',
                    'sZeroRecords':   'No se encontraron resultados',
                    'sEmptyTable':    'Ningún dato disponible en esta tabla',
                    'sInfo':          'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                    'sInfoEmpty':     'Mostrando registros del 0 al 0 de un total de 0 registros',
                    'sInfoFiltered':  '(filtrado de un total de _MAX_ registros)',
                    'sInfoPostFix':   '',
                    'sSearch':        'Buscar:',
                    'sUrl':           '',
                    'sInfoThousands':  ',',
                    'sLoadingRecords': 'Cargando...',
                    'oPaginate': {
                        'sFirst':    'Primero',
                        'sLast':    'Último',
                        'sNext':    'Siguiente',
                        'sPrevious': 'Anterior'
                    },
                    'oAria': {
                        'sSortAscending':  ': Activar para ordenar la columna de manera ascendente',
                        'sSortDescending': ': Activar para ordenar la columna de manera descendente'
                    }
                },
                'scrollY': '50vh',
                'scrollX': true,
                'paging': false,
                responsive: true,
            } );
        } );";

        return $Grd;
    }

    function MdlSearch($iId,$sTitulo){
        $Grd = "<div class='modal' id='".$iId."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
              <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    <h4 class='modal-title' id='myModalLabel'>".$sTitulo."</h4>
                  </div>
                  <div id='Div".$iId."' class='modal-body'>
                  </div>
                </div>
              </div>
            </div>";
        return $Grd;
    }

    function MdlSearchLG($iId,$sTitulo){
          echo "<div class='modal bs-example-modal-lg' id='".$iId."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
              echo "<div class='modal-dialog modal-lg' role='document'>";
                echo "<div class='modal-content'>";
                  echo "<div class='modal-header'>";
                    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
                    echo "<h4 class='modal-title' id='myModalLabel'>".$sTitulo."</h4>";
                  echo "</div>";
                  echo "<div id='Div".$iId."' class='modal-body'>";
                  echo "</div>";
                echo "</div>";
              echo "</div>";
          echo "</div>";
    }

    function CargaGif(){
        echo "<div id='CargaGif' class='lds-css ng-scope'><div style='width:100%;height:100%' class='lds-double-ring'><div></div><div></div></div></div>";
    }

    function Webservice(){
        echo "$WebService='http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl';";
    }

?>