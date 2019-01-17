<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1" runat="server">
    <!--- basic page needs ================================================== -->
    <meta charset="utf-8">
    <title>EAGLE IMPORTACION</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- mobile specific metas ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS ================================================== -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- favicons ================================================== -->
<!--    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">-->

</head>

<?php
$iId = $_GET['p1'];
$sOrden = $_GET['p2'];
$sResp = $_GET['p3'];

$WebService ="http://dwh.eimportacion.com.mx/WEB_SERVICES/DataLogs.asmx?wsdl";
//$WebService="http://192.168.1.1/WEB_SERVICES/DataLogs.asmx?wsdl";
//parametros de la llamada
$parametros = array();
$parametros['Id'] = $iId;
$parametros['Orden'] = $sOrden;
$parametros['Respuesta'] = $sResp;
$parametros['sTipo'] = 0;         
//Invocación al web service
$WS = new SoapClient($WebService, $parametros);
//recibimos la respuesta dentro de un objeto
$result = $WS->AutOrden($parametros);

$Autoriza = $result->AutOrdenResult->string;
  
$valido = $Autoriza[1] ;
$Cadena = $Autoriza[0] ;

/*if ($valido==0) {
echo '';
}
else
{
echo '<img alt="" src="img/NoAut.png" height="80" width="80" />';
}*/
?>
<body class="<?php if ($valido==1) {echo 'list-group-item-success';} else {echo 'list-group-item-danger';}  ?>">
    <div class="container-fluid"><br><br><br><br><br><br>
        <div class="col-sm-6 col-sm-offset-3 text-center">
            <h1><?php echo ($Cadena.' '); if ($valido==1) {echo ' :)';} else {echo ' :(';} ?></h1>
            <a class="btn btn-primary btn-lg btn-<?php if ($valido==1) {echo 'success';} else {echo 'danger';}  ?>" href="https://www.eimportacion.com.mx">Ok entendido</a>
        </div>
    </div>
</body>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</html>