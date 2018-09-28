
<!DOCTYPE html>
<html class="no-js">

<?php include("head.php"); ?>
<?php echo Cabecera('Reporte de edos. financieros'); ?>
<?php
$TituloPantalla = 'Reporte de edos. financieros';    

$WebService="http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl";

$Columnas = array("Modulo","Grupo","forma","Descripcion","InsertarDatos","ActualizarDatos","EliminarDatos","LeerDatos");//COLUMNAS 
    
$parametros = array();
$parametros['sPerfil'] = $perfil ;//'JEFE_VENTAS';
$parametros['sModulo'] = 'DWH';
$parametros['sTipoPerfil'] = $tipoperfil ;//'INCLUYENTE';
$WS = new SoapClient($WebService, $parametros);
$result = $WS->AccesosMenu($parametros);
$xml = $result->AccesosMenuResult->any;
$obj = simplexml_load_string($xml);
$Datos = $obj->NewDataSet->Table;
    
    

    echo '<body style="background:url(images/back01.gif) center center no-repeat fixed white;background-size:cover;">
        <div id="navmenu">
          <ul class="nav navmenu-nav" style="background:black;">';
    $BANDERA = '';

    for($i=0; $i<count($Datos); $i++){
            if(strcmp($Datos[$i]->$Columnas[1],$BANDERA) !== 0 && $i==0 ){
		      echo '<li><a id="'.$Datos[$i]->$Columnas[1].'">'.$Datos[$i]->$Columnas[1].'</a><ul class="'.$Datos[$i]->$Columnas[1].'">';
                echo '<li><a id="'.$Datos[$i]->$Columnas[2].'" target="'.$Datos[$i]->$Columnas[2].'" class="list-group-item">'.$Datos[$i]->$Columnas[3].'</a></li>'; 
                $BANDERA = $Datos[$i]->$Columnas[1];
            }elseif( strcmp($Datos[$i]->$Columnas[1],$BANDERA) !== 0){
                echo '</ul></li><li id="a'.$i.'"><a id="'.$Datos[$i]->$Columnas[1].'" type="button">
                    '.$Datos[$i]->$Columnas[1].'</a><ul class="'.$Datos[$i]->$Columnas[1].'">';
                echo '<li><a id="'.$Datos[$i]->$Columnas[2].'" target="'.$Datos[$i]->$Columnas[2].'" class="list-group-item">'.$Datos[$i]->$Columnas[3].'</a></li>'; 
                $BANDERA = $Datos[$i]->$Columnas[1];
            }else{
                echo '<li id="'.$i.'"><a id="'.$Datos[$i]->$Columnas[2].'" target="'.$Datos[$i]->$Columnas[2].'" class="list-group-item">'.$Datos[$i]->$Columnas[3].'</a></li>'; 
            }
    }
				echo '   
			</ul></li>
            <li><a href="salir.php" type="button" class="list-item">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Cerrar sesión
            </a></li>
          </ul>';

        echo '</div>
        <div>
          <button  id="edo" target="edo"  type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".navmenu" data-canvas="body" style=" background: #337ab7; left: 0px; position: fixed; z-index: 3;">
            <span class="icon-bar" style="background:white;"></span>
            <span class="icon-bar" style="background:white;"></span>
            <span class="icon-bar" style="background:white;"></span>
          </button>
          <div id="divblock" style="    background: gray;
    width: 100%;
    height: 100%;
    position: absolute;
    display: none;
    opacity: 0.5;
    z-index: 2;"></div>
        </div>';
        echo '<div id="principal" class="container-fluid"></div></body>';
echo'<style>
::selection { background: transparent;}
::-moz-selection { background: transparent; }
</style>';
        include("barratareas.php");    
        echo Script();
    
 ?>
    <script type="text/javascript"> 
        var contador = 0;
        document.addEventListener('touchmove', function(e) {
            e.preventDefault();
            var touch = e.touches[0];
            //alert(touch.pageX + " - " + touch.pageY);
        }, false);
        
        $(document).on('click touchstart','.close',function(){
            //id del item menu
            var ID = $( this ).attr("name");
            $( "#navbar #"+ID ).remove();
            $( "#ifm"+ID ).remove();
        });
        
        $(document).on('click touchstart','.vna-act',function(){
            //id de ventana
            var ids = $( this ).attr("id");
            //id de iframe a partir de ventana
            var idcomplete = '#ifm'+ids;
            //cambiar clase de abierto a cerrado a iframe
            $("#principal iframe").hide();
            //cambiar clase de activo a inactivo a ventana
            $("#navbar a").attr('class').replace('vna-act', 'vna-min');
            //cambiar clase de activo a inactivo a ventana
            $(this).removeClass( 'vna-act' ).addClass( 'vna-min' );
            $( idcomplete ).hide();
        });
        
        $(document).on('click touchstart','.vna-min',function(){
            //id de ventana
            var ids = $( this ).attr("id");
            //id de iframe a partir de ventana
            var idcomplete = '#ifm'+ids;
            //cambiar clase de abierto a cerrado a iframe
            //cambiar clase de activo a inactivo a ventana
            //$("#navbar a").attr('class').replace('vna-act', 'vna-min');
			$("#navbar > a").removeClass('vna-act').addClass('vna-min');
			$("#principal iframe").hide();
			$(this).removeClass( 'vna-min' ).addClass( 'vna-act' );
            //cambiar clase de activo a inactivo a ventana
            $( idcomplete ).show();
        });
        
        $(document).on('click touchstart','.list-group-item',function(){
            var modulo = $(this).parent().parent().attr('class').toLowerCase();
            var titulomin = $(this).text();
			$("#principal iframe").hide();
			$("#navbar > a").removeClass('vna-act').addClass('vna-min');
            var IDFRM = $( this ).attr("id");
            contador = contador + 1;
            var modal2 = "<iframe id='ifm"+IDFRM+"_"+contador+"' name='"+IDFRM+"' src='mod/"+modulo+"/"+IDFRM+".php?e="+<?php echo $Id_Usuario;?>+"&a=taycosa"+"' frameborder='0' class='col-sm-12 col-xs-12 col-md-12 col-lg-12'></iframe>";
            var ventana = "<a id='"+IDFRM+"_"+contador+"' class='vna-act'>"+titulomin+"<button class='close' name='"+IDFRM+"_"+contador+"'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button></a>";
            $( "#principal" ).append( modal2 );
            $( "#navbar" ).append( ventana );
            $("#"+IDFRM+"_"+contador).attr('class').replace('vna-min', 'vna-act');
            $( "#ifm"+IDFRM+"_"+contador ).addClass('ifmOpen');
            
            $("#navmenu").hide();
            $("#navmenu").css("left","-300px");
            $("#divblock").hide();
            $("#edo").css("left","0px");
            //$("#principal,#navbar").removeClass('darkness');
        });
        
        $(document).on('click touchstart','.list-item',function(){
            
			$("#principal iframe").hide();
			$("#navbar > a").removeClass('vna-act').addClass('vna-min');
            var IDFRM = $( this ).attr("id");
            var ID = $( this ).attr("id");
            var SRC = $( this ).attr("ref");
            contador = contador + 1;
            var modal2 = "<iframe id='ifm"+IDFRM+"' name='"+IDFRM+"' src='"+IDFRM+".php?e="+<?php echo $Id_Usuario;?>+"&a=taycosa"+"' frameborder='0' class='col-sm-12'></iframe>";
            var ventana = "<a id='"+IDFRM+"' class='vna-act'>"+IDFRM+"<button class='close' name='"+IDFRM+"_"+contador+"'>x</button></a>";
            $( "#principal" ).append( modal2 );
            $( "#navbar" ).append( ventana );
            $("#"+IDFRM).attr('class').replace('vna-min', 'vna-act');
            $( "#ifm"+IDFRM ).addClass('ifmOpen');
            
            $("#navmenu").hide();
            $("#navmenu").css("left","-300px");
            $("#divblock").hide();
            $("#edo").css("left","0px");
            //$("#principal,#navbar").removeClass('darkness');
        });

        $(document).on('click touchstart','ul.nav li a',function(){
			var MenuItem = $( this ).attr("id");
			if ($("."+MenuItem).is(":hidden")) {
				$("ul.nav li ul").hide();
				$("."+MenuItem).show();
			}else{
				$("."+MenuItem).hide();
			}
        });
        
        $(document).on('click touchstart','#principal',function(){
                $("#navmenu").hide();
                $("#navmenu").css("left","-300px");
                $("#edo").css("left","0px");
                //$("#principal,#navbar").removeClass('darkness');
        });
        
        $(document).on('click touchstart','#divblock',function(){
                $("#navmenu").hide();
                $("#navmenu").css("left","-300px");
                $("#divblock").hide();
                $("#edo").css("left","0px");
                //$("#principal,#navbar").removeClass('darkness');
        });
        
        $(document).on('click touchstart','#edo',function(){
			if ($("#navmenu").is(":hidden")) {
                $("#navmenu").show();
                $("#divblock").show();
				$("#navmenu").css("left","0px");
                $("#edo").css("left","300px");
                //$("#principal,#navbar").addClass('darkness');
			}else{
                
                $("#navmenu").hide();
                $("#navmenu").css("left","-300px");
                $("#divblock").hide();
                $("#edo").css("left","0px");
                //$("#principal,#navbar").removeClass('darkness');
			}
        });
        
        $(document).ready(function() {

        } );

    </script>
    <script language="JavaScript" type="text/javascript">
        function show5(){
            if (!document.layers&&!document.all&&!document.getElementById)
            return
             var Digital=new Date()
             var hours=Digital.getHours()
             var minutes=Digital.getMinutes()
             var seconds=Digital.getSeconds()
             var dn="PM"
             if (hours<12)
             dn="AM"
             if (hours>12)
             hours=hours-12
             if (hours==0)
             hours=12
             if (minutes<=9)
             minutes="0"+minutes
             if (seconds<=9)
             seconds="0"+seconds
            myclock=hours+":"+minutes+":"
             +seconds+" "+dn
            if (document.layers){
            document.layers.liveclock.document.write(myclock)
            document.layers.liveclock.document.close()
            }
            else if (document.all)
            liveclock.innerHTML=myclock
            else if (document.getElementById)
            document.getElementById("liveclock").innerHTML=myclock
            setTimeout("show5()",1000)
        }
        window.onload=show5
     </script>
</html>