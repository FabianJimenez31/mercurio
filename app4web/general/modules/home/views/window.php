<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<title>N-OVLA - Node Over VoIP on Latin America</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" href="modules/login/css/jquery-ui.theme.min.css" rel="stylesheet" />
		<script src="modules/login/js/jquery.js"></script>
		<script src="modules/login/js/jquery-ui.min.js"></script>

 <script>
$(function() {$( "input[type=submit]" ).button();});
</script>
	</head>

<body bgcolor="#E0F0F0" >

<?php
global $var_array;
if($var_array['login']['error']!='' && isset($var_array['login']['error'])){
?>

<div class="ui-widget" style="position: fixed;top: 10%;left: 50%;margin-top: -10px;margin-left: -250px;width:500px;">
	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<small><small><strong>Error:</strong> <?php echo $var_array['login']['error']; ?></p></small></small>
	</div>
</div>
<br/><br/>

<?php


}

?>

<div style="position: fixed;top: 50%;left: 50%;margin-top: -150px;margin-left: -250px;" >
<form action="?module=login&action=validate" method="POST">

<div width="500px" style="text-align:center;width:500px;" class="ui-widget-header ui-corner-top"> Inicie Sesión</div>
<div width="500px" style="text-align:center;width:500px;" class="ui-widget-content ui-corner-bottom"> 

<table border="0">

<tr>
<td style="text-shadow: 0.1em 0.1em 0.2em black;width:50%;height:50px;text-align:right;" >Usuario:</td>
<td style="text-align:left;"><input id="username" name="username" type="text" class="ui-corner-all ui-widget-content" /></td>
</tr>

<tr>
<td style="text-shadow: 0.1em 0.1em 0.2em black;width:50%;height:50px;text-align:right;" >Contraseña:</td>
<td style="text-align:left;"><input id="password" name="password" type="password" class="ui-corner-all ui-widget-content" /></td>
</tr>

<tr>
<td style="text-shadow: 0.1em 0.1em 0.2em black;width:50%;height:50px;text-align:right;" >Dominio:</td>
<td style="text-align:left;"><input id="domain" name="domain" type="input" class="ui-corner-all ui-widget-content" /></td>
</tr>


</table>

<input type="submit" value="Ingresar" />
<br/>
<br/>
</div>

</form>

</div>
</body>


</html>

