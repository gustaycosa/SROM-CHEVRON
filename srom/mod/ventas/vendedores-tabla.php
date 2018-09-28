<?php

ini_set("soap.wsdl_cache_enabled", "0");

	$Columnas = array("id", "usuario","Tipo","nombre","Perfil","grupo","telefono");//COLUMNAS GRID

try{ 
    
    $ID='0';
    $empresa='TAYCOSA';
    $parametros = array();
    $parametros['sId_Empresa']=$empresa;
    $parametros['iId']=$ID;

    //Invocación al web service
    $WS = new SoapClient($WebService,$parametros);
    $result = $WS->UsuariosSelect($parametros);
    $xml = $result->UsuariosSelectResult->any;
    $obj = simplexml_load_string($xml);
    $Datos = $obj->NewDataSet->Table;
//echo $xml;
    
} catch(SoapFault $e){
  var_dump($e);
}

echo "<div class='table-responsive col-sm-12'>
	<table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact'>
	 	<thead><tr>"; 
		
			for($i=0; $i<count($Columnas); $i++){
		  		echo "<th>".$Columnas[$i]."</th>";
			}

	  	echo "</tr></thead>
	 	<tfoot><tr>";

			for($i=0; $i<count($Columnas); $i++){
		  		echo "<th>".$Columnas[$i]."</th>";
			}
	  	
 echo "</tr></tfoot><tbody>";

 for($i=0; $i<count($Datos); $i++){
    echo "<tr class='identificador' data-id='".$Datos[$i]->$Columnas[0]."'>";
    for($j=0; $j<count($Columnas); $j++){
        echo "<td class='text-center'>".$Datos[$i]->$Columnas[$j]."</td>";
    } 
    echo "</tr>";
 } 
    
  echo "</tbody></table></div>";

?>

