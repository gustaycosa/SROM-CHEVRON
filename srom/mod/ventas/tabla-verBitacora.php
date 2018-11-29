<?php include("../../funciones.php");

try{  
        ini_set("soap.wsdl_cache_enabled", "0");     
        $WS = new SoapClient($WebService);
        $result = $WS->Maps();       
        $xml = $result->MapsResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
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