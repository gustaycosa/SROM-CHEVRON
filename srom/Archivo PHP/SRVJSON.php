<?php
header('content-type text/html charset=UTF-8/ISO-8859-1');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
require_once('cnx/claseConexcion.php');

function limpiarCaracteresEspeciales($string)
{

 $string = quitar_tildes($string);

 $string = str_replace('Ê','E', mb_convert_encoding($string, "UTF-8"));
	
 $string = str_replace('Ù','U', mb_convert_encoding($string, "UTF-8"));
	
 $string = htmlentities($string);

 $string = str_replace("&ntilde;", "#", ($string));
 // echo "<br>$busqueda<br>";

 $string = str_replace("&Ntilde;", "#", ($string));
	
 $string = str_replace("&Ecirc;", "E", ($string));

 $string = str_replace("&Ugrave;", "U", ($string)); 

 $string = preg_replace('/\&(.)[^;]*;/', '\\1', $string);

 $string = str_replace("'", "", $string);
 //$string = str_replace("#", "&Ntilde;", $string);

 //utf8_encode($string);
 return $string;
}

function quitar_tildes($cadena) {
	
	
$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹", "Ê");
$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","A","A","I","O","U","A","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E","E");
$texto = str_replace($no_permitidas, $permitidas ,$cadena);
return $texto;
}

function recuperarTiendas(){
	$sql = "SELECT  CODCIA,NOMCIACTO FROM IN400DB.FCOMPANIA WHERE STSTDA='S' AND  NOMCIACTO !='ALMACEN DE VINOS' AND NOMCIACTO !='SONY SHOP'";
	//echo "<br>$sql<br>";
	$objCnx = new conexion('PDO', 'PRO', $sql, null);
	$json=array();
	$json["status"]="01";
	$tiendas=array();
	$tienda=array();
	if($objCnx->cnx != false)
	  if($objCnx->selectSimple() != false)
		if(count($objCnx->arrResultado) > 0)
		{  $json["status"]="00";
		 	foreach($objCnx->arrResultado as $row){
				$tienda["CODTDA"]=trim($row["CODCIA"]);
				$tienda["NOMTDA"]=trim($row["NOMCIACTO"]);			
				array_push($tiendas,$tienda);
			}
		 $json["tiendas"]=$tiendas;
		 echo json_encode($json);
		}
}
function RecuperarLugares(){
	$CodigoPostal = isset($_REQUEST['codpos']) ? $_REQUEST['codpos'] : 0;
	$sql = "SELECT CODPAI_CPT,
(SELECT DSCLUG_CPT FROM WE400DB.FWEBCATPOS WHERE CODPAI_CPT=A.CODPAI_CPT  AND CODEDO_CPT = 0)AS DSCPAI_CPT,
CODEDO_CPT,
(SELECT DSCLUG_CPT FROM WE400DB.FWEBCATPOS WHERE CODPAI_CPT=A.CODPAI_CPT  AND CODEDO_CPT = A.CODEDO_CPT AND CODMNC_CPT=0 AND CODCIU_CPT=0) AS DSCEDO_CPT,
CODMNC_CPT,
(SELECT DSCLUG_CPT  FROM WE400DB.FWEBCATPOS WHERE CODPAI_CPT=A.CODPAI_CPT AND CODEDO_CPT = A.CODEDO_CPT AND CODMNC_CPT=A.CODMNC_CPT AND CODCIU_CPT=0 AND CODLUG_CPT=0) AS DSCMNC_CPT,
CODCIU_CPT,
(SELECT DSCLUG_CPT  FROM WE400DB.FWEBCATPOS WHERE CODPAI_CPT=A.CODPAI_CPT AND CODEDO_CPT = A.CODEDO_CPT AND CODMNC_CPT=0 AND CODCIU_CPT=A.CODCIU_CPT AND DSCABR_CPT ='')AS DSCCIU_CPT,
CODLUG_CPT,
DSCLUG_CPT
FROM WE400DB.FWEBCATPOS  AS A
WHERE CODPOS_CPT ='".$CodigoPostal."'";
	$objCnx = new conexion('PDO', 'PRO', $sql, null);
	$json=array();
	$json["status"]="01";
	$init=0;
	$lugares=array();
	$lugar=array();
	if($objCnx->cnx != false)
	  if($objCnx->selectSimple() != false)
		if(count($objCnx->arrResultado) > 0)
		{	$json["status"]="00";
		 	foreach($objCnx->arrResultado as $row){
				if($init==0){
				    $json["CODPAI"]=trim($row['CODPAI_CPT']);
					$json["DSCPAI"]=trim($row['DSCPAI_CPT']);	
				    $json["CODEDO"]=trim($row['CODEDO_CPT']);
					$json["DSCEDO"]=trim($row['DSCEDO_CPT']);
				    $json["CODMNC"]=trim($row['CODMNC_CPT']);
					$json["DSCMNC"]=trim($row['DSCMNC_CPT']);
				    $json["CODPOS"]=trim($CodigoPostal);	
				    $init++;
			    }
				$lugar["CODCIU"]=trim($row["CODCIU_CPT"]);
				$lugar["DSCCIU"]=trim($row["DSCCIU_CPT"]);
				$lugar["CODLUG"]=trim($row["CODLUG_CPT"]);
				$lugar["DSCLUG"]=limpiarCaracteresEspeciales(trim($row["DSCLUG_CPT"]));
				array_push($lugares,$lugar);
			}
		 $json["LUGARES"]=$lugares;
		}
	echo json_encode($json);		
}

    $opc = isset($_REQUEST['opc']) ? $_REQUEST['opc'] : 0;
	switch($opc){
		case 'recuperarTiendas':
			recuperarTiendas();
		break;
		case 'RecuperarLugares':
			RecuperarLugares();
		break;	
		default:
			echo 0;
		break;
	}
?>