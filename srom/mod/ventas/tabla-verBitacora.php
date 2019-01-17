<?php include("../../funciones.php");
try{
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        $empresa =  $_POST["CmbEmpresa"]; 
        $vendedor =  $_POST["CmbVENDEDORES"]; 
        $fini = $_POST["Fini"]; 
        $ffin = $_POST["Ffin"];         
        
        //parametros de la llamada
        $parametros = array();
        $parametros['sEmpresa'] = 'EAGLE';
        $parametros['iVendedor'] = $vendedor;
        $parametros['dFini'] = $fini;
        $parametros['sFfin'] = $ffin;

        $WS = new SoapClient($WebService, $parametros);
        $result = $WS->Maps($parametros);
        $xml = $result->MapsResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
} 
catch(SoapFault $e){
 var_dump($e);
}

  $arreglo = [];
	for($i=0; $i<count($Datos); $i++){
		$arreglo[$i]=$Datos[$i];
	}
    $json = json_encode($arreglo);
     echo ($json);

?>

