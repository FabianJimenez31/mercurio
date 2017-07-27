<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<title>SuperAdmin - Inicio de Sesión</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/themes/nodoip.css" />
  <link rel="stylesheet" href="css/themes/jquery.mobile.icons.min.css" />
  <link rel="stylesheet" href="css/jquery.mobile.structure-1.4.5.min.css" /> 
  <link rel="stylesheet" href="css/style.css" /> 
  <script src="js/jquery-1.11.1.min.js"></script> 
  <script src="js/jquery.mobile-1.4.5.min.js"></script>


	</head>

<body>
<div data-role="page">

<?php
global $var_array;
if($var_array['login']['error']!='' && isset($var_array['login']['error'])){
?>
<div class="ui-bar-c container-small"><center><?php echo $var_array['login']['error']; ?></center></div>

<?php


}

?>


   <div data-role="header" data-position="fixed">
        <h2>Super Admin IP</h2>
    </div>

<div class="container-small">
<form action="?module=login&action=validate" data-ajax="false" method="POST" data-mini="true" data-inline="true">


<div class="ui-field-contain ">
    <label for="username">Usuario:</label>
    <input id="username"  name="username" type="text"  />
</div>

<div class="ui-field-contain ">
    <label for="password">Contraseña:</label>
    <input id="password" name="password" type="password"  />
</div>


<div class="submit_button" ><input type="submit"   data-mini="true" data-inline="true" value="Ingresar" /></div>
<br/>
</form>
</div>

</div>
</body>


</html>

