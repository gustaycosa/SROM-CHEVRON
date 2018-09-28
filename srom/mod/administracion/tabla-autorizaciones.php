<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        $Empresa =  $_POST["TxtEmpresa"];
        $Estatus =  $_POST["CmbEstatus"];
        $FechaIni =  $_POST["txtFechaIni"]; 
        $FechaFin =  $_POST["txtFechaFin"]; 
        $Sucursal =  $_POST["CmbSUCURSALES"]; 
        $Solicita =  $_POST["CmbNOMBRESUSUARIOWEB"]; 
        $Responsable =  $_POST["TxtEjercicio"]; 
        $Departamento =  $_POST["CmbDepto"]; 

        //parametros de la llamada
        
        //parametros de la llamada
        $parametros = array();
        $parametros['sId_Empresa'] = $Empresa;
        $parametros['sEstatus'] = $Estatus;
        $parametros['sFechaIni'] = $FechaIni;
        $parametros['sFechaFin'] = $FechaFin;
        $parametros['sSucursal'] = $Sucursal;
        $parametros['iSolicita'] = $Solicita;
        $parametros['iResponsable'] = $Responsable;
        $parametros['sDepto'] = $Departamento;

/*        echo'<script>alert("'.$Empresa.'-'.$Estatus.'-'.$FechaIni.'-'.$FechaFin.'-'.$Sucursal.'-'.$Solicita.'-'.$Responsable.'-'.$Departamento.'");</script>';*/
        $WS = new SoapClient($WebService, $parametros);
        $result = $WS->AutSelect($parametros);
        $xml = $result->AutSelectResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' style='width:100%;' ><tfoot><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tfoot></table></div>";

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
                    { data: "idAumento" },
                    { data: "FechaSol" },
                    { data: "Pedido" },
                    { data: "CONCEPTO" },
                    { data: "NomSolicita" },
                    { data: "total" },
                    { data: "Estatus" },
                    {
                        "className":      'autok',
                        "orderable":      false,
                        "data":           '',
                        "defaultContent": 'AUTORIZAR'
                    },
                    {
                        "className":      'autcn',
                        "orderable":      false,
                        "data":           '',
                        "defaultContent": 'RECHAZAR'
                    }
                ],
                columnDefs: [
                    { "title": "AUMENTO",  'width':'60px', className: "text-left", 'targets': 0},
                    { "title": "FECHA SOLICITUD",  'width':'60px', className: "text-left", 'targets': 1},
                    { "title": "PEDIDO",  'width':'60px', className: "text-left", 'targets': 2},
                    { "title": "CONCEPTO", "width": "300px", className: "text-left", 'targets': 3},
                    { "title": "SOLICITA",  'width':'60px', className: "text-left", 'targets': 4},
                    { "title": "TOTAL",  'width':'60px', className: "text-right", 'targets': 5},
                    { "title": "ESTATUS",  'width':'60px', className: "text-left", 'targets': 6},
                    { "title": "",  'width':'60px', className: "text-left", 'targets': 7},
                    { "title": "",  'width':'60px', className: "text-left", 'targets': 8}
                ],
            'createdRow': function ( row, data, index ) {
                $(row).attr({ id:data.idAumento,mov:data.Pedido});
                //$(row).addClass('tar');
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

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            //===========================================================================
            total_anoant = api_anoant
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_anoant.column( 5 ).footer() ).html('$'+ total_anoant.toFixed(2) );
        }
        } );
        var myArray = [];
            
        $('#grid tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
            var id = $(this).attr("id");

            myArray.push(id);
/*            jQuery.each(myArray, function(i, val) {
              $("#ArrayCap").append(i + " : " + val + ",");          
            });*/
            //alert(myArray);
        } );

        $('#button').click( function () {
            //alert( table.rows('.selected').data().length +' filas seleccionadas' );
            $.ajax({
               type: "POST",
               data: {info:myArray},
               url: "nvo-autoksel.php",
               success: function(msg){
                 $('.respuesta').html(msg);
               }
            });
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