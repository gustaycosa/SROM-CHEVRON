<script language = "javascript"> 

session_start();

// Compruebo q exista sesion

if(!isset($_SESSION)){

alert("No ha iniciado ninguna sesión valida")

self.location = "index.php"

} 

</script>