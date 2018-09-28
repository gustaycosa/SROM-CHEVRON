<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        $Id_Usuario =  $_POST["Txtidsolicita"];
        $Id_Tarea =  $_POST["TxtTarea"];

        //echo "<script>alert('".$tel."');</script>";
        
        //parametros de la llamada
        $parametros = array();
        $parametros['id_usuario'] = $Id_Usuario;
        $parametros['Id_tarea'] = $Id_Tarea;

        //echo "<script>alert('".$parametros['sTelefono']."');</script>";
        $WS = new SoapClient($WebService);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->TerComentariosTareas($parametros);
        $xml = $result->TerComentariosTareasResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{

    }
} catch(SoapFault $e){
  var_dump($e);
}


?>