<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        
        $Ejercicio =  $_POST["TxtEjercicio"]; 
        $Mes =  $_POST["TxtMes"]; 
		$Moneda = $_POST["CmbMoneda"]; 
        
        
        //parametros de la llamada
        $parametros = array();
        $parametros['Id_Empresa'] = 'TAYCOSA';
        $parametros['Mes'] = $Mes;
        $parametros['Ejercicio'] = $Ejercicio;
		$parametros['Moneda'] = $Moneda;
        //ini_set("soap.wsdl_cache_enabled", "0");
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->VtasNetas($parametros);
        $xml = $result->VtasNetasResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

	$arreglo = [];
	for($i=0; $i<count($Datos); $i++){
		$arreglo[$i]=$Datos[$i];
	}


echo "
<!DOCTYPE html>
<html>
<head>
<title>jQuery Pie Chart</title> 
<script type='text/javascript' src='https://canvasjs.com/assets/script/jquery-1.11.1.min.js'></script> 
<script type='text/javascript' src='https://canvasjs.com/assets/script/jquery.canvasjs.min.js'></script> 
<script type='text/javascript'> 
window.onload = function() { 
	$('#chartContainer').CanvasJSChart({ 
		title: { 
			text: 'Worldwide Smartphone sales by brand - 2012',
			fontSize: 24
		}, 
		axisY: { 
			title: 'Products in %' 
		}, 
		legend :{ 
			verticalAlign: 'center', 
			horizontalAlign: 'right' 
		}, 
		data: [ 
		{ 
			type: 'pie', 
			showInLegend: true, 
			toolTipContent: '{label} <br/> {y} %', 
			indexLabel: '{y} %', 
			dataPoints: [ 
				{ label: 'Samsung',  y: 30.3, legendText: 'Samsung'}, 
				{ label: 'Apple',    y: 19.1, legendText: 'Apple'  }, 
				{ label: 'Huawei',   y: 4.0,  legendText: 'Huawei' }, 
				{ label: 'LG',       y: 3.8,  legendText: 'LG Electronics'}, 
				{ label: 'Lenovo',   y: 3.2,  legendText: 'Lenovo' }, 
				{ label: 'Others',   y: 39.6, legendText: 'Others' } 
			] 
		} 
		] 
	}); 
} 
</script> 
</head> 
<body> 
<div id='chartContainer' style='width: 100%; height: 300px'></div> 
</body> 
</html> 
";
?>