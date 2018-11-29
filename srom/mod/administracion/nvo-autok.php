<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        $iId = $_POST["TxtRow"];
        $sOrden = $_POST["TxtMov"];
        $sTipo = $_POST["Cmbstipo"];
        //$sResp = $_POST["Txtidsolicita"];

        
        //$WebService="http://192.168.1.1/WEB_SERVICES/DataLogs.asmx?wsdl";
        //parametros de la llamada
        $parametros = array();
        $parametros['Id'] = $iId;
        $parametros['Orden'] = $sOrden;
        $parametros['Respuesta'] = 'SI';
        $parametros['sTipo'] = $sTipo;
        echo json_encode($parametros);
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->AutOrden($parametros);

        //$Autoriza = $result->AutOrdenResult->string;
        $valido = $Autoriza[1] ;
        $Cadena = $Autoriza[0] ;
    }
    else{

    }
} catch(SoapFault $e){
  var_dump($e);
}

?>