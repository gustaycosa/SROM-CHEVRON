<?php include("../../funciones.php");

ini_set("soap.wsdl_cache_enabled", "0");

$Columnas = array("ID_EMPRESA","ID_EMPLEADO","SERIE","FOLIO","FUM","USUARIO");//COLUMNAS GRID
//$De = date('Y-m-d');
//$A = date('Y-m-d');

try{ 
    
    if ($_POST){
        
        $UserID =  $_POST["CmbNOMBRESUSUARIOWEB"]; 
        $Serie =  $_POST["CmbSerie"]; 
        $De = $_POST["txtde"];
        $A =  $_POST["txta"]; 

        
        //parametros de la llamada
        $parametros = array();
        $parametros['sId_Empresa'] = $Empresa;
        $parametros['sId_Empleado'] = $UserID;
        $parametros['sSerie'] = $Serie;
        $parametros['iRango1'] = $De;
        $parametros['iRango2'] = $A;
        $parametros['sUsuario'] = 'GHDEZ';
        
        //ini_set("soap.wsdl_cache_enabled", "0");
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->AltaFolioChecklist($parametros);
        $xml = $result->AltaFolioChecklistResult->any;

        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

echo "<div class='table-responsive'>
	<table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' width='100%' style='white-space: nowrap;'>
	 	<thead></thead><tbody></tbody></div>";
    
	$arreglo = [];
	for($i=0; $i<count($Datos); $i++){
		$arreglo[$i]=$Datos[$i];
	}

?>

     <script type="text/javascript"> 
        var datos = <?php echo json_encode($arreglo);?> ;
        
		<?php
        /*
			$sGridNomb = '#grid';
			$sWsNomb = 'vtas_netas';
			$aColumnas = array("nombre","VtasNetas","AbonosFactMes","TotalCobradoMes");
			$aTitulos = array("nombre","Ventas netas","Abonos Mes","Total Mes");
			echo GrdRptShort($sGridNomb,$sWsNomb,$aColumnas,$aTitulos);
        */
        /*
        	$sGridNomb = '#grid';
			$sWsNomb = 'vtas_netas';
			$aColumnas = array("nombre","VtasNetas","AbonosFactMes","TotalCobradoMes");
			$aTitulos = array("nombre","Ventas netas","Abonos Mes","Total Mes");
        
        */
		?>

   $(document).ready(function() {
         var table = $('#grid').DataTable({
            data:datos,
            columns: [
                { data: 'ID_EMPLEADO' },
                { data: 'SERIE' },
                { data: 'FOLIO' },
                { data: 'FUM' }
            ],
            columnDefs: [
                { 'title': 'EMPLEADO',className: "text-left", 'targets': 0},
                { 'title': 'SERIE', className: "text-left", 'targets': 1},
                { 'title': 'FOLIO', className: "text-left", 'targets': 2},
                { 'title': 'FECHA', className: "text-left", 'targets': 3}
            ],
            'createdRow': function ( row, data, index ) {
/*                $(row).attr({ id:data.id_Vendedor});
                $(row).addClass('vendedor');*/
            },  
             fixedHeader: true,          
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
            "language": {
                "sProcessing":    "Procesando...",
                "sLengthMenu":    "Mostrar _MENU_ registros",
                "sZeroRecords":   "No se encontraron resultados",
                "sEmptyTable":    "Ningún dato disponible en esta tabla",
                "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":   "",
                "sSearch":        "Buscar:",
                "sUrl":           "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
            }
 
        } );
    } );
    </script>
            
