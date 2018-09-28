<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        //$Empresa = $_POST["CmbEmpresa"];
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
        //
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
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' width='100%' ><tfoot><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tfoot></table></div>";

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
                { 'title': 'DIVISION', 'width':'50px', className: "text-left", 'targets': 0},
                { 'title': 'DEPTO', 'width':'50px', className: "text-left", 'targets': 1},
                { 'title': 'FAMILIA', 'width':'50px', className: "text-left", 'targets': 2},
                { 'title': 'DESCRIPCION', 'width':'50px', className: "text-left", 'targets': 3},
                { 'title': 'SALDO INI ALM', 'width':'50px', className: "text-right", 'targets': 4},
                { 'title': 'TOTAL ENTRADAS', 'width':'50px', className: "text-right", 'targets': 5},
                { 'title': 'TOTAL SALIDAS', 'width':'50px', className: "text-right", 'targets': 6},
                { 'title': 'SALDO INI CONTA', 'width':'50px', className: "text-right", 'targets': 7},
                { 'title': 'DEBE', 'width':'50px', className: "text-right", 'targets': 8},
                { 'title': 'HABER', 'width':'50px', className: "text-right", 'targets': 9},
                { 'title': 'SALDO FIN CONTA', 'width':'50px', className: "text-right", 'targets': 10},
                { 'title': 'DIFERENCIA', 'width':'50px', className: "text-right", 'targets': 11}
            ],
            'createdRow': function ( row, data, index ) {
//                $(row).attr({ id:data.Id_Maquinaria});
//                $(row).addClass('maquinaria');
//                $(row).children("td.img_maq").css('background', 'url("images/'+data.Id_Maquinaria+'.jpg") center no-repeat / cover');
//                $(row).children("td.img_maq").css('height', '150px');
//                $(row).children("td.img_maq").css('width', '150px');
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
                .column( 10 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_variac.column( 10 ).footer() ).html('$'+ total_variac.toFixed(2) );
           
            //===========================================================================
            total_mesant = api_mesant
                .column( 11 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_mesant.column( 11 ).footer() ).html('$'+ total_mesant.toFixed(2) );
           
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