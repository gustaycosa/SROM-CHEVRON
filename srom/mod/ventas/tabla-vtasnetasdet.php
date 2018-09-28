<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        
        $Ejercicio =  $_POST["TxtEjercicio"]; 
        $Mes =  $_POST["TxtMes"]; 
		$Moneda = $_POST["CmbMoneda"]; 
		$CveVendedor = $_POST["TxtClave"]; 
        
        
        //parametros de la llamada
        $parametros = array();
        $parametros['Id_Empresa'] = 'TAYCOSA';
        $parametros['Mes'] = $Mes;
        $parametros['Ejercicio'] = $Ejercicio;
		$parametros['Moneda'] = $Moneda;
		$parametros['CveVendedor'] = $CveVendedor;
		//ini_set("soap.wsdl_cache_enabled", "0");
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->VtasNetasDet($parametros);
        $xml = $result->VtasNetasDetResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='griddet' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' width='100%' ></table></div>";

	$arreglo = [];
	for($i=0; $i<count($Datos); $i++){
		$arreglo[$i]=$Datos[$i];
	}

?>

     <script type="text/javascript"> 
        var datos = 
        <?php 
            echo json_encode($arreglo);
        ?>
		;
		<?php
        /*
			$sGridNomb = '#griddet';
			$sWsNomb = 'vtas_netasdet';
			$aColumnas = array("nombre","Facturado","Descuentos","DevolucionProducto","DevolucionRefacturacion","GarantiaNoRe","GarantiaReem","ReFacturacion","Abonos");
			$aTitulos = array("nombre","Facturado","Descuentos","DevolucionProducto","DevolucionRefacturacion","GarantiaNoRe","GarantiaReem","ReFacturacion","Abonos");
			echo GrdRptShort($sGridNomb,$sWsNomb,$aColumnas,$aTitulos);
            */
		?>

   $(document).ready(function() {
         var table = $('#griddet').DataTable({
            data:datos,
            columns: [
                { data: 'nombre' },
                {
                    "className":      'btn_facturado',
                    "orderable":      false,
                    "data":           'Facturado',
                    "defaultContent": ''
                },
                {
                    "className":      'btn_descuentos',
                    "orderable":      false,
                    "data":           'Descuentos',
                    "defaultContent": ''
                },
                {
                    "className":      'btn_devoproducto',
                    "orderable":      false,
                    "data":           'DevolucionProducto',
                    "defaultContent": ''
                },
                {
                    "className":      'btn_devorefactutacion',
                    "orderable":      false,
                    "data":           'DevolucionRefacturacion',
                    "defaultContent": ''
                },
                {
                    "className":      'btn_garantianore',
                    "orderable":      false,
                    "data":           'GarantiaNoRe',
                    "defaultContent": ''
                },
                {
                    "className":      'btn_garantreem',
                    "orderable":      false,
                    "data":           'GarantiaReem',
                    "defaultContent": ''
                },
                {
                    "className":      'btn_refacturacion',
                    "orderable":      false,
                    "data":           'ReFacturacion',
                    "defaultContent": ''
                },
                {
                    "className":      'btn_abonomes',
                    "orderable":      false,
                    "data":           'AbonosFactMes',
                    "defaultContent": ''
                },
                {
                    "className":      'btn_cobrado',
                    "orderable":      false,
                    "data":           'TotalCobradoMes',
                    "defaultContent": ''
                }
            ],
            columnDefs: [
                { 'title': 'Nombre', className: "text-left", 'targets': 0},
                { 'title': 'Facturado', className: "text-left", 'targets': 1},
                { 'title': 'Descuentos', className: "text-left", 'targets': 2},
                { 'title': 'Dev.Producto', className: "text-left", 'targets': 3},
                { 'title': 'Dev.Refacturacion', className: "text-left", 'targets': 4},
                { 'title': 'GarantiaNoRe', className: "text-left", 'targets': 5},
                { 'title': 'GarantiaReem', className: "text-left", 'targets': 6},
                { 'title': 'ReFacturacion', className: "text-left", 'targets': 7},
                { 'title': 'Abonos', className: "text-left", 'targets': 8},
                { 'title': 'Cobrado', className: "text-left", 'targets': 9}
            ],
            paging: false,
            searching: false,
            ordering: false,
            buttons: [
                {
                    extend: 'copy',
                    message: 'PDF created by PDFMake with Buttons for DataTables.',
                    text: 'Copiar',
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    customize: function ( doc ) {
                        // Splice the image in after the header, but before the table
                        doc.content.splice( 1, 0, {
                            
                            alignment: 'center'
                        } );
                        // Data URL generated by http://dataurl.net/#dataurlmaker
                    },
                    filename: '".$sWsNomb."',
                    extension: '.pdf',       
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    header:'true',
                    filename: '".$sWsNomb."',
                    extension: '.csv',       
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'excel',
                    message: 'PDF creado desde el sistema en linea del tayco.',
                    text: 'XLS',
                    filename: '".$sWsNomb."',
                    extension: '.xlsx', 
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    },
                    customize: function( xlsx ) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row:first c', sheet).attr( 's', '42' );
                    }
                },
                {
                    extend: 'print',
                    message: 'PDF creado desde el sistema en linea del tayco.',
                    text: 'Imprimir',
                    exportOptions: {
                        stripHtml: false,
                        modifier: {
                            page: 'all'
                        }
                    }
                },
            ],
            'pagingType': 'full_numbers',
            'lengthMenu': [[-1], ['Todo']],
            'language': {
                'sProcessing':    'Procesando...',
                'sLengthMenu':    'Mostrar _MENU_ registros',
                'sZeroRecords':   'No se encontraron resultados',
                'sEmptyTable':    'Ningún dato disponible en esta tabla',
                'sInfo':          'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                'sInfoEmpty':     'Mostrando registros del 0 al 0 de un total de 0 registros',
                'sInfoFiltered':  '(filtrado de un total de _MAX_ registros)',
                'sInfoPostFix':   '',
                'sSearch':        'Buscar:',
                'sUrl':           '',
                'sInfoThousands':  ',',
                'sLoadingRecords': 'Cargando...',
                'oPaginate': {
                    'sFirst':    'Primero',
                    'sLast':    'Último',
                    'sNext':    'Siguiente',
                    'sPrevious': 'Anterior'
                },
                'oAria': {
                    'sSortAscending':  ': Activar para ordenar la columna de manera ascendente',
                    'sSortDescending': ': Activar para ordenar la columna de manera descendente'
                }
            },
            'paging': false,
            'responsive': true,
        } );
    } );
    </script>