<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        $Moneda =  $_POST["CmbMoneda"]; 
        $Fini =  $_POST["Fini"]; 
        $Ffin =  $_POST["Ffin"]; 
        
        $parametros = array();
        $parametros['Id_Empresa'] = 'TAYCOSA';
        $parametros['FechaIni'] = $Fini;
        $parametros['FechaFin'] = $Ffin;
        $parametros['Moneda'] = $Moneda;
        $WS = new SoapClient($WebService, $parametros);
        $result = $WS->ComisionesVendedorSum($parametros);
        $xml = $result->ComisionesVendedorSumResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{
        $Moneda =  $_POST["CmbMoneda"]; 
        $Fini =  $_POST["Fini"]; 
        $Ffin =  $_POST["Ffin"]; 
        
        $parametros = array();
        $parametros['Id_Empresa'] = 'TAYCOSA';
        $parametros['FechaIni'] = $Fini;
        $parametros['FechaFin'] = $Ffin;
        $parametros['Moneda'] = $Moneda;
        $WS = new SoapClient($WebService, $parametros);
        $result = $WS->ComisionesVendedorSum($parametros);
        $xml = $result->ComisionesVendedorSumResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }

} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' width='100%' ><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table></div>";

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
			$sGridNomb = '#gridfact';
			$sWsNomb = 'vtas_netasfact';
			$aColumnas = array("Fecha","Id_Sucursal","Serie","Folio","Id_cliente","Nombre","Concepto","Total");
			$aTitulos =  array("Fecha","Id_Sucursal","Serie","Folio","Id_cliente","Nombre","Concepto","Total");
			echo GrdRptShort($sGridNomb,$sWsNomb,$aColumnas,$aTitulos);
            */
		?>

   $(document).ready(function() {
         var table = $('#grid').DataTable({
            data:datos,
            columns: [
                { data: 'NOMBRE' },
                { data: 'Comi_Imp_REF' },
                { data: 'Comi_Imp_MAQ' },
                { data: 'Comi_Imp_Vta_Contado' },
                { data: 'Comi_Imp_MO' },
                { data: 'Comi_Imp_MOP' },
                { data: 'Comi_Imp_TRA' }
            ],
            columnDefs: [
                { 'title': 'Nombre', 'width':'50px', className: "text-left", 'targets': 0},
                { 'title': 'Refacciones', 'width':'50px', className: "text-right", 'targets': 1},
                { 'title': 'Maquinaria', 'width':'50px', className: "text-right", 'targets': 2},
                { 'title': 'Venta contado', 'width':'50px', className: "text-right", 'targets': 3},
                { 'title': 'Mano de obra', 'width':'50px', className: "text-right", 'targets': 4},
                { 'title': 'Mano de obra pintura', 'width':'50px', className: "text-right", 'targets': 5},
                { 'title': 'Traslado', 'width':'50px', className: "text-right", 'targets': 6}
            ],
            'createdRow': function ( row, data, index ) {
                $(row).attr({ id:data.id_vendedor});
                $(row).addClass('vendedor');
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
            var api_ref = this.api(), data;
            var api_maq = this.api(), data;
            var api_cont = this.api(), data;
            var api_mo = this.api(), data;
            var api_mop = this.api(), data;
            var api_tra = this.api(), data;
            
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total_ref = api_ref
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            
            // Total over all pages
            total_maq = api_maq
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Total over all pages
            total_cont = api_cont
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            
            // Total over all pages
            total_mo = api_mo
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Total over all pages
            total_mop = api_mop
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Total over all pages
            total_tra = api_tra
                .column( 6 )
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
            $( api_ref.column( 1 ).footer() ).html('$'+ total_ref.toFixed(2) );
            $( api_maq.column( 2 ).footer() ).html('$'+ total_maq.toFixed(2) );
            $( api_cont.column( 3 ).footer() ).html('$'+ total_cont.toFixed(2) );
            $( api_mo.column( 4 ).footer() ).html('$'+ total_mo.toFixed(2) );
            $( api_mop.column( 5 ).footer() ).html('$'+ total_mop.toFixed(2) );
            $( api_tra.column( 6 ).footer() ).html('$'+ total_tra.toFixed(2) );
            
            var COMIR = this.api(), data;
            var COMIM = this.api(), data;
            var COMIVC = this.api(), data;
            var COMIMO = this.api(), data;
            var COMIMOP = this.api(), data;
            var COMITRA = this.api(), data;
            
            
            totalFinal= total_ref + total_maq + total_cont + total_mo + total_mop + total_tra;
            totalCobrado = total_ref * 50;
            totalRecepcion = totalCobrado / 100 * 0.5;
            
            /*
            $("#lbltotal").empty();
            $("#lbltotal").append('COMISIONES TOTALES REF = $' + total_ref.toFixed(2) + '-> COBRADO = $'+ totalCobrado.toFixed(2) +' -> COMISION RECEPCION = $' + totalRecepcion.toFixed(2));
            */
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