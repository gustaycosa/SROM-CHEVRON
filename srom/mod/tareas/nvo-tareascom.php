<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
    
        $Id_Usuario =  $_POST["Txtidsolicitacom"];
        $Id_Tarea =  $_POST["TxtTareaCom"];
        $Fecha =  $_POST["txtFechaCom"];
        $Comentario =  $_POST["TxtComentario"];

        //echo "<script>alert('".$tel."');</script>";
        
        //parametros de la llamada
        $parametros = array();
        $parametros['Id_Usuario'] = $Id_Usuario;
        $parametros['Id_Tarea'] = $Id_Tarea;
        $parametros['Fecha'] = $Fecha;
        $parametros['Comentario'] = $Comentario;

        //echo "<script>alert('".$parametros['sTelefono']."');</script>";
        $WS = new SoapClient($WebService);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->AltaComentarios($parametros);
        $xml = $result->IAltaComentariosResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{

    }
} catch(SoapFault $e){
  var_dump($e);
}


?>