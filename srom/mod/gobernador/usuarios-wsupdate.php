<?php include("../../funciones.php");
    require_once('lib/nusoap.php');
    ini_set("soap.wsdl_cache_enabled", "0");
    

    //$Opc = 3;
    //$iOpc = (int) $Opc;
    $id = $_POST["txtId"];;
    $iId = (int) $id;
    $Usuario = $_POST["txtUsuario"];
    $Nombre = $_POST["txtNombre"];
    $Celular = $_POST["txtCelular"];
    //$iCelular = (int) $Celular;
    $Contrasena = $_POST["txtContrasena"];
    $Empresa = $_POST["txtEmpresa"];
    $Grupo = $_POST["CmbGrupos"];
    $iGrupo = (int) $Grupo;
    $Perfil = $_POST["Cmbperfiles"];
    $iPerfil = (int) $Perfil;
    $Correo = $_POST["txtCorreo"];
    $ContrasenaCorreo = $_POST["txtContrasenaCorreo"];
    $Estatus = 1;
    $iEstatus = (int) $Estatus;
    $UsuarioF = $_POST["txtUsuarioFUM"];

    $num = md5(time());
    $ipvisitante = $_SERVER["REMOTE_ADDR"];
    $equipo = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $host = gethostbyaddr( $_SERVER['REMOTE_ADDR']);
    $browser_type = getenv("HTTP_USER_AGENT");
    //$ip = getIP();
    echo '<script language="JavaScript"> alert("iP='.$Nombre.'___Equipo='.$iId.'___MAC='.$Grupo.'");</script>';

    try{ 

        
        //parametros de la llamada
        $parametros = array();

        $parametros['iId'] = $iId;
        $parametros['sUsuario'] = $Usuario;
        $parametros['sContrasena'] = $Contrasena;
        $parametros['sNombre'] = $Nombre;
        $parametros['sCelular'] = $Celular;
        $parametros['sId_Empresa'] = $Empresa;
        $parametros['iId_Grupo'] = $iGrupo;
        $parametros['iId_Perfil'] = $iPerfil;
        $parametros['sCorreo'] = $Correo;
        $parametros['sPassCorreo'] = $ContrasenaCorreo;
        $parametros['iEstatus'] = $iEstatus;
        $parametros['sId_usuario_Fum'] = $UsuarioF;
        $parametros['Equipo'] = $ipvisitante;
        $parametros['Ip'] = $ipvisitante;
        $parametros['MAC'] = $ipvisitante;
        
        //dsl-189-155-243-14-dyn.prod-infinitum.com.mx
        //
        //Invocación al web service
        $WS = new SoapClient($WebService,$parametros);
        $result = $WS->UsuariosUpdate($parametros);
        $Datos = $result->UsuariosUpdateResult->string;

        var_dump($result);

        $valido = $Datos ;

         if ($valido=='0') {
         echo '<script language="JavaScript"> alert("Usuario no modificado.");</script>';

         //echo $valido;
         }
         else
         {
          echo '<script language="JavaScript"> alert("Usuario modificado.");
          </script>';
         }
         //$obj = simplexml_load_string($xml);
         //$Datos = $obj->NewDataSet->Table;
         //echo "<script language='JavaScript'> alert('El registro se inserto correctamente! '); </script>";

    } catch(SoapFault $e){
        var_dump($e);
    }


?>
