<?php include("../../funciones.php");
try{
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        $empresa =  $_POST["CmbEmpresa"]; 
        $sucursal =  $_POST["CmbSUCURSALES"]; 
        $parametros = array();
        $parametros['sID'] = 'EAGLE';
        $parametros['sNombre'] = $sucursal;
        $parametros['sTabla'] = 'VTAS_FILTRO';
        //Invocación al web service
        $WS = new SoapClient($WebService,$parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->CmbCualquiera($parametros);
        $xml = $result->CmbCualquieraResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
} catch(SoapFault $e){
  var_dump($e);
}
$Cmb = "<label for='inputtext3'>Vendedores:</label>";
$Cmb = $Cmb."<select id='CmbVENDEDORES' name='CmbVENDEDORES' class='form-control'><option value='0'>TODO (VENDEDORES)</option>"; 
 for($i=0; $i<count($Datos); $i++){
    $Cmb = $Cmb."<option class='col-sm-12' value='".$Datos[$i]->id_vendedor."'>".$Datos[$i]->nombre."</option>";
}
$Cmb = $Cmb."</select>";
echo $Cmb;
?>