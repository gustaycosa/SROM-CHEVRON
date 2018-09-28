<?php include("../../funciones.php");

$Columnas = array("id","concepto","sucursal","saldo","ref");
$titulos = array("id","concepto","sucursal","saldo","ref");

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
        $result = $WS->edorelacionalmacen($parametros);
        $xml = $result->edorelacionalmacenResult->any;
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
                echo "<th>".$titulos[2]."</th>";
                echo "<th>".$titulos[3]."</th>";
                echo "<th>".$titulos[4]."</th>";
            echo "</tr></thead><tfoot><tr>";
                echo "<th>".$titulos[0]."</th>";
                echo "<th>".$titulos[1]."</th>";
                echo "<th>".$titulos[2]."</th>";
                echo "<th>".$titulos[3]."</th>";
                echo "<th>".$titulos[4]."</th>";
            echo "</tr></tfoot><tbody>";

         for($i=0; $i<count($Datos); $i++){
             echo "<tr>";
                 echo "<td>".$Datos[$i]->$Columnas[0]."</td>";
                 echo "<td>".$Datos[$i]->$Columnas[1]."</td>";
                 echo "<td>".$Datos[$i]->$Columnas[2]."</td>";
                 echo "<td>".$Datos[$i]->$Columnas[3]."</td>";
                 echo "<td>".$Datos[$i]->$Columnas[4]."</td>";
             echo "</tr>";
         } 
      echo "</tbody></table></div>";

?>

    <script type="text/javascript"> 
        
        <?php echo GrdRpt('Edo-MaqCon_'.$Mes."-".$Ejercicio); ?>

    </script>