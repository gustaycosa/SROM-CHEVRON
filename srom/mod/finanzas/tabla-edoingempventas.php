<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        
        $Ejercicio =  $_POST["TxtEjercicio"]; 
        $Mes =  $_POST["TxtMes"]; 

        
        //parametros de la llamada
        $parametros = array();
        $parametros['Empresa'] = 'TAYCOSA';
        $parametros['Mes'] = $Mes;
        $parametros['Ejercicio'] = $Ejercicio;
        //ini_set("soap.wsdl_cache_enabled", "0");
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        //$result = $WS->Edoresultados($parametros);
        //$xml = $result->EdoresultadosResult->any;
        $result = $WS->edomplementoempventas($parametros);
        $xml = $result->edomplementoempventasResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact nowrap' cellspacing='0' width='100%'><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table></div>"; 

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
                { data: 'Id_Vendedor' },
                { data: 'Cve_Documento' },
                { data: 'FechaPago' },
                { data: 'Cliente' },
                { data: 'Concepto' },
                { data: 'Subtotal' }
            ],
            columnDefs: [
                { 'title': 'VENDEDOR', className: "text-left", 'targets': 0},
                { 'title': 'CLAVE DOCTO', className: "text-left", 'targets': 1},
                { 'title': 'FECHA PAGO', className: "text-left", 'targets': 2},
                { 'title': 'CLIENTE', className: "text-left", 'targets': 3},
                { 'title': 'CONCEPTO', className: "text-left", 'targets': 4},
                { 'title': 'SUBTOTAL', className: "text-left", 'targets': 5}
            ],
            "createdRow": function ( row, data, index ) {
                $(row).attr({ id:data.Id_ConceptoCtb});
                $(row).addClass(data.REF);
                if ( data.TF == 'T1' ) {
                    $(row).addClass('T1');
                }
                else if ( data.TF == 'T2' ) {
                    $(row).addClass('T2');
                }
                else if ( data.TF == 'T3' ) {
                    $(row).addClass('T3');
                }
                else if ( data.TF == 'N' ) {
                    $(row).addClass('N');
                    $(row).hide();
                }
            },
            dom: 'lfBrtip',    
            paging: false,
            searching: true,
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
            },
            'scrollY':        '60vh',
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
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Total over all pages
            total_abono = api_abono
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            
            // Total over all pages
            total_vtas = api_vtas
                .column( 4 )
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
            $( api_total.column( 5 ).footer() ).html('$'+ total_total.toFixed(2) );


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

    $(function(){
        $('.T1').click(function() {                
            if ($('.N').css("display") != "none" ) {
                $('.N').hide(); 
            }else{
                $('.N').show(); 
            }
        });
    });
    </script>