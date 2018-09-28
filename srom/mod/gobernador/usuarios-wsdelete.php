<?php include("../../funciones.php");
if ($_POST){ 
    ini_set("soap.wsdl_cache_enabled", "0");
    
    echo $_SESSION['NombreUsuario'];
    
    $Cadena = 'XXX';
    $Id = $_POST["txtUsuario"];

    require_once('lib/nusoap.php');

    try{ 
        /*
        
        //parametros de la llamada
        $parametros = array();
        $parametros['iId'] = $Id;
        $parametros['sId_usuario_Fum'] = $UsuarioF;
        $parametros['Equipo'] = $Cadena;
        $parametros['Ip'] = $Cadena;
        $parametros['MAC'] = $Cadena;
        //Invocación al web service
        $WS = new SoapClient($WebService,$parametros);
        $result = $WS->UsuariosInsert($parametros);
        $Datos = $result->UsuariosInsertResult->string;

        var_dump($result);

        $valido = $Datos ;

        if ($valido=='0') {
            echo '<script language="JavaScript"> alert("Usuario no insertado.");</script>';
            echo $valido;
        }
        else{
            echo '<script language="JavaScript"> alert("Usuario insertado.");</script>';
            ini_set("soap.wsdl_cache_enabled", "0");
        }
        */

    } catch(SoapFault $e){
        var_dump($e);
    }

}
?>
