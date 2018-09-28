<?php

if (!isset($_SESSION)) {
  session_start();
}
else
{
	session_destroy();
}

$usuario = $_POST['usuario'];
$contrasena = $_POST['password'];



$Columnas = array("Id_Usuario","nombre","Email","id_empresa","Id_Perfil","Perfil","TipoPerfil","Id_Grupo","Grupo","id_Vendedor");

//parametros de la llamada
$parametros = array();
$parametros['User'] = $usuario;
$parametros['Pass'] = $contrasena;
//Invocación al web service
$WS = new SoapClient($WebService, $parametros);
//recibimos la respuesta dentro de un objeto

$result = $WS->LoginPortal($parametros);
$xml = $result->LoginPortalResult->any;
$obj = simplexml_load_string($xml);
$Datos = $obj->NewDataSet->Table;

$valido = $Datos[0]->$Columnas[0];
$tipo = $Datos[0]->$Columnas[3];
$Id_Usuario = $Datos[0]->$Columnas[0];
$perfil = $Datos[0]->$Columnas[5];
$tipoperfil = $Datos[0]->$Columnas[6];

 if ($valido==0) {
  echo '<script language="JavaScript"> alert("Usuario '.$usuario.' no existe, intente de nuevo.");</script>';
  echo '<script language= JavaScript>self.location = "http://www.taycosa.mx"</script>';
  //echo $valido;
 }
 else
 {
    echo '<script language="JavaScript"> alert("Bienvenido '.$usuario.'");</script>';
	$_SESSION['NombreUsuario'] = $Datos[0]->$Columnas[1];
	$_SESSION['Email'] = $Datos[0]->$Columnas[2];
    $_SESSION['Empresa'] = $Datos[0]->$Columnas[5];
	$_SESSION['Autenticado'] ='SI';
	$_SESSION['Id_ventas'] = $Datos[0]->$Columnas[5];
    $ventas = $Datos[0]->$Columnas[5];
    include("principal3.php");
 }
?>