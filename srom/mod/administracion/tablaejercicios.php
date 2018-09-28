<?php include("../../funciones.php");

$ColumnasDet = array("DIVISION","DEPTO","FAMILIA","DESCRIPCION","SALDO_INI_ALMACEN","E_RECPED","E_TREC_PEDIDOTALLER","E_TREC_REFACCIONES","E_ACOND","E_CANC","E_DEVOLUCION","E_FACTURA","E_GARANTIA","E_DEVPRO","S_DEVOLUCION","S_FACTURA","S_GARANTIA","S_TENV_PEDIDOTALLER","S_TENV_REFACCIONES","TOTAL_ENTRADAS","TOTAL_SALIDAS","SALDO_INI_CONTA","DEBE","HABER");
//$De = date('Y-m-d');
//$A = date('Y-m-d');
try{ 
    
    if ($_POST){
        
        $Empresa = $_POST["CmbEmpresa"];
        $Sucursal = $_POST["Cmbsucursales"];
        $Ejercicio =  $_POST["TxtEjercicio"]; 
        $Mes =  $_POST["TxtMes"]; 
        $Detalle =  $_POST["TxtDetalle"]; 

        
        //parametros de la llamada
        $parametros = array();
        $parametros['sId_Empresa'] = $Empresa;
        $parametros['sId_Sucursal'] = $Sucursal;
        $parametros['sEjercicio'] = $Ejercicio;
        $parametros['sMes'] = $Mes;
        //ini_set("soap.wsdl_cache_enabled", "0");
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->SP_COMPULSA_ALM_CONTA_A($parametros);
        $xml = $result->SP_COMPULSA_ALM_CONTA_AResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
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
                { data: 'DIVISION' },
                { data: 'DEPTO' },
                { data: 'FAMILIA' },
                { data: 'DESCRIPCION' },
                { data: 'SALDO_INI_ALMACEN' },
                { data: 'TOTAL_ENTRADAS' },
                { data: 'TOTAL_SALIDAS' },
                { data: 'SALDO_INI_CONTA' },
                { data: 'DEBE' },
                { data: 'HABER' },
                { data: 'SALDO_FIN_CONTA' },
                { data: 'DIFERENCIA' }
            ],
            columnDefs: [
                { 'title': 'DIVISION', className: "text-left", 'targets': 0},
                { 'title': 'DEPTO', className: "text-left", 'targets': 1},
                { 'title': 'FAMILIA', className: "text-left", 'targets': 2},
                { 'title': 'DESCRIPCION', className: "text-left", 'targets': 3},
                { 'title': 'SALDO INI ALM', className: "text-left", 'targets': 4},
                { 'title': 'TOTAL ENTRADAS', className: "text-left", 'targets': 5},
                { 'title': 'TOTAL SALIDAS', className: "text-left", 'targets': 6},
                { 'title': 'SALDO INI CONTA', className: "text-left", 'targets': 7},
                { 'title': 'DEBE', className: "text-left", 'targets': 8},
                { 'title': 'HABER', className: "text-left", 'targets': 9},
                { 'title': 'SALDO FIN CONTA', className: "text-left", 'targets': 10},
                { 'title': 'DIFERENCIA', className: "text-left", 'targets': 11}
            ],
            'createdRow': function ( row, data, index ) {
                $(row).attr({ id:data.Id_Maquinaria});
                $(row).addClass('maquinaria');
                $(row).children("td.img_maq").css('background', 'url("images/'+data.Id_Maquinaria+'.jpg") center no-repeat / cover');
                $(row).children("td.img_maq").css('height', '150px');
                $(row).children("td.img_maq").css('width', '150px');
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
                    filename: 'contavsalm',
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
                    filename: 'contavsalm',
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
                    filename: 'contavsalm',
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