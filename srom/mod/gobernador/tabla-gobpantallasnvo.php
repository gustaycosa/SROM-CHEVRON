<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        
        $Nombre =  $_POST["txtnombre"]; 
        $Descripcion =  $_POST["txtdescrip"]; 
		$Grupo = $_POST["Cmbgrupos"]; 
        $Tipo = $_POST["cmbtipo"];
        $Modulo = $_POST["Cmbmodulos"];
        
        
        //parametros de la llamada
        $parametros = array();
        $parametros['sNombre'] = $Nombre;
        $parametros['sDescripcion'] = $Descripcion;
        $parametros['sGrupo'] = $Grupo;
        $parametros['sTipo'] = $Tipo; 
        $parametros['iModulo'] = $Modulo;

        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->AltaPantallas($parametros);
        $xml = $result->AltaPantallasResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{

    }

} catch(SoapFault $e){
  var_dump($e);
}

?>