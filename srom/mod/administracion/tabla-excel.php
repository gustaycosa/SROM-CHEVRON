<?php include("../../funciones.php");

require_once('lib/nusoap.php');

ini_set("soap.wsdl_cache_enabled", "0");

//$De = date('Y-m-d');
//$A = date('Y-m-d');

$ConceptoDivision = '';
$Empresa = $_SESSION['Empresa'];
$Suma = 0;
try{ 
    
    if ($_POST){
        
        $gasto =  $_POST["TxtGasto"]; 
        $cta =  $_POST["TxtCta"]; 
        $emp =  $_POST["TxtEmp"]; 
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}


$cadena =" ";

     for($i=0; $i<$cta; $i++){
        if($i<10){
            $cadena = $gasto."-0".$i;
        }else{
            $cadena = $gasto."-".$i;
        }
         
        for($j=0; $j<$emp; $j++){
            if($j<10){
                $cadena = $cadena."-0".$j."-00-00\n <br>";
            }
            else{
                $cadena = $cadena."-".$j."-00-00\n <br>";
            }
            
        }
        //$ConceptoDivision = $Datos[$i]->$Columnas[0];
         echo $cadena;
     } 
        //echo number_format($Suma, 2, ',', ' ');
?>