<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        $Ejercicio =  $_POST["TxtEjercicio"]; 
        $Mes =  $_POST["TxtMes"]; 
		$Moneda = $_POST["CmbMoneda"]; 
        
        
        //parametros de la llamada
        $parametros = array();
        $parametros['Id_Empresa'] = 'TAYCOSA';
        $parametros['Mes'] = $Mes;
        $parametros['Ejercicio'] = $Ejercicio;
		$parametros['Moneda'] = $Moneda;
		
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->VentasNetasDetalle2($parametros);
        $xml = $result->VentasNetasDetalle2Result->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='grid2' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' width='100%' ><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table></div>";

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
         var table = $('#grid2').DataTable({
            data:datos,
            columns: [
                { data: 'nombre', 'className':'text-left' },
                { "className": 'text-right btn_facturado', "orderable": false, "data": 'Facturado', "defaultContent": ''},
                { "className": 'text-right btn_descuentos', "orderable": false, "data": 'Descuentos', "defaultContent": ''},
                { "className": 'text-right btn_devoproducto', "orderable": false, "data": 'DevolucionProducto', "defaultContent": ''},
                {"className": 'text-right btn_devorefactutacion', "orderable": false, "data": 'DevolucionRefacturacion',"defaultContent": ''},
                { "className": 'text-right btn_garantianore', "orderable": false, "data": 'GarantiaNoRe', "defaultContent": '' },
                { "className": 'text-right btn_garantreem', "orderable": false, "data": 'GarantiaReem', "defaultContent": '' },
                { "className": 'text-right btn_refacturacion', "orderable": false, "data": 'ReFacturacion', "defaultContent": ''},
                { "className": 'text-right btn_cobrado', "orderable": false, "data": 'TotalCobradoMes', "defaultContent": ''},
                { data: 'VtasNetas', 'className':'text-right' },
            ],
            columnDefs: [
                { 'title': 'Nombre',  'width':'200px', className: "text-left", 'targets': 0},
                { 'title': 'Facturado',  'width':'50px', className: "text-right", 'targets': 1},
                { 'title': 'Descuentos',  'width':'50px', className: "text-right", 'targets': 2},
                { 'title': 'Dev.Producto',  'width':'50px', className: "text-right", 'targets': 3},
                { 'title': 'Dev.Refacturacion',  'width':'50px', className: "text-right", 'targets': 4},
                { 'title': 'GarantiaNoRe',  'width':'50px', className: "text-right", 'targets': 5},
                { 'title': 'GarantiaReem',  'width':'50px', className: "text-right", 'targets': 6},
                { 'title': 'ReFacturacion',  'width':'50px', className: "text-right", 'targets': 7},
                { 'title': 'Cobrado',  'width':'50px', className: "text-right", 'targets': 8},
                { 'title': 'Vtas netas',  'width':'50px', className: "text-right", 'targets': 9}
            ],
            'createdRow': function ( row, data, index ) {
                $(row).attr({ id:data.id_Vendedor});
                $(row).addClass('vendedor');
            },
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
            },
            'paging': false,
            'responsive': true
                    },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            var api_total = this.api(), data;
            
            var api_facturado = this.api(), data;
            var api_descuentos = this.api(), data;
            var api_devolucion = this.api(), data;
            var api_drefacturacion = this.api(), data;
            var api_garantianore = this.api(), data;
            var api_garantiare = this.api(), data;
            var api_refacturacion = this.api(), data;
            var api_cobrado = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            
            // Total over all pages
            total_facturado = api_facturado
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_facturado.column( 1 ).footer() ).html('$'+ total_facturado.toFixed(2) );
            
             // Total over all pages
            total_descuentos = api_descuentos
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_descuentos.column( 2 ).footer() ).html('$'+ total_descuentos.toFixed(2) );   
            
             // Total over all pages
            total_devolucion = api_devolucion
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_devolucion.column( 3 ).footer() ).html('$'+ total_devolucion.toFixed(2) );      
            
             // Total over all pages
            total_drefacturacion = api_drefacturacion
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_drefacturacion.column( 4 ).footer() ).html('$'+ total_drefacturacion.toFixed(2) );   
            
             // Total over all pages
            total_garantianore = api_garantianore
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_garantianore.column( 5 ).footer() ).html('$'+ total_garantianore.toFixed(2) ); 

             // Total over all pages
            total_garantiare = api_garantiare
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_garantiare.column( 6 ).footer() ).html('$'+ total_garantiare.toFixed(2) ); 

             // Total over all pages
            total_refacturacion = api_refacturacion
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_refacturacion.column( 7 ).footer() ).html('$'+ total_refacturacion.toFixed(2) ); 
            
             // Total over all pages
            total_cobrado = api_cobrado
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_cobrado.column( 8 ).footer() ).html('$'+ total_cobrado.toFixed(2) ); 
            
            // Total over all pages
            total_total = api_total
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_total.column( 9 ).footer() ).html('$'+ total_total.toFixed(2) );
            

            $("#TotalFac").empty();
            $("#TotalFac").append('$' + total_total.toFixed(2) + ' TOTAL');
            
        }
        } );
    } );
    </script>