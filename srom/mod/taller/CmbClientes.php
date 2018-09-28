<?php include("../../funciones.php");

ini_set("soap.wsdl_cache_enabled", "0");
$Columnas = array("ID_CLIENTE","NOMBRE");
try{ 
    $CveBusqueda =  $_POST["TxtCliente"]; 
    //parametros de la llamada
    $parametros = array();
    $parametros['CveBusqueda'] = $CveBusqueda;
    //ini_set("soap.wsdl_cache_enabled", "0");
    //Invocación al web service
    $WS = new SoapClient($WebService, $parametros);
    //recibimos la respuesta dentro de un objeto
    $result = $WS->MuestraClientes($parametros);
    $xml = $result->MuestraClientesResult->any;
    $obj = simplexml_load_string($xml);
    $Datos = $obj->NewDataSet->Table;
    
} catch(SoapFault $e){
  var_dump($e);
}


	for($i=0; $i<count($Datos); $i++){
         echo "<li><a id='".$Datos[$i]->$Columnas[0]."' href='#'>".$Datos[$i]->$Columnas[1]."</a></li>";
	}

?>

 