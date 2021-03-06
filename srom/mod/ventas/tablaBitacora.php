<?php include("../../funciones.php");

try{ 
    
    if ($_POST){    
        ini_set("soap.wsdl_cache_enabled", "0");
        $Empresa = $_POST["CmbEmpresa"];
        $De = $_POST["Fini"];
        $A =  $_POST["Ffin"]; 
        $user =  $_POST["CmbVENDEDORES"]; 
        
        $dDe = strtotime($De);
        $newformat1 = date('Y-m-d',$dDe);
       
        $dA = strtotime($A);
        $newformat2 = date('Y-m-d',$dA);
        
        //parametros de la llamada
        $parametros = array();
        $parametros['sId_Vendedor'] = $user;
        $parametros['dFechaIni'] = $newformat1;
        $parametros['dFechaFin'] = $newformat2;
       
        //ini_set("soap.wsdl_cache_enabled", "0");
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->Bitacora_Vendedores($parametros);
        $xml = $result->Bitacora_VendedoresResult->any;

        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
      // echo $xml;
    }
  else{}
} 
catch(SoapFault $e){
 var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' width='100%' ></table></div>";

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
        console.log(datos);
$Columnas = Array("Vendedor","Cliente","Fecha","hra Inicio","hra Fin","Duracion","Comentarios","Observaciones");//COLUMNAS GRID
 $(document).ready(function() {
         var table = $('#grid').DataTable({
            data:datos,
            columns: [
                { data: 'Vendedor' },
                { data: 'Cliente' },
                { data: 'Fecha' },
                { data: 'hraInicio' },
                { data: 'hraFin' },
                { data: 'duracion' },
                { data: 'comentarios' },
                { data: 'observaciones' }
            ],
            columnDefs: [
                { 'title': 'Vendedor', className: "text-left", 'targets': 0},
                { 'title': 'Cliente', className: "text-left", 'targets': 1},
                { 'title': 'Fecha', className: "text-left", 'targets':2},
                { 'title': 'Hra Inicio', className: "text-left", 'targets': 3},
                { 'title': 'Hra Fin', className: "text-left", 'targets': 4},
                { 'title': 'Duracion', className: "text-left", 'targets': 5},
                { 'title': 'Comentarios', className: "text-left", 'targets': 6},
                { 'title': 'Observaciones', className: "text-left", 'targets': 7}
            ],
            'createdRow': function ( row, data, index ) {
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
                    filename: 'ASISTENCIAS',
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
                    filename: 'ASISTENCIAS',
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
                    filename: 'ASISTENCIAS',
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
            'scrollY':        '60vh',
            'scrollCollapse': true,
            'paging':         false
        } );
    } );
    </script>
            
