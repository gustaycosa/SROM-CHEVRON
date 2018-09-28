<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        $Empresa =  $_POST["TxtClave"]; 
        $Movimiento = $_POST["TxtClave"]; 
        
        
        //parametros de la llamada
        $parametros = array();
        $parametros['Empresa'] = 'TAYCOSA';
        $parametros['Movimiento'] = $Movimiento;
		
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->VentasCasosHrsMO($parametros);
        $xml = $result->VentasCasosHrsMOResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='griddet' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' width='100%' ><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table></div>";
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
                { data: 'Fecha' },
                { data: 'Descripcion' },
                { data: 'HORAS' },
                { data: 'PrecioVenta' },
                { data: 'Iva' },
                { data: 'ImportePrecioVenta' },
                { data: 'ImpIvaPrecioVenta' },
                { data: 'SubtotalPrecioVenta' },
                { data: 'Mecanico' }
            ],
            columnDefs: [
                { 'title': 'FECHA', 'width':'40px', className: "text-left", 'targets': 0},
                { 'title': 'DESCRIPCION', 'width':'150px', className: "text-left", 'targets': 1},
                { 'title': 'HORAS', 'width':'40px', className: "text-left", 'targets': 2},
                { 'title': 'PRECIO VENTA', 'width':'100px', className: "text-left", 'targets': 3},
                { 'title': 'IVA', 'width':'30px', className: "text-left", 'targets': 4},
                { 'title': 'IMPORTE', 'width':'30px', className: "text-left", 'targets': 5},
                { 'title': 'IMPORTE IVA', 'width':'30px', className: "text-left", 'targets': 6},
                { 'title': 'SUBTOTAL', 'width':'30px', className: "text-left", 'targets': 7},
                { 'title': 'MECANICO', 'width':'30px', className: "text-left", 'targets': 8}
            ],
            'createdRow': function ( row, data, index ) {
//                $(row).attr({ id:data.id_Vendedor});
//                $(row).addClass('vendedor');
            },
            dom: 'lfBrtip',
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
                    filename: 'ventasnetas',
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
                    filename: 'ventasnetas',
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
                    filename: 'ventasnetas',
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
            'scrollY': '60vh',
            'scrollX': true,
            'scrollCollapse': true,
            'paging': false
        } );
    } );
    </script>