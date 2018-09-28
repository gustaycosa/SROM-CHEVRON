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
    <style>
        @import url(http://fonts.googleapis.com/css?family=Roboto);

        /****** LOGIN MODAL ******/
        .loginmodal-container {
          padding: 30px;
          max-width: 350px;
          width: 100% !important;
          background-color: #F7F7F7;
          margin: 0 auto;
          border-radius: 2px;
          box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
          overflow: hidden;
          font-family: roboto;
        }

        .loginmodal-container h1 {
          text-align: center;
          font-size: 1.8em;
          font-family: roboto;
        }

        .loginmodal-container input[type=submit] {
          width: 100%;
          display: block;
          margin-bottom: 10px;
          position: relative;
        }

        .loginmodal-container input[type=text], input[type=password] {
          height: 44px;
          font-size: 16px;
          width: 100%;
          margin-bottom: 10px;
          -webkit-appearance: none;
          background: #fff;
          border: 1px solid #d9d9d9;
          border-top: 1px solid #c0c0c0;
          /* border-radius: 2px; */
          padding: 0 8px;
          box-sizing: border-box;
          -moz-box-sizing: border-box;
        }

        .loginmodal-container input[type=text]:hover, input[type=password]:hover {
          border: 1px solid #b9b9b9;
          border-top: 1px solid #a0a0a0;
          -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
          -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
          box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        }

        .loginmodal {
          text-align: center;
          font-size: 14px;
          font-family: 'Arial', sans-serif;
          font-weight: 700;
          height: 36px;
          padding: 0 8px;
        /* border-radius: 3px; */
        /* -webkit-user-select: none;
          user-select: none; */
        }

        .loginmodal-submit {
          /* border: 1px solid #3079ed; */
          border: 0px;
          color: #fff;
          text-shadow: 0 1px rgba(0,0,0,0.1); 
          background-color: #4d90fe;
          padding: 17px 0px;
          font-family: roboto;
          font-size: 14px;
          /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#4787ed)); */
        }

        .loginmodal-submit:hover {
          /* border: 1px solid #2f5bb7; */
          border: 0px;
          text-shadow: 0 1px rgba(0,0,0,0.3);
          background-color: #357ae8;
          /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
        }

        .loginmodal-container a {
          text-decoration: none;
          color: #666;
          font-weight: 400;
          text-align: center;
          display: inline-block;
          opacity: 0.6;
          transition: opacity ease 0.5s;
        } 

        .login-help{
          font-size: 12px;
        }
    </style>
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

<a href="#" data-toggle="modal" class="btn btn-primary col-sm-12" data-target="#login-modal">Login</a>

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
        <div class="loginmodal-container">
            <h1>Inicio de sesion</h1><br>
          <form id="frminicio" method="POST" action="comprobarusuario.php">
            <input type="text" name="usuario" id="usuario" style=" text-transform: uppercase;" placeholder="Ingrese su usuario">
            <input type="password" name="password" id="password" style=" text-transform: uppercase;" placeholder="Ingrese su password">
            <input type="submit" name="Iniciar sesion" class="login loginmodal-submit" onClick="entrar();" value="Login">
          </form>

          <div class="login-help">
            <a href="#">No puedo entrar</a> - <a href="#">Sitio principal</a>
          </div>
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
		usuario.add( Validate.Length, { minimum: 0, maximum: 20 } );

		var password = new LiveValidation('password');
		password.add( Validate.Presence );
		password.add( Validate.Length, { minimum: 2, maximum: 12 } );


	});
</script>

</html>