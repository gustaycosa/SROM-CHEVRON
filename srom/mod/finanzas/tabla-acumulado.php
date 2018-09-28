<?php include("../../funciones.php");

$Columnas = array("Id_ReporteContable","ReporteContable","ConceptoCtb","FEB_2017","MAR_2017","ABR_2017","MAY_2017","JUN_2017","JUL_2017");

$Titulos = array("EMPLEADO","FECHA","ART","CONCEPTO","CLASIFICACION","FACTURA ACTUAL","CLIENTE","SUBTOTAL");

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
        $result = $WS->Edoresultados($parametros);
        $xml = $result->EdoresultadosResult->any;
        //$result = $WS->edocumulado($parametros);
        //$xml = $result->edocumuladoResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' width='100%' ><thead><tr>"; 
            for($i=0; $i<count($Titulos); $i++){
                echo "<th>".$Titulos[$i]."</th>";
            }
            echo "</tr></thead><tfoot><tr>";
            for($i=0; $i<count($Titulos); $i++){
                echo "<th>".$Titulos[$i]."</th>";
            }
            echo "</tr></tfoot><tbody>";

     for($i=0; $i<count($Datos); $i++){
        $bandera = $Datos[$i]->$Columnas[0];
            echo "<tr>";
                echo "<td>".$Columnas[0]."</td>";
                echo "<td>".$Columnas[0]."</td>";
                echo "<td>".$Columnas[0]."</td>";
                echo "<td>".$Columnas[0]."</td>";
                echo "<td>".$Columnas[0]."</td>";
                echo "<td>".$Columnas[0]."</td>";
                echo "<td>".$Columnas[0]."</td>";
                echo "<td>".$Columnas[0]."</td>";
            echo "</tr>";
         /*
        if($i==0){
            echo "<tr><td><H4>".$Datos[$i]->$Columnas[1]."</H4></td><td></td><td></td><td></td><td></td></tr>";
            $ConceptoDivision = $bandera;
        }else if($bandera¡==$ConceptoDivision){
            echo "<tr><td></td><td>TOTAL</td><td><H4>".$Datos[$i]->$Columnas[$j]."</H4></td></tr>";
            echo "<tr><td><H4>".$Datos[$i]->$Columnas[1]."</H4></td><td></td><td></td></tr>";
            $ConceptoDivision = $bandera;
        } else{
            echo "<tr>";
            $Valor1 = number_format($Datos[$i]->$Columnas[7], 2, ',', ' ');
            echo "<td>".$Datos[$i]->$Columnas[2]."</td><td class='text-right'>".$Datos[$i]->$Columnas[7]."</td><td></td>";
            $Valor2 = $Datos[$i]->$Columnas[7] + $Datos[$i]->$Columnas[6];
            $Suma = $Suma + $Datos[$i]->$Columnas[6];
            echo "<td class='text-right'>".number_format($Valor2, 2, ',', ' ')."</td><td></td>";
            echo "</tr>";
            $ConceptoDivision = $bandera;
        }
         */
        $ConceptoDivision = $Datos[$i]->$Columnas[0];
        
     } 

      echo "</tbody></table></div>";
      echo number_format($Suma, 2, ',', ' ');

?>

    <script type="text/javascript"> 
        
        $(document).ready(function() {
            var table = $('#grid').DataTable({
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
                        customize: function ( doc ) {
                            // Splice the image in after the header, but before the table
                            doc.content.splice( 1, 0, {
                                
                                alignment: 'center',
                            } );
                            // Data URL generated by http://dataurl.net/#dataurlmaker
                        },
                        filename: 'GridN',
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
                        filename: 'GridN',
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
                        message: 'PDF creado desde el sistema\n en linea del tayco.',
                        text: 'XLS',
                        filename: 'GridN',
                        extension: '.xlsx', 
                        exportOptions: {
                            columns: ':visible',
                            modifier: {
                                page: 'all'
                            }
                        }
                    },
                    {
                        extend: 'print',
                        message: 'PDF creado desde el sistema\n en linea del tayco.',
                        text: 'Imprimir',
                        exportOptions: {
                            stripHtml: false,
                            modifier: {
                                page: 'all'
                            }
                        }
                    },
                ],
                "pagingType": "full_numbers",
                "lengthMenu": [[-1], ["Todo"]],
                "language": {
                    "sProcessing":    "Procesando...",
                    "sLengthMenu":    "Mostrar _MENU_ registros",
                    "sZeroRecords":   "No se encontraron resultados",
                    "sEmptyTable":    "Ningún dato disponible en esta tabla",
                    "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":   "",
                    "sSearch":        "Buscar:",
                    "sUrl":           "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":    "Último",
                        "sNext":    "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },/*
                scrollY: 300,
                scrollX: true,*/
                "columnDefs": [
                    { "visible": false, "targets": 2 }
                ],
                "order": [[ 2, 'asc' ]],
                "displayLength": 25,
                "drawCallback": function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;

                    api.column(2, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq( i ).before(
                                '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                            );

                            last = group;
                        }
                    } );
                }
            } );

            // Order by the grouping
            $('#grid tbody').on( 'click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
                    table.order( [ 2, 'desc' ] ).draw();
                }
                else {
                    table.order( [ 2, 'asc' ] ).draw();
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