<?php 
session_start();

if ($_SESSION['Usuario'])
{	
	session_destroy();
	echo '<script language = javascript>
	alert("Su sesion ha sido Finalizada")
	self.location = "http://www.taycosa.mx"
	</script>';}
else
{
	echo '<script language = javascript>
	alert("Su sesion ha sido Finalizada")
	self.location = "http://www.taycosa.mx"
	</script>';
}

?>
