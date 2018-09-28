
<?php include("../../funciones.php");       
try{
if ($_POST){
ini_set("soap.wsdl_cache_enabled", "0");
$empresa = 'TAYCOSA';
$tipo = $_POST["radpag"];
$moneda = $_POST["CmbMoneda"];
$fini = $_POST["Fini"];
$ffin = $_POST["Ffin"];

$parametros = array();
$parametros["empresa"] = $empresa;
$parametros["tipo"] = $tipo;
$parametros["moneda"] = $moneda;
$parametros["fini"] = $fini;
$parametros["ffin"] = $ffin;
$WS = new SoapClient($WebService, $parametros);
$result = $WS->pagosfact($parametros);
$xml = $result->pagosfactResult->any;
$obj = simplexml_load_string($xml);
$Datos = $obj->NewDataSet->Table;
}
else{}
} catch(SoapFault $e){
var_dump($e);
}
echo "<div class='table-responsive'>
            <table id='grid' class='table table-bordered 
            table-condensed table-hover display compact nowrap' cellspacing='0' style='width:100%;'><tfoot>
<th></th><th></th><th></th><th></th><th></th><th></th>
        </tfoot>
            </table></div>"; 
                $arreglo = [];
                for($i=0; $i<count($Datos); $i++){
                    $arreglo[$i]=$Datos[$i];
                }

            ?>
        


<script type="text/javascript"> 

var datos = <?php echo json_encode($arreglo);?>;
 $(document).ready(function() {
var table = $('#grid').DataTable({
data:datos,
columns: [ 
{ data: 'ORDEN' },
{ data: 'FACTURA' },
{ data: 'FECHAFACTURA' },
{ data: 'PAGO' },
{ data: 'FECHAPAGO' },
{ data: 'TOTALFACTURA' },
{ data: 'TOTALPAGO' },
{ data: 'SALDOFACTURA' },
], 
columnDefs: [ 
{ "visible": false, "targets": 0},
{ 'title': 'FACTURA', 'width': '60px', 'className': 'text-left', 'targets':1},
{ 'title': 'FECHA FACTURA', 'width': '60px', 'className': 'text-left', 'targets':2},
{ 'title': 'ABONO', 'width': '60px', 'className': 'text-left', 'targets':3},
{ 'title': 'FECHA PAGO', 'width': '60px', 'className': 'text-right', 'targets':3},
{ 'title': 'TOTAL FACTURA', 'width': '60px', 'className': 'text-right', 'targets':5},
{ 'title': 'TOTAL PAGO', 'width': '60px', 'className': 'text-right', 'targets':6},
{ 'title': 'SALDO MOVIMIENTO', 'width': '60px', 'className': 'text-right', 'targets':7},
], 
"createdRow": function ( row, data, index ) { 
    //$(row).attr({ id:data.Id_ConceptoCtb});
},
dom: 'lfBrtp',
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
filename:'pagosfact_2018-9-5',
extension: '.pdf',
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
filename: 'pagosfact_2018-9-5',
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
'sProcessing': 'Procesando...',
'sLengthMenu': 'Mostrar _MENU_ registros',
'sZeroRecords': 'No se encontraron resultados',
'sEmptyTable': 'Ningún dato disponible en esta tabla',
'sInfo': 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
'sInfoEmpty': 'Mostrando registros del 0 al 0 de un total de 0 registros',
'sInfoFiltered': '(filtrado de un total de _MAX_ registros)',
'sInfoPostFix': '',
'sSearch': 'Buscar:',
'sUrl': '',
'sInfoThousands': ',',
'sLoadingRecords': 'Cargando...',
'oPaginate': {
'sFirst': 'Primero',
'sLast': 'Último',
'sNext': 'Siguiente',
'sPrevious': 'Anterior'
},
'oAria': {
'sSortAscending': ': Activar para ordenar la columna de manera ascendente',
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
'responsive':true
} );
/*table.on( 'search.dt', function () {
    $('#ejemplo').html( 'Currently applied global search: '+table.search() );
} );*/
//     $('#ejemplo').on( 'keyup', function(){
//        table.search( this.value ).draw();
//    } );
     
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
});
    
</script>