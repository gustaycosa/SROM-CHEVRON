<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        //$Empresa = $_POST["CmbEmpresa"];
        $clave = $_POST["CmbMECAVENTAS"]; 
        $De = $_POST["Fini"];
        $A =  $_POST["Ffin"]; 
        $dDe = strtotime($De);
        $newformat1 = date('Y-m-d',$dDe);
        
        $dA = strtotime($A);
        $newformat2 = date('Y-m-d',$dA);

        
        //parametros de la llamada
        $parametros = array();
        $parametros['sId_Empresa'] = $Empresa;
        $parametros['dtFechaIni'] = $newformat1;
        $parametros['dtFechaFin'] = $newformat2;
        $parametros['sClave'] = $clave;
        //
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->Inf_Tal_Comisiones_Mecanicos_vtas($parametros);
        $xml = $result->Inf_Tal_Comisiones_Mecanicos_vtasResult->any;

        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}
    echo "<div class='table-responsive'>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' width='100%' ><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot>"; 
            echo "</table></div>";

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
                { data: 'TipoServicio' },
                { data: 'Caso' },
                { data: 'Movimiento' },
                { data: 'Id_MO' },
                { data: 'Fecha' },
                { data: 'Articulo' },
                { data: 'Descripcion' },
                { data: 'HorasReales' },
                { data: 'HorasFacturables' },
                { data: 'PrecioMOServicio' },
                { data: 'ImporteMOServicio' },
                { data: 'TotalMOServicio' },
                { data: 'Facturas' },
                { data: 'Tipo' },
                { data: 'FacturaActual' },
                { data: 'FacturaAnterior' },
                { data: 'HorasFacturadas' },
                { data: 'PrecioUnitario' },
                { data: 'ImporteMOFactura' },
                { data: 'TotalMOFactura' },
                { data: 'vComision' },
                { data: 'cliente' },
                { data: 'Comision' }
            ],
            columnDefs: [
                { 'title': 'TIPO SERV', 'width':'50px', className: "text-left", 'targets': 0},
                { 'title': 'CASO', 'width':'50px', className: "text-left", 'targets': 1},
                { 'title': 'MOVIMIENTO', 'width':'50px', className: "text-left", 'targets': 2},
                { 'title': 'ID', 'width':'50px', className: "text-left", 'targets': 3},
                { 'title': 'FECHA', 'width':'50px', className: "text-left", 'targets': 4},
                { 'title': 'ARTICULO', 'width':'50px', className: "text-left", 'targets': 5},
                { 'title': 'DESCRIPCION', 'width':'50px', className: "text-left", 'targets': 6},
                { 'title': 'HRS REALES', 'width':'50px', className: "text-left", 'targets': 7},
                { 'title': 'HRS FACT', 'width':'50px', className: "text-left", 'targets': 8},
                { 'title': 'PRECIO MO', 'width':'50px', className: "text-right", 'targets': 9},
                { 'title': 'IMPORTE MO', 'width':'50px', className: "text-right", 'targets': 10},
                { 'title': 'TOTAL MO', 'width':'50px', className: "text-right", 'targets': 11},
                { 'title': 'FACTURAS', 'width':'50px', className: "text-left", 'targets': 12},
                { 'title': 'TIPO', 'width':'50px', className: "text-left", 'targets': 13},
                { 'title': 'FACT ACTUAL', 'width':'50px', className: "text-right", 'targets': 14},
                { 'title': 'FACT ANTERIOR', 'width':'50px', className: "text-right", 'targets': 15},
                { 'title': 'HRS FACT', 'width':'50px', className: "text-left", 'targets': 16},
                { 'title': 'PRECIO UNITARIO', 'width':'50px', className: "text-right", 'targets': 17},
                { 'title': 'IMPORTE MO FACT', 'width':'50px', className: "text-right", 'targets': 18},
                { 'title': 'TOTAL MO FACT', 'width':'50px', className: "text-right", 'targets': 19},
                { 'title': 'VCOMISION', 'width':'50px', className: "text-right", 'targets': 20},
                { 'title': 'CLIENTE', 'width':'50px', className: "text-left", 'targets': 21},
                { 'title': 'COMISION', 'width':'50px', className: "text-right", 'targets': 22}
            ],
            'createdRow': function ( row, data, index ) {
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
                    customize: function ( doc ) {
                        // Splice the image in after the header, but before the table
                        doc.content.splice( 1, 0, {
                            
                            alignment: 'center'
                        } );
                        // Data URL generated by http://dataurl.net/#dataurlmaker
                    },
                    filename: 'vtas_netasfact',
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
                    filename: 'vtas_netasfact',
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
                    filename: 'vtas_netasfact',
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
           
            var api_anoant = this.api(), data;
            var api_anoact = this.api(), data;
            var api_utilper = this.api(), data;
            var api_inggen = this.api(), data;
            var api_promen = this.api(), data;
            var api_acuene = this.api(), data;
            var api_variac = this.api(), data;
            var api_mesant = this.api(), data;
            var api_mesact = this.api(), data;

            
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            //===========================================================================
            total_anoant = api_anoant
                .column( 17 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_anoant.column( 17 ).footer() ).html('$'+ total_anoant.toFixed(2) );
           
            //===========================================================================
            total_anoact = api_anoact
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_anoact.column( 9 ).footer() ).html('$'+ total_anoact.toFixed(2) );
           
            //===========================================================================
            total_utilper = api_utilper
                .column( 10 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_utilper.column( 10 ).footer() ).html('$'+ total_utilper.toFixed(2) );
           
            //===========================================================================
            total_inggen = api_inggen
                .column( 11 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_inggen.column( 11 ).footer() ).html('$'+ total_inggen.toFixed(2) );

            //===========================================================================
            total_promen = api_promen
                .column( 18 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_promen.column( 18 ).footer() ).html('$'+ total_promen.toFixed(2) );

            //===========================================================================
            total_acuene = api_acuene
                .column( 19 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_acuene.column( 19 ).footer() ).html('$'+ total_acuene.toFixed(2) );
           
            //===========================================================================
            total_variac = api_variac
                .column( 20 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_variac.column( 20 ).footer() ).html('$'+ total_variac.toFixed(2) );
           
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
