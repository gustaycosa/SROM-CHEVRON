<?php include("../../funciones.php");

require_once('lib/nusoap.php');

ini_set("soap.wsdl_cache_enabled", "0");

$Columnas = array("Id_ReporteContable","ReporteContable","ConceptoCtb","FEB_2017","MAR_2017","ABR_2017","MAY_2017","JUN_2017");

//$De = date('Y-m-d');
//$A = date('Y-m-d');

$ConceptoDivision = '';
$Empresa = $_SESSION['Empresa'];
$Suma = 0;
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
        //$result = $WS->edoresultados_del($parametros);
        //$xml = $result->edoresultados_delResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact nowrap' cellspacing='0' width='100%' style='white-space: nowrap;'><thead><tr>"; 
                echo "<th>".$Columnas[2]."</th>";
                for($i=0; $i<23; $i++){
                    echo "<th>".$Columnas[3]."</th>";
                }
                //echo "<th>TOTALES</th>";
            echo "</tr></thead><tfoot><tr>";
                echo "<th>".$Columnas[2]."</th>";
                for($i=0; $i<23; $i++){
                    echo "<th>".$Columnas[3]."</th>";
                }
                //echo "<th>TOTALES</th>";
            echo "</tr></tfoot><tbody>";

     for($i=0; $i<count($Datos); $i++){
        $bandera = $Datos[$i]->$Columnas[0];
        if($i==0){
            
            echo "<tr><td><H4>".$Datos[$i]->$Columnas[1]."</H4></td><td></td><td></td>";
            echo "<td></td> <td></td> <td></td> <td></td> <td></td> ";
            echo "<td></td> <td></td> <td></td> <td></td> <td></td> ";
            echo "<td></td> <td></td> <td></td> <td></td> <td></td> ";
            echo "<td></td> <td></td> <td></td> <td></td> <td></td> ";
            echo "<td></td> </tr>";
            $ConceptoDivision = $bandera;
            
        }else{
            echo "<tr>";
            echo "<td>".$Datos[$i]->$Columnas[2]."</td><td class='text-right'>".$Datos[$i]->$Columnas[7]."</td>";
            $Valor = $Datos[$i]->$Columnas[7] + $Datos[$i]->$Columnas[6];
            $Suma = $Suma + $Datos[$i]->$Columnas[6];
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "<td class='text-right'>".number_format($Valor, 2, ',', ' ')."</td>";
            echo "</tr>";
            $ConceptoDivision = $bandera;
        }

        //$ConceptoDivision = $Datos[$i]->$Columnas[0];
        
     } 

      echo "</tbody></table></div>";
        //echo number_format($Suma, 2, ',', ' ');

?>

    <script type="text/javascript"> 
        
        $(document).ready(function() {
            var table = $('#grid').DataTable({
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
                                
                                alignment: 'center',
                                <?php include("ImgHeader.php"); ?>
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
                }/*,
                scrollY: 300,
                scrollX: true
                */
            } );
        } );

    </script>