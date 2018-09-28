<?php include("../../funciones.php");

$Columnas = array("Nombre","Saldo");
$titulos = array("NOMBRE CLIENTE","ANTICIPO CLIENTE");

try{ 
    
    if ($_POST){
        
        $Ejercicio =  $_POST["TxtEjercicio"]; 
        $Mes =  $_POST["TxtMes"]; 
        
        //parametros de la llamada
        $parametros = array();
        $parametros['Empresa'] = 'TAYCOSA';
        $parametros['Mes'] = $Mes;
        $parametros['Ejercicio'] = $Ejercicio;
        //ini_set("soap.wsdl_cache_enabled", "0");
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        //$result = $WS->Edoresultados($parametros);
        //$xml = $result->EdoresultadosResult->any;
        $result = $WS->edorelacionanticipos($parametros);
        $xml = $result->edorelacionanticiposResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact nowrap' cellspacing='0' width='100%' style='white-space: nowrap;'><thead><tr>"; 
                echo "<th>".$titulos[0]."</th>";
                echo "<th>".$titulos[1]."</th>";
            echo "</tr></thead><tfoot><tr>";
                echo "<th>TOTAL</th>";
                echo "<th>".$titulos[1]."</th>";
            echo "</tr></tfoot><tbody>";

         for($i=0; $i<count($Datos); $i++){
             echo "<tr>";
             echo "<td>".$Datos[$i]->$Columnas[0]."</td>";
             echo "<td class='text-right'>".$Datos[$i]->$Columnas[1]."</td>";
             echo "</tr>";
         } 
      echo "</tbody></table></div>";

?>

    <script type="text/javascript"> 
        
        <?php echo GrdRpt('Edo-RelAnt_'.$Mes."-".$Ejercicio); ?>

    </script>