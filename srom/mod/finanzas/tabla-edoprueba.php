<?php include("../../funciones.php");

//require_once('lib/nusoap.php');
include("../../funciones.php"); 
//ini_set("soap.wsdl_cache_enabled", "0");

$Columnas = array("Id_ConceptoCtb","ConceptoCtb","Mes_Actual","Mes_Anterior","Variacion","Acumulado_ene","Prom_mensual","Ingresos_gen","Util_per_generada","Ano_Act","Ano_Ant","TF");
$titulos = array("Id","CONCEPTO CONTABLE","MES ACTUAL","MES ANTERIOR","VARIACION","ACUMULADO ENERO","PROMDERIO MENSUAL","INGRESOS GENERADOS","UTILIDAD/PERDIDA","AÑO ACTUAL","AÑO ANTERIOR","TF");

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
        $result = $WS->edogastostaller($parametros);
        $xml = $result->edogastostallerResult->any;
        //$result = $WS->edogastostaller($parametros);
        //$xml = $result->edogastostallerResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    $r = "<div class='table-responsive'>
        <table id='grid' class='table table-bordered table-condensed display compact nowrap' cellspacing='0' width='100%' style='white-space: nowrap;'><thead><tr>".
        
                "<th>".$titulos[1]."</th>".
                "<th>".$titulos[2]."</th>".
                "<th>".$titulos[3]."</th>".
                "<th>".$titulos[4]."</th>".
                "<th>".$titulos[5]."</th>".
                "<th>".$titulos[6]."</th>".
                "<th>".$titulos[7]."</th>".
                "<th>".$titulos[8]."</th>".
                "<th>".$titulos[9]."</th>".
                "<th>".$titulos[10]."</th>".
                "<th>".$titulos[11]."</th>".
                "</tr></thead>".
/*               "</tr></thead><tfoot><tr>".
                 "<th>".$titulos[1]."</th>".
                 "<th>".$titulos[2]."</th>".
                 "<th>".$titulos[3]."</th>".
                 "<th>".$titulos[4]."</th>".
                 "<th>".$titulos[5]."</th>".
                 "<th>".$titulos[6]."</th>".
                 "<th>".$titulos[7]."</th>".
                 "<th>".$titulos[8]."</th>".
                 "<th>".$titulos[9]."</th>".
                 "<th>".$titulos[10]."</th>".        
             "</tr></tfoot><tbody>";*/
/*
     for($i=0; $i<count($Datos); $i++){
         //$fila = $Datos[$i]->$Columnas[6];

       
         $fila = $Datos[$i]->$Columnas[11];

         $r = $r."<tr>";

         if($fila=="T1"){
            $r = $r."<td class='t1'>".$Datos[$i]->$Columnas[0]."</td>".
             "<td class='t1'>".$Datos[$i]->$Columnas[1]."</td>".
             "<td class='t1'>".$Datos[$i]->$Columnas[2]."</td>".
             "<td class='t1'>".$Datos[$i]->$Columnas[3]."</td>".
             "<td class='t1'>".$Datos[$i]->$Columnas[4]."</td>".
             "<td class='t1'>".$Datos[$i]->$Columnas[5]."</td>".
             "<td class='t1'>".$Datos[$i]->$Columnas[6]."</td>".
             "<td class='t1'>".$Datos[$i]->$Columnas[7]."</td>".
             "<td class='t1'>".$Datos[$i]->$Columnas[8]."</td>".
             "<td class='t1'>".$Datos[$i]->$Columnas[9]."</td>".
             "<td class='t1'>".$Datos[$i]->$Columnas[10]."</td>".
             "<td class='t1'>".$Datos[$i]->$Columnas[11]."</td>";
         }
         if($fila=="T2"){
             $r = $r."<td class='t2'>".$Datos[$i]->$Columnas[0]."</td>".
             "<td class='t2'>".$Datos[$i]->$Columnas[1]."</td>".
             "<td class='t2'>".$Datos[$i]->$Columnas[2]."</td>".
             "<td class='t2'>".$Datos[$i]->$Columnas[3]."</td>".
             "<td class='t2'>".$Datos[$i]->$Columnas[4]."</td>".
             "<td class='t2'>".$Datos[$i]->$Columnas[5]."</td>".
             "<td class='t2'>".$Datos[$i]->$Columnas[6]."</td>".
             "<td class='t2'>".$Datos[$i]->$Columnas[7]."</td>".
             "<td class='t2'>".$Datos[$i]->$Columnas[8]."</td>".
             "<td class='t2'>".$Datos[$i]->$Columnas[9]."</td>".
             "<td class='t2'>".$Datos[$i]->$Columnas[10]."</td>".
             "<td class='t2'>".$Datos[$i]->$Columnas[11]."</td>";
         }
         if($fila=="T3"){
             $r = $r."<td class='t3'>".$Datos[$i]->$Columnas[0]."</td>".
             "<td class='t3'>".$Datos[$i]->$Columnas[1]."</td>".
             "<td class='t3'>".$Datos[$i]->$Columnas[2]."</td>".
             "<td class='t3'>".$Datos[$i]->$Columnas[3]."</td>".
             "<td class='t3'>".$Datos[$i]->$Columnas[4]."</td>".
             "<td class='t3'>".$Datos[$i]->$Columnas[5]."</td>".
             "<td class='t3'>".$Datos[$i]->$Columnas[6]."</td>".
             "<td class='t3'>".$Datos[$i]->$Columnas[7]."</td>".
             "<td class='t3'>".$Datos[$i]->$Columnas[8]."</td>".
             "<td class='t3'>".$Datos[$i]->$Columnas[9]."</td>".
             "<td class='t3'>".$Datos[$i]->$Columnas[10]."</td>".
             "<td class='t3'>".$Datos[$i]->$Columnas[11]."</td>";
         }
         if($fila=="N"){
             $r = $r."<td>".$Datos[$i]->$Columnas[0]."</td>".
             "<td>".$Datos[$i]->$Columnas[1]."</td>".
             "<td>".$Datos[$i]->$Columnas[2]."</td>".
             "<td>".$Datos[$i]->$Columnas[4]."</td>".
             "<td>".$Datos[$i]->$Columnas[4]."</td>".
             "<td>".$Datos[$i]->$Columnas[5]."</td>".
             "<td>".$Datos[$i]->$Columnas[6]."</td>".
             "<td>".$Datos[$i]->$Columnas[7]."</td>".
             "<td>".$Datos[$i]->$Columnas[8]."</td>".
             "<td>".$Datos[$i]->$Columnas[9]."</td>".
             "<td>".$Datos[$i]->$Columnas[10]."</td>".
             "<td>".$Datos[$i]->$Columnas[11]."</td>";
         }
         $r = $r."</tr>";
     } 
        //$ConceptoDivision = $Datos[$i]->$Columnas[0]; 
*/
      $r = $r."</table></div>";
      echo $r;
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
                    { data: "Mes_Actual" },
                    { data: "Mes_Anterior" },
                    { data: "Variacion" },
                    { data: "Acumulado_ene" },
                    { data: "Prom_mensual" },
                    { data: "Ingresos_gen" },
                    { data: "Util_per_generada" },
                    { data: "Ano_Act" },
                    { data: "Ano_Ant" },
                    { data: "TF" }
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
                        filename: '".$sNombre."',
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
                        filename: '".$sNombre."',
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
                        filename: '".$sNombre."',
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
                'scrollY': '50vh',
                'scrollX': true,
                'paging': false,
                'responsive': true,
            } );
            
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