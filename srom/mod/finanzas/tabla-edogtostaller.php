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

    echo "<div class='table-responsive'>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact nowrap' cellspacing='0' width='100%'><tfoot><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tfoot></table></div>"; 

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
                { data: 'ConceptoCtb' },
                { data: 'Mes_Actual' },
                { data: 'Mes_Anterior' },
                { data: 'Variacion' },
                { data: 'Acumulado_ene' },
                { data: 'Prom_mensual' },
                { data: 'Ingresos_gen' },
                { data: 'Util_per_generada' },
                { data: 'Ano_Act' },
                { data: 'Ano_Ant' }
            ],
            columnDefs: [
                { 'title': 'CONCEPTO', className: "text-left", 'targets': 0},
                { 'title': 'MES ACTUAL', className: "text-right", 'targets': 1},
                { 'title': 'MES ANTERIOR', className: "text-right", 'targets': 2},
                { 'title': 'VARIACION', className: "text-right", 'targets': 3},
                { 'title': 'ACUMULADO ENERO', className: "text-right", 'targets': 4},
                { 'title': 'PROMEDIO MENSUAL', className: "text-right", 'targets': 5},
                { 'title': 'INGRESOS GEN', className: "text-right", 'targets': 6},
                { 'title': 'UTIL/PER GEN', className: "text-right", 'targets': 7},
                { 'title': 'MES ACTUAL AÑO ANTERIOR', className: "text-right", 'targets': 8},
                { 'title': 'MES ANTERIOR AÑO ANT', className: "text-right", 'targets': 9}
            ],
            "createdRow": function ( row, data, index ) {
                $(row).attr({ id:data.Id_ConceptoCtb});
                $(row).addClass(data.REF);
                /*if ( data.TF == 'N1' ) {
                    $(row).addClass('N1');
                }
                else if ( data.TF == 'N2' ) {
                    $(row).addClass('N2');
                }
                else if ( data.TF == 'N3' ) {
                    $(row).addClass('N3');
                    $(row).hide();
                }
                else if ( data.TF == 'N4' ) {
                    $(row).addClass('N4');
                    $(row).hide();
                }
                else if ( data.TF == 'N5' ) {
                    $(row).addClass('N5');
                    $(row).hide();
                }
                else if ( data.TF == 'N' ) {
                    $(row).addClass('N');
                    $(row).hide();
                }*/
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

    $(function(){
        /*
        $('.N4').click(function() {                
            if ($('.N').css("display") != "none" ) {
                $('.N').hide(); 
            }else{
                $('.N').show(); 
            }
        });*/
        $('#grid tr').click(function() {
            var ids = $( this ).attr("id");
            if ($('.'+ids).css("display") != "none" ) {
                $('.'+ids).hide(); 
            }else{
                $('.'+ids).show(); 
            }
        });
    });
    </script>