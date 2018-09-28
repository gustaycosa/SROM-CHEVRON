<?php include("../../funciones.php");
require_once('lib/nusoap.php');
include("../../funciones.php"); 
ini_set("soap.wsdl_cache_enabled", "0");

$Columnas = array("Nombre","Saldo");
$titulos = array("NOMBRE CLIENTE","SALDO CLIENTE");

$ConceptoDivision = '';
$Empresa = $_SESSION['Empresa'];
$Suma = 0;
try{ 
    
    if ($_POST){
        
        $Ejercicio =  $_POST["TxtEjercicio"]; 
        $Mes =  $_POST["TxtMes"]; 
        
        $parametros = array();
        $parametros['Empresa'] = 'TAYCOSA';
        $parametros['Mes'] = $Mes;
        $parametros['Ejercicio'] = $Ejercicio;
        $WS = new SoapClient($WebService, $parametros);
        $result = $WS->edorelacionacreedores($parametros);
        $xml = $result->edorelacionacreedoresResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

echo "<table id='gridcli' class='gridpop table table-striped table-bordered table-condensed table-hover display compact'>
    <thead><tr>"; 
    echo "<th>".$titulos[0]."</th>";
    echo "<th>".$titulos[1]."</th>";
    echo "</tr></thead><tfoot><tr>";
    echo "<th>".$titulos[0]."</th>";
    echo "<th>".$titulos[1]."</th>";
 echo "</tr></tfoot><tbody>";

 for($i=0; $i<count($Datos); $i++){
    echo "<tr>";
    for($j=0; $j<count($Columnas); $j++){
        echo "<td>".$Datos[$i]->$Columnas[$j]."</td>";
    } 
    echo "</tr>";
 } 
    echo "</tbody></table>";

?>
<script type="text/javascript"> 

    <?php echo GrdPopD('AnaCli'); ?>

</script>
            