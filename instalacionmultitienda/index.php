<?php
define('APPDIR', str_replace("index.php","",$_SERVER['SCRIPT_FILENAME']));
if(isset($_POST) && isset($_POST['host'])){

$myid = mysqli_connect($_POST['host'],$_POST['user'], $_POST['password']);

if($myid==false){
//mysqli_select_db($myid,$mydb);

$_POST['resp']="<div style='color:red;'>NO SE PUDO ESTABLECER LA CONEXION CON LA BASE DE DATOS. VERIFIQUE SU INFORMACION</div>";


}else{


$check_db=mysqli_select_db($myid,$_POST['database']);

if($check_db==false && ($_POST['create_db']!='Y') ){

$_POST['resp']="<div style='color:red;'>EL NOMBRE DE BASE DE DATOS MYSQL ES INCORRECTO. NO EXITE ESA BASE EN EL SERVIDOR. VERIFIQUE SU INFORMACION Y PRUEBE DE NUEVO</div>";




}else{

if($_POST['create_db']=='Y'){

$prefix_validation=mysqli_query($myid,"CREATE DATABASE ".$_POST['database'].";");
}

$table=mysqli_query($myid,"CREATE TABLE IF NOT EXISTS ".$_POST['database'].".`tiendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `shortname` varchar(50) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `aliases` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");

$strp=explode("tiendas", $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
$newURL=str_replace("instalacionmultitienda/index.php","","http://".$strp[0]."/superadmin");



$_POST['resp']="<meta http-equiv=\"refresh\" content=\"0;url=$newURL\" />";

$config_php = "<?php

define('MYSQLHOST','".$_POST['host']."');
define('MYSQLUSER','".$_POST['user']."');
define('MYSQLPSSWD','".$_POST['password']."');
define('MYSQLDB','".$_POST['database']."');
define('DBPREFIX','');

?>";
$fp = fopen(APPDIR . "../config.php","w");
fwrite($fp,$config_php);
fclose($fp);




}


}

}


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<title>Inicio de Sesión</title>
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



   <div data-role="header" data-position="fixed">
        <h2>Instalación de Sistema</h2>
    </div>

<h2>NUEVA TIENDA</h2>


<div class="form-responsive">

<form id="create-user" action="?" method="POST" >
<br/>
<?php echo $_POST['resp']; ?>
<br/><br/>
<div class="ui-field-contain ">
    <label for="user">Usuario MySQL:</label>
    <input id="user"  name="user" type="text" value="<?php echo $_POST['user']; ?>"  />
</div>

<div class="ui-field-contain ">
    <label for="password">Contraseña MySQL:</label>
    <input id="password"  name="password" type="text" value="<?php echo $_POST['password']; ?>" />
</div>


<div class="ui-field-contain ">
    <label for="host">Host MySQL:</label>
    <input id="host"  name="host" type="text" value="<?php echo $_POST['host']; ?>" />
</div>

<div class="ui-field-contain ">
    <label for="database">Nombre de Base de Datos MySQL:</label>
    <input id="database"  name="database" type="text" value="<?php echo $_POST['database']; ?>"  />
</div>

<div class="ui-field-contain ">
    <label for="create_db">Crear Base de Datos:</label>
    <select id="create_db"  name="create_db" type="text" >

	<option value="Y" <?php echo ($_POST['create_db']=="Y")?"selected":"" ?> >Si</option>
	<option value="N" <?php echo ($_POST['create_db']=="Y")?"":"selected" ?> >No</option>

    </select>
</div>



<div class="submit_button" ><input type="submit"   data-mini="true" data-inline="true" value="Continuar" /></div>
<br/>
</form>
</div>


</div>

</body>


</html>





