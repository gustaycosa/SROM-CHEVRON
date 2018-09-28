<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        $FechaIni =  $_POST["txtFechaIni"]; 
        $FechaFin =  $_POST["txtFechaFin"]; 
        $CveMecanico = $_POST["CmbMECAVENTAS"]; 
        
        
        //parametros de la llamada
        $parametros = array();
        $parametros['Empresa'] = 'TAYCOSA';
        $parametros['Cve_Mecanico'] = $CveMecanico;
        $parametros['FechaIni'] = $FechaIni;
		$parametros['FechaFin'] = $FechaFin;
		
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->TallerMecBit($parametros);
        $xml = $result->TallerMecBitResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' width='100%' ><tfoot><tr><th>FECHA</th><th>HORAS</th><th>CLASIFICACION</th><th>DESCRIPCION</th><th>TIPO</th><th>TALLER</th><th>SERVICIO</th><th>CLIENTE</th><th>ESTATUS</th></tr></tfoot></table></div>";

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
         var table = $('#grid').DataTable({
            data:datos,
            columns: [
                { data: 'MECANICO' },
                { data: 'FECHA' },
                { data: 'NUM_HORAS' },
                { data: 'CLASIFICACION' },
                { data: 'DESCRIPCION' },
                { data: 'TIPO_SERVICIO' },
                { data: 'TALLER' },
                { data: 'SERVICIO' },
                { data: 'CLIENTE' },
                { data: 'ESTATUS_SERVICIO' }
            ],
            columnDefs: [
                { 'title': 'MECANICO', 'width':'100px', className: "text-left", 'targets': 0},
                { 'title': 'FECHA', 'width':'100px', className: "text-center", 'targets': 1},
                { 'title': 'HORAS', 'width':'100px', className: "text-center", 'targets': 2},
                { 'title': 'CLASIFICACION', 'width':'100px', className: "text-center", 'targets': 3},
                { 'title': 'DESCRIPCION', 'width':'100px', className: "text-left", 'targets': 4},
                { 'title': 'TIPO_SERVICIO', 'width':'100px', className: "text-center", 'targets': 5},
                { 'title': 'TALLER', 'width':'100px', className: "text-left", 'targets': 6},
                { 'title': 'SERVICIO', 'width':'100px', className: "text-left", 'targets': 7},
                { 'title': 'CLIENTE', 'width':'100px', className: "text-left", 'targets': 8},
                { 'title': 'ESTATUS', 'width':'100px', className: "text-center", 'targets': 9}
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
            'scrollCollapse': true,
            'scrollX': true,
            'paging': false,
             fixedHeader: {
                header: false,
                footer: true
            },
            'responsive':true,
            "footerCallback": function ( row, data, start, end, display ) {
//                 var api = this.api(), data;
//                var api_total = this.api(), data;
//
//                // Remove the formatting to get integer data for summation
//                var intVal = function ( i ) {
//                    return typeof i === 'string' ?
//                        i.replace(/[\$,]/g, '')*1 :
//                        typeof i === 'number' ?
//                            i : 0;
//                };
//
//                // Total over all pages
//                total_total = api_total
//                    .column( 9 )
//                    .data()
//                    .reduce( function (a, b) {
//                        return intVal(a) + intVal(b);
//                    }, 0 );
//
//                // Update footer
//                $( api_total.column( 9 ).footer() ).html('$'+ total_total.toFixed(2) );

                //$("#TotalFac").empty();
                // $("#TotalFac").append('$' + total_total.toFixed(2) + ' TOTAL');

            }
        } );
    } );
    </script>