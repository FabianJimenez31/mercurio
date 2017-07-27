<?php
ini_set("session.save_path", "/tmp"); 
ini_set("session.cookie_lifetime", 0); 
ini_set("session.gc_maxlifetime", "360000"); 

include("../config.php");
include("sql.php");
include("../multistore.php");
session_start();


if(isset($_SESSION['user']) && $_SESSION['user']>0 && $_SESSION['user']!=""){

echo "Se cerrara su sesion en otras tiendas y regresara a este sitio en unos momentos.... <br/>Espere un momento";
session_start();
session_destroy();
session_start();

echo "<meta http-equiv=\"refresh\" content=\"5;url=?app_force_key=".md5('app4webmercuriounique')."\" />";
}else{

if(ENABLEMULTISTORE!=1){

echo "<meta http-equiv=\"refresh\" content=\"0;url=../tiendas/inicial/?\" />";

}else{

$sr_a=select_mysql("*","tiendas","aliases='".$_SERVER['SERVER_NAME']."'");
$sr=$sr_a['result'][0];
if($sr_a['count']>=1){
echo "<meta http-equiv=\"refresh\" content=\"0;url=../tiendas/".$sr['shortname']."/?\" />";
}else{
if(isset($_GET['store_id'])){
echo "<meta http-equiv=\"refresh\" content=\"0;url=consulta/?app_force_key=".md5('app4webmercuriounique')."&store_id=".$_GET['store_id']."\" />";

}else{

if($_GET['app_force_key']==md5('app4webmercuriounique')){

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<title>Consulta de Inventario</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--MERCURIO SKYONE -->
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

   <div data-role="footer" data-position="fixed">
        <h2>Mercurio 3.0 Desarrollado por SkyOne 2015 <br class="resp_br" />Todos los derechos reservados, versión 3.2.4.1</h2>
    </div>


   <div data-role="header" data-position="fixed">
        <h2>Selección de <br class="resp_br"/>Tienda</h2>
    </div>

<div class="container-small">
<?php
define('APPDIRLOGO', str_replace("index.php","",$_SERVER['SCRIPT_FILENAME']));
if( file_exists(APPDIRLOGO."../custom_logo.png")){
$logo_url="../custom_logo.png";
}else{
$logo_url="../logo.png";
}

?>
<center><img src="<?php echo $logo_url; ?>" width="250px"></center>


<div data-role="collapsibleset" data-theme="a" data-content-theme="a">


    <div data-role="collapsible">
        <h3>Inventario Por Tienda</h3>

	
<p>
<div class="ui-field-contain ">
    <label for="store">Tienda:</label>
    <select id="store" name="store" >
<option value='NULO' selected> - Seleccione su Tienda - </option>
<?php
$m=select_mysql("*","tiendas","deleted!=1");
foreach($m['result'] as $mn){

echo "<option value='".$mn['prefix']."'>".$mn['name']."</option>";

}
?>

    </select>
<br/><br/><br/><br/>
<div class="submit_button" ><input type="submit"  onclick="javascript:redirecciona_tienda();" data-mini="true" data-inline="true" value="Mostrar Inventario Actual de la Tienda" /></div>

</div>
</p>
    </div>

    <div data-role="collapsible">
        <h3>Inventario por Producto</h3>
<p>
<div class="ui-field-contain ">

    <form class="ui-filterable">
    <label for="producto">Producto:</label>
    <input id="inset-autocomplete-input" data-type="search" placeholder="Busque su Producto...">
</form>

<ul data-role="listview" data-inset="true" data-filter="true" data-filter-reveal="true" data-input="#inset-autocomplete-input">

<?php
$m=select_mysql("*","tiendas","deleted!=1");

$query_principal="";
$fx=0;
foreach($m['result'] as $mn){

$query_principal.=($fx==0)?"SELECT product_id as sku , name as producto FROM ".$mn['prefix']."items ":" UNION SELECT product_id as sku , name as producto FROM ".$mn['prefix']."items ";
$fx++;



}


$full_items="select T1.sku , T1.producto from ($query_principal) as T1 group by T1.sku ORDER BY T1.producto ASC";

$f_it=ejecutar($full_items);

$it_a=mostrar($f_it);

$cua=contar($f_it);


foreach($it_a as $mn){

if(str_replace(array(" ","\n","\t"),"",$mn['sku'])!=""){

echo "<li><a href='general/?app_force_key=".md5('app4webmercuriounique')."&product_id=".$mn['sku']."' data-ajax=\"false\">".$mn['producto']." [ ".$mn['sku']." ]</a></li>";

}
}

//echo $query_principal;


?>

</ul>


</div>

</p>
    </div>
</div>



</div>

</div>

<script>

function redirecciona_tienda(){

var valor= document.getElementById('store').value;


if(valor!='NULO'){

window.location.replace("consulta/?app_force_key=<?php echo md5('app4webmercuriounique'); ?>&store_id=" + valor);

}else{

alert('Seleccione una Tienda Primero');

}

}

</script>


</body>


</html>


<?php
}
}
}
}
}
?>



