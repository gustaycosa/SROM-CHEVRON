<?php include("../../funciones.php");
try{ 
    
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        $Asunto =  $_POST["TxtAsunto"];
        $Descripcion =  $_POST["TxtDescripcion"];
        $FechaSol =  $_POST["txtFecha"];
        $Id_Solicita =  $_POST["TxtIdSolicita"];
        $Id_Responsable =  $_POST["CmbTodos"];

        
        //parametros de la llamada
        $parametros = array();
        $parametros['Asunto'] = $Asunto;
        $parametros['Descripcion'] = $Descripcion;
        $parametros['FechaSol'] = $FechaSol;
        $parametros['Id_Solicita'] = $Id_Solicita;
        $parametros['Id_Responsable'] = $Id_Responsable;

        $WS = new SoapClient($WebService, $parametros);
        $result = $WS->RegistrarTarea($parametros);
        $xml = $result->RegistrarTareaResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{

    }
} catch(SoapFault $e){
  var_dump($e);
}


?>