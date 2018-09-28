<?php include("../../funciones.php");

$Columnas = array("Id_ReporteContable","ReporteContable","ConceptoCtb","FEB_2017","MAR_2017","ABR_2017","MAY_2017","JUN_2017");
$Titulos = array("CONCEPTOS","%","PERCEPCIONES","IMSS APORT PATR.","RCV","CUOTAS INFON 5%","ISN 3%","19% S/ISN","TOTAL","3%","GRAN TOTAL","AJUSTE");

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
        $result = $WS->edonomina($parametros);
        $xml = $result->edonominaResult->any;
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
                for($i=0; $i<count($Titulos); $i++){
                    echo "<th>".$Titulos[$i]."</th>";
                }
            echo "</tr></thead><tfoot><tr>";
                for($i=0; $i<count($Titulos); $i++){
                    echo "<th>".$Titulos[$i]."</th>";
                }
            echo "</tr></tfoot><tbody>";

     for($i=0; $i<count($Datos); $i++){
        $bandera = $Datos[$i]->$Columnas[0];
        if($i==0){

            
        }else{
            echo "<tr>";
            echo "<td>".$Datos[$i]->$Columnas[2]."</td><td class='text-right'>".$Datos[$i]->$Columnas[7]."</td>";
            $Valor = $Datos[$i]->$Columnas[7] + $Datos[$i]->$Columnas[6];
            $Suma = $Suma + $Datos[$i]->$Columnas[6];
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            
            echo "</tr>";
            $ConceptoDivision = $bandera;
        }

        //$ConceptoDivision = $Datos[$i]->$Columnas[0];
        
     } 

      echo "</tbody></table></div>";
        //echo number_format($Suma, 2, ',', ' ');

?>

     <script type="text/javascript"> 
        
        <?php echo GrdRpt('Edo-RelNom_'.$Mes."-".$Ejercicio); ?>

    </script>