<?php include("../../funciones.php");
if ($_POST){ 
    ini_set("soap.wsdl_cache_enabled", "0");

    $Cadena = 'XXX';
    $Usuario = $_POST["txtUsuario"];
    $Pass = $_POST["txtContrasena"];
    $Nombre = $_POST["txtNombre"];
    $Celular = $_POST["txtCelular"];
    $Empresa = $_POST["txtEmpresa"];
    $Grupo = $_POST["CmbGrupos"];
    $iGrupo = (int) $Grupo;
    $Perfil = $_POST["Cmbperfiles"];
    $iPerfil = (int) $Perfil;
    $Correo = $_POST["txtCorreo"];
    $PassCorreo = $_POST["txtContrasenaCorreo"];
    $UsuarioF = $_POST["txtUsuarioFUM"];

    require_once('lib/nusoap.php');

    try{ 
        
        //parametros de la llamada
        $parametros = array();
        $parametros['sUsuario'] = $Usuario;
        $parametros['sContrasena'] = $Pass;
        $parametros['Nombre'] = $Nombre;
        $parametros['sCelular'] = $Celular;
        $parametros['sId_Empresa'] = $Empresa;
        $parametros['iId_Grupo'] = $iGrupo;
        $parametros['iId_Perfil'] = $iPerfil;
        $parametros['sCorreo'] = $Correo;
        $parametros['sPassCorreo'] = $PassCorreo;
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

    } catch(SoapFault $e){
        var_dump($e);
    }

}
?>
