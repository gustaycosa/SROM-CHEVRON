<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
    
        $Id_Usuario =  $_POST["txtnombre"];
        $Id_Tarea =  $_POST["txtusuario"];
        $Fecha =  $_POST["txtpass"];
        $Comentario =  $_POST["cmbperfil"];

        //echo "<script>alert('".$tel."');</script>";
        
        //parametros de la llamada
        $parametros = array();
        $parametros['sUsuario'] = $Id_Usuario;
        $parametros['sContrasena'] = $Id_Tarea;
        $parametros['sNombre'] = $Fecha;
        $parametros['sTelefono'] = $Comentario;

        //echo "<script>alert('".$parametros['sTelefono']."');</script>";
        $WS = new SoapClient($WebService);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->InsertTareasCome($parametros);
        $xml = $result->InsertTareasComeResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{

    }
} catch(SoapFault $e){
  var_dump($e);
}


?>