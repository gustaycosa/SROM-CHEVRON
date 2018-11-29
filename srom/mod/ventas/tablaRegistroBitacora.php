<?php include("../../funciones.php");

try{ 
    
    if ($_POST){    
        ini_set("soap.wsdl_cache_enabled", "0");
        
 

        $accion = $_POST["opt"];
        $parametros = array();
        $parametros['Accion'] = $accion ;
        $parametros['Id']=0;
        $parametros['IdVendedor']=$_POST["IdUsuario"];
        $parametros['Comentarios']=$_POST["comentarios"] ;
        $parametros['observaciones']="";
        $parametros['Id_Usuario'] = $_POST["IdUsuario"];
        $parametros['LatitudCheckin']=$_POST["lat"];
        $parametros['LongitudCheckin']=$_POST["lon"];
        $parametros['LatitudCheckout']=$_POST["lat2"];;
        $parametros['LongitudCheckout']=$_POST["lon2"];
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->Reg_Bitacora_Vendedores($parametros);
        $xml = $result->Reg_Bitacora_VendedoresResult; 
        $xml = $result->Reg_Bitacora_VendedoresResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
      //echo  json_encode($obj);
    }
  else{}
} 
catch(SoapFault $e){
 var_dump($e);
}
	$arreglo = [];
	for($i=0; $i<count($Datos); $i++){
		$arreglo[$i]=$Datos[$i];
	}
    $json = json_encode($Datos[0]);
     echo ($json);
    

?>

