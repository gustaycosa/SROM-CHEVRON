<?php include("../../funciones.php");

ini_set("soap.wsdl_cache_enabled", "0");

try{ 
    $CveBusqueda =  $_POST["TxtCliente"]; 
    //parametros de la llamada
    $parametros = array();
    $parametros['CveBusqueda'] = $CveBusqueda;
    //ini_set("soap.wsdl_cache_enabled", "0");
    //Invocación al web service
    $WS = new SoapClient($WebService, $parametros);
    //recibimos la respuesta dentro de un objeto
    $result = $WS->MuestraClientes($parametros);
    $xml = $result->MuestraClientesResult->any;
    $obj = simplexml_load_string($xml);
    $Datos = $obj->NewDataSet->Table;
    
} catch(SoapFault $e){
  var_dump($e);
}

echo '<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Seleccionar cliente</h4>
      </div>
      <div class="modal-body">';
echo "<table id='gridpop' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' width='100%'><thead><tr>"; 
	  	
 echo "</tr></tfoot><tbody>";
echo "</tbody></table>";
    echo '</div>
        </div>
      </div>
    </div>';

	$arreglo = [];
	for($i=0; $i<count($Datos); $i++){
		$arreglo[$i]=$Datos[$i];
	}

?>

     <script type="text/javascript"> 
        var datos = <?php echo json_encode($arreglo);?> ;

   $(document).ready(function() {
         var table = $('#gridpop').DataTable({
            data:datos,
            columns: [
                { data: 'ID_CLIENTE' },
                { data: 'NOMBRE' },
                { data: 'RFC' }
            ],
            columnDefs: [
                { 'title': 'ID',className: "text-left", 'targets': 0},
                { 'title': 'NOMBRE', className: "text-left", 'targets': 1},
                { 'title': 'RFC', className: "text-left", 'targets': 2}
            ],
            'createdRow': function ( row, data, index ) {
                $(row).attr({ id:data.ID_CLIENTE});
                $(row).addClass('Seleccionado');
            },  
            fixedHeader: true,          
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
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
                },
            }
 
        } );
    } );
    </script>