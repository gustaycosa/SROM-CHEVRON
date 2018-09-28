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
        $result = $WS->edoflujoefectivo($parametros);
        $xml = $result->edoflujoefectivoResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' width='100%' ><tfoot><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tfoot></table></div>";

$arreglo = [];
for($i=0; $i<count($Datos); $i++){
    $arreglo[$i]=$Datos[$i];
}
        //print_r($arreglo);
        //echo number_format($Suma, 2, ',', ' ');

?>

    <script type="text/javascript"> 
        var datos = 
        <?php 
            echo json_encode($arreglo);
        ?>
        ;
        $(document).ready(function() {

            var table = $('#grid').DataTable({
                data:datos,
                columns: [
                    { data: "ConceptoCtb" },
                    { data: "Dic" },
                    { data: "Nov" },
                    { data: "Oct" },
                    { data: "Sep" },
                    { data: "Ago" },
                    { data: "Jul" },
					{ data: "Jun" },
                    { data: "May" },
                    { data: "Abr" },
                    { data: "Mar" },
                    { data: "Feb" },
                    { data: "Ene" },
                    { data: "Acumulado" }
                ],
                columnDefs: [
                    { 'title': 'CONCEPTO CONTABLE', 'width':'150px', className: "text-left", 'targets': 0},
                    { 'title': 'ENE', 'width':'50px', className: "text-right", 'targets': 1},
                    { 'title': 'FEB', 'width':'50px', className: "text-right", 'targets': 2},
                    { 'title': 'MAR', 'width':'50px', className: "text-right", 'targets': 3},
                    { 'title': 'ABR', 'width':'50px', className: "text-right", 'targets': 4},
                    { 'title': 'MAY', 'width':'50px', className: "text-right", 'targets': 5},
                    { 'title': 'JUN', 'width':'50px', className: "text-right", 'targets': 6},
                    { 'title': 'JUL', 'width':'50px', className: "text-right", 'targets': 7},
                    { 'title': 'AGO', 'width':'50px', className: "text-right", 'targets': 8},
                    { 'title': 'SEP', 'width':'50px', className: "text-right", 'targets': 9},
                    { 'title': 'OCT', 'width':'50px', className: "text-right", 'targets': 10},
                    { 'title': 'NOV', 'width':'50px', className: "text-right", 'targets': 11},
                    { 'title': 'DIC', 'width':'50px', className: "text-right", 'targets': 12},
                    { 'title': 'ACUMULADO', 'width':'50px', className: "text-right", 'targets': 13}
                ],
                "createdRow": function ( row, data, index ) {
                    
                    var ref = '';
                    //console.log(data);
                    if ( data.TF == 'T1' ) {
                        ref = data.ConceptoCtb;
                        $(row).addClass('T1');
                        $(row).attr({
                          //alt: "Beijing Brush Seller",
                          //title: "photo by Kelly Clark",
                          id:data.ConceptoCtb
                        });
                        //ref = data.ConceptoCtb;
                    }
                    else if ( data.TF == 'T2' ) {
                        $(row).addClass('T2');
                        //$('td', row).addClass('T2');
                    }
                    else if ( data.TF == 'T3' ) {
                        $(row).addClass('T3');
                    }
                    else if ( data.TF == 'N' ) {
                        $(row).addClass('N');
                        $(row).hide();
                        $(row).attr({
                          //alt: "Beijing Brush Seller",
                          //title: "photo by Kelly Clark",
                          //ref:ref
                          //ref:ref
                        });
                    }
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
           
            var api_trec = this.api(), data;
            var api_doce = this.api(), data;
            var api_once = this.api(), data;
            var api_diez = this.api(), data;
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
            total_trec = api_trec
                .column( 13 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_trec.column( 13 ).footer() ).html('$'+ total_trec.toFixed(2) );
           
            //===========================================================================
            total_doce = api_doce
                .column( 12 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_doce.column( 12 ).footer() ).html('$'+ total_doce.toFixed(2) );
           
            //===========================================================================
            total_once = api_once
                .column( 11 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_once.column( 11 ).footer() ).html('$'+ total_once.toFixed(2) );
           
            //===========================================================================
            total_diez = api_diez
                .column( 10 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_diez.column( 10 ).footer() ).html('$'+ total_diez.toFixed(2) );
           
            //===========================================================================
            total_anoant = api_anoant
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_anoant.column( 9 ).footer() ).html('$'+ total_anoant.toFixed(2) );
           
            //===========================================================================
            total_anoact = api_anoact
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_anoact.column( 8 ).footer() ).html('$'+ total_anoact.toFixed(2) );
           
            //===========================================================================
            total_utilper = api_utilper
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_utilper.column( 7 ).footer() ).html('$'+ total_utilper.toFixed(2) );
           
            //===========================================================================
            total_inggen = api_inggen
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_inggen.column( 6 ).footer() ).html('$'+ total_inggen.toFixed(2) );

            //===========================================================================
            total_promen = api_promen
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_promen.column( 5 ).footer() ).html('$'+ total_promen.toFixed(2) );

            //===========================================================================
            total_acuene = api_acuene
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_acuene.column( 4 ).footer() ).html('$'+ total_acuene.toFixed(2) );
           
            //===========================================================================
            total_variac = api_variac
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_variac.column( 3 ).footer() ).html('$'+ total_variac.toFixed(2) );
           
            //===========================================================================
            total_mesant = api_mesant
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_mesant.column( 2 ).footer() ).html('$'+ total_mesant.toFixed(2) );
           
            //===========================================================================
            total_mesact = api_mesact
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_mesact.column( 1 ).footer() ).html('$'+ total_mesact.toFixed(2) );
           
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
        //FUNCION DE PLATILLOS MENUS
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