<?php
session_start();
echo ' ';
if ($_SESSION["Autenticado"] != "SI"){
header("Location: http://www.eimportacion.com.mx/");
}
?>