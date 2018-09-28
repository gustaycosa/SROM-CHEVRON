<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        
        $Empresa = $_POST["CmbEmpresa"];
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
        //ini_set("soap.wsdl_cache_enabled", "0");
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
                { 'title': 'TIPO SERV',className: "text-left", 'targets': 0},
                { 'title': 'CASO',className: "text-left", 'targets': 1},
                { 'title': 'MOVIMIENTO',className: "text-left", 'targets': 2},
                { 'title': 'ID MO',className: "text-left", 'targets': 3},
                { 'title': 'FECHA',className: "text-left", 'targets': 4},
                { 'title': 'ARTICULO',className: "text-left", 'targets': 5},
                { 'title': 'DESCRIPCION',className: "text-left", 'targets': 6},
                { 'title': 'HRS REALES',className: "text-left", 'targets': 7},
                { 'title': 'HRS FACT',className: "text-left", 'targets': 8},
                { 'title': 'PRECIO MO',className: "text-left", 'targets': 9},
                { 'title': 'IMPORTE MO',className: "text-left", 'targets': 10},
                { 'title': 'TOTAL MO',className: "text-left", 'targets': 11},
                { 'title': 'FACTURAS',className: "text-left", 'targets': 12},
                { 'title': 'TIPO',className: "text-left", 'targets': 13},
                { 'title': 'FACT ACTUAL',className: "text-left", 'targets': 14},
                { 'title': 'FACT ANTERIOR',className: "text-left", 'targets': 15},
                { 'title': 'HRS FACT',className: "text-left", 'targets': 16},
                { 'title': 'PRECIO UNITARIO',className: "text-left", 'targets': 17},
                { 'title': 'IMPORTE MO FACT',className: "text-left", 'targets': 18},
                { 'title': 'TOTAL MO FACT',className: "text-left", 'targets': 19},
                { 'title': 'VCOMISION',className: "text-left", 'targets': 20},
                { 'title': 'CLIENTE',className: "text-left", 'targets': 21},
                { 'title': 'COMISION',className: "text-left", 'targets': 22}
            ],
            'createdRow': function ( row, data, index ) {
            },  
            fixedHeader: true,
            dom: 'lfBrtip', 
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
                    filename: 'commecanicosvtas',
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
                    filename: 'commecanicosvtas',
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
                    filename: 'commecanicosvtas',
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
            'scrollY':        '60vh',
            'scrollX':        true,
            'scrollCollapse': true,
            'paging':         false
            },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            var api_total = this.api(), data;
            var api_abono = this.api(), data;
            var api_vtas = this.api(), data;
            
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            // Total over all pages
            total_total = api_total
                .column( 21 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );


            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_total.column( 21 ).footer() ).html('$'+ total_total.toFixed(2) );    
            
            var COMIR = this.api(), data;
            var COMIM = this.api(), data;
            var COMIVC = this.api(), data;
            var COMIMO = this.api(), data;
            var COMIMOP = this.api(), data;
            var COMITRA = this.api(), data;
            
            /*
            totalFinal= total33 + total34 + total35 + total36 + total37 + total38 
            // Update footer
            $( api.column( 38 ).footer() ).html(
                '$'+ total38 +' total <br>' 
                + '$' + totalFinal.toFixed(2) + ' total final'
            );
            
            $("#TotalComisiones").val('$' + totalFinal.toFixed(2) + ' COMISION TOTAL');
            */
        }
        } );
    } );
        
    </script>
