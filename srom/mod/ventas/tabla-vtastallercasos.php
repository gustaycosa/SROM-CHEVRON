<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        $Empresa =  $_POST["TxtClave"]; 
        $CveMecanico = $_POST["CmbMECAVENTAS"]; 
        
        
        //parametros de la llamada
        $parametros = array();
        $parametros['Empresa'] = $Empresa;
        $parametros['Cve_Mecanico'] = $CveMecanico;
		
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->TallerMecCasos($parametros);
        $xml = $result->TallerMecCasosResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}
//
    echo "<div class='table-responsive'>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' width='100%' ><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table></div>";
	$arreglo = [];
	for($i=0; $i<count($Datos); $i++){
		$arreglo[$i]=$Datos[$i];
	}

?>

     <script type="text/javascript"> 
         
   $(document).ready(function() {
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

         var table = $('#grid').DataTable({
            data:datos,
            columns: [
                { data: 'MECANICO' },
                { data: 'CASO' },
                { data: 'SERVICIO' },
                { data: 'CHECK_LIST' },
                { data: 'TIPO' },
                { data: 'DIAS' },
                { data: 'FECHA' },
                { data: 'SERIE' },
                { data: 'MARCA' },
                { data: 'TIPO_MAQUINA' },
                { data: 'MODELO' },
                { data: 'CLIENTE' },
                { data: 'CONCEPTO' },
                {
                    "className":      'btn_refacciones',
                    "orderable":      false,
                    "data":           'REFACCIONES',
                    "defaultContent": ''
                },
                {
                    "className":      'btn_horasmo',
                    "orderable":      false,
                    "data":           'HORAS',
                    "defaultContent": ''
                },
                { data: 'PRECIO_VENTA' }
            ], 
            columnDefs: [
                { 'title': 'MECANICO', 'width':'150px', className: "text-left", 'targets': 0},
                { 'title': 'CASO', 'width':'60px', className: "text-center", 'targets': 1},
                { 'title': 'SERVICIO', 'width':'80px', className: "text-left", 'targets': 2},
                { 'title': 'CHECKLIST', 'width':'40px', className: "text-left", 'targets': 3},
                { 'title': 'TIPO', 'width':'100px', className: "text-left", 'targets': 4},
                { 'title': 'DIAS', 'width':'40px', className: "text-center", 'targets': 5},
                { 'title': 'FECHA', 'width':'50px', className: "text-center", 'targets': 6},
                { 'title': 'SERIE', 'width':'50px', className: "text-left", 'targets': 7},
                { 'title': 'MARCA', 'width':'100px', className: "text-left", 'targets': 8},
                { 'title': 'TIPO', 'width':'100px', className: "text-left", 'targets': 9},
                { 'title': 'MODELO', 'width':'100px', className: "text-left", 'targets': 10},
                { 'title': 'CLIENTE', 'width':'150px', className: "text-left", 'targets': 11},
                { 'title': 'CONCEPTO', 'width':'150px', className: "text-left", 'targets': 12},
                { 'title': 'REFACCIONES', 'width':'30px', className: "text-left", 'targets': 13},
                { 'title': 'HORAS', 'width':'30px', className: "text-center", 'targets': 14},
                { 'title': 'PRECIO VENTA', 'width':'40px', className: "text-right", 'targets': 15}
            ],
            'createdRow': function ( row, data, index ) {
                $(row).attr({ id:data.SERVICIO});
            },
            dom: 'lfBrtip',
            paging: false,
            searching: true,
            ordering: true,
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
                header: true,
                footer: false
            },
            'responsive':true,
            "footerCallback": function ( row, data, start, end, display ) {
                 var api = this.api(), data;
                var api_total = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total_total = api_total
                    .column( 15 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update footer
                $( api_total.column( 15 ).footer() ).html('$'+ total_total.toFixed(2) );

                //$("#TotalFac").empty();
                // $("#TotalFac").append('$' + total_total.toFixed(2) + ' TOTAL');

            }
        } );
        $('#txtbusqueda').on('keyup change', function() {
          //clear global search values
          table.search('');
          table.column($(this).data('columnIndex')).search(this.value).draw();
        });

        $(".dataTables_filter input").on('keyup change', function() {
          //clear column search values
          table.columns().search('');
          //clear input values
          $('#txtbusqueda').val('');
        });
    } );
    </script>