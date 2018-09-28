<?php
// Inicio session
   session_start();

// Compruebo q exista
   if(isset($_SESSION)){
     session_unset();
      session_destroy();
   } 
?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<title>TAYCO DHW</title>
	<meta charset=utf-8>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="description" content="Venta de maquinaria agricola y de construccion " />
	<meta name="keywords" content="" />
	<meta name="author" content="TAYCO SA DE CV" />
    <!-- Load css styles -->
	<link rel="stylesheet" type="text/css" href="css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	<link href="css/bootstrap.min.css" rel="stylesheet" />
	<link href="css/dataTables.bootstrap.min.css" rel="stylesheet" />
    
    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">

	<script language="javascript">
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}

		function inicio() {
				document.getElementById("usuario").focus();	
		function entrar(){
			document.getElementById("frminicio").submit();
		}
		
		function GetChar (event){
			var chCode = ('charCode' in event) ? event.charCode : event.keyCode;
			if(chCode==0){
				entrar();
			}
		}
	</script>

</head>

<body onLoad="inicio()" style="background: url(img/back3.jpg) 0% 0% fixed no-repeat/ cover;">
<!--
    <div class="panel panel-default col-sm-6 col-sm-offset-3" >
        <form id="frminicio" method="POST" action="comprobarusuario.php" class="form-horizontal">


            <div class="form-group">
                <img src="img/jcblogo.png" class="img-responsive col-sm-12" alt="Responsive image">
            </div>
            <div class="form-group">

                <input type="text" class="form-control" name="usuario" id="usuario" style="background: rgba(255, 255, 255, 0.5);" placeholder="Ingrese su usuario"/>
            </div>
            <div class="form-group">

                <input type="password" class="form-control" name="password" id="password"  style="background: rgba(255, 255, 255, 0.5);" placeholder="Ingrese su password" onKeyPress="GetChar (event);">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary col-sm-12" style="border:none;" onClick="entrar();" onMouseOver="style.cursor=cursor">Log In</button>
            </div>
        </form>
    </div>
-->

    <div class="col-sm-4 col-sm-offset-4" >
        <div class="form-horizontal">
            <div class="form-group">
                <img src="img/jcblogo.png" target="_blank" class="img-responsive col-sm-12" alt="Responsive image">
            </div>
            <div class="form-group">
                <a href="https://www.bancomer.com/index.jsp" target="_blank" class="btn btn-primary col-sm-12">BANCOMER</a>
            </div>
            <div class="form-group">
                <a href="https://www.hsbc.com.mx/1/2/!ut/p/c5/04_SB8K8xLLM9MSSzPy8xBz9CP0os3hzR08zAyMTA0__4EAXA08fHzM3c083I-9gQ6B8JG55Z2NidDu7O3qYmPsYGBiEeboaeJo4mRiY-roZGngS0l2QGxoKAPJamVo!/" target="_blank" class="btn btn-primary col-sm-12">HSBC</a>
            </div>
            <div class="form-group">
                <a href="http://www.scotiabank.com.mx/es-mx/personas/default.aspx" target="_blank" class="btn btn-primary col-sm-12">SCOTIABANK</a>
            </div>
            <div class="form-group">
                <a href="https://www.banregio.com/" target="_blank" class="btn btn-primary col-sm-12">BANREGIO</a>
            </div>
            <div class="form-group">
                <a href="http://www.sat.gob.mx/Paginas/Inicio.aspx" target="_blank" class="btn btn-primary col-sm-12">SAT</a>
            </div>
            <div class="form-group">
                <a href="http://www.gob.mx/sct" target="_blank" class="btn btn-primary col-sm-12">SCT</a>
            </div>
            
        </div>
    </div>


</body>

<script src="js/jquery.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/validaciones.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {

		var usuario = new LiveValidation('usuario');
		usuario.add( Validate.Presence );
		usuario.add( Validate.Length, { minimum: 5, maximum: 20 } );

		var password = new LiveValidation('password');
		password.add( Validate.Presence );
		password.add( Validate.Length, { minimum: 5, maximum: 12 } );


	});
</script>

</html>