<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
    
        $nombre =  $_POST["txtnombre"];
        $usuario =  $_POST["txtusuario"];
        $pass =  $_POST["txtpass"];
        $perfil =  $_POST["cmbperfil"];
        $grupo =  $_POST["cmbgrupo"];
        $tel =  $_POST["txttel"];
        $stel= (string)$tel;
        $correo =  $_POST["txtcorreo"];
        $passcorreo =  $_POST["txtpasscorreo"];
        //echo "<script>alert('".$tel."');</script>";
        
        //parametros de la llamada
        $parametros = array();
        $parametros['iOpc'] = 1;
        $parametros['iId'] = '';
        $parametros['sId_Empresa'] = $Empresa;
        $parametros['sUsuario'] = $usuario;
        $parametros['sContrasena'] = $pass;
        $parametros['sNombre'] = $nombre;
        $parametros['sTelefono'] = $stel;
        $parametros['iId_Grupo'] = $grupo;
        $parametros['iId_Perfil'] = $perfil;
        $parametros['sCorreo'] = $correo;
        $parametros['sPassCorreo'] = $passcorreo;
        //echo "<script>alert('".$parametros['sTelefono']."');</script>";
        $WS = new SoapClient($WebService);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->UsuariosInsert($parametros);
        $xml = $result->UsuariosInsertResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{

    }
} catch(SoapFault $e){
  var_dump($e);
}


?>