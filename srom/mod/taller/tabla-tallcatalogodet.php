<?php include("../../funciones.php"); 	


    try{
        if ($_POST){
            $VarID =  $_POST["TxtClave"]; 
            $WebService = 'http://dwh.taycosa.mx/web_services/Datalogs.asmx?wsdl';
            $parametros = array();
            $parametros['Id_Maq'] = $VarID;
            $WS = new SoapClient($WebService, $parametros);
            $resultado = $WS->MaquinariaParaVtaDetalle($parametros);
            $xml = $resultado->MaquinariaParaVtaDetalleResult->any;
            $obj = simplexml_load_string($xml);
            $MqVtaUsada = $obj->NewDataSet->Table;
            $VarMaquinaDesc = $MqVtaUsada[0]->TipoMaquinaria." ".$MqVtaUsada[0]->Marca." ".$MqVtaUsada[0]->Modelo;
        }

    } catch(SoapFault $e){
      var_dump($e);
    }
?>
<?php 
echo '<h3>'.$VarMaquinaDesc.'</h3><p>';

echo "<div class='table-responsive'>";
    echo "<a target='_blank' class='group1 img-rounded' href='images/".$MqVtaUsada[0]->Id_Maquinaria.".jpg' style='background: url(images/".$MqVtaUsada[0]->Id_Maquinaria.".jpg) center no-repeat; background-size: contain; width: 100%; height: 300px; display:block;'></a></div>";

?>
