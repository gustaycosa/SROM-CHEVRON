<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        $aRows = $_POST["info"];

        
        //$WebService="http://192.168.1.1/WEB_SERVICES/DataLogs.asmx?wsdl";
        //parametros de la llamada
        $parametros = array();
        $parametros[] = $aRows;
        var_dump($parametros);
        
        //echo '<script>alert('.$parametros.');</script>';
        //Invocación al web service
/*        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->AutOrden($parametros);

        $Autoriza = $result->AutOrdenResult->string;

        $valido = $Autoriza[1] ;
        $Cadena = $Autoriza[0] ;*/
    }
    else{

    }
} catch(SoapFault $e){
  var_dump($e);
}

?>