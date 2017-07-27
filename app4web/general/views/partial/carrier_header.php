<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<title>NodoIP</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/themes/nodoip.css" />
  <link rel="stylesheet" href="css/themes/jquery.mobile.icons.min.css" />
  <link rel="stylesheet" href="css/jquery.mobile.structure-1.4.5.min.css" /> 
  <link rel="stylesheet" href="css/style_2.css" /> 
  <script src="js/jquery-1.11.1.min.js"></script> 
  <script src="js/jquery.mobile-1.4.5.min.js"></script>



<style type="text/css" title="currentStyle">
			@import "css/demo_page.css";
			@import "css/demo_table.css";
		</style>




                    <link rel="stylesheet" rev="stylesheet" href="css/jquery.dataTables.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/jquery.dataTables_themeroller.css" media="all" />
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
                    <link rel="stylesheet" rev="stylesheet" href="css/jquery.dataTables.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/dataTables.responsive.css" media="all" />
		<script type="text/javascript" language="javascript" src="js/dataTables.responsive.js"></script>

<script>
function load_page(module,process){
var url = "?" + "module=" + module + "&action=" + process;
$( "#main_content" ).html( 'Cargando...' );
$.post( url, function( data ) {
$( "#main_content" ).html( data ).enhanceWithin();
});

}

function load_page_get(module,process,get_string){
var url = "?" + "module=" + module + "&action=" + process + "&" + get_string;
$( "#main_content" ).html( 'Cargando...' );
$.post( url, function( data ) {
$( "#main_content" ).html( data ).enhanceWithin();
});

}

function submit_form(form_id,destination_url){
var curr_for = "#" + form_id;
var post_inf = $( curr_for ).serialize();
$( "#main_content" ).html( 'Cargando...' );
$.post( destination_url,  post_inf ,function( data ) {
$( "#main_content" ).html( data ).enhanceWithin();
});
return false;
}
</script>
	</head>

<body>

    <div data-role="header" data-position="fixed">
        <h1>NodoIP</h1>
        <a href="#nav-panel" class="ui-btn ui-btn-icon-notext ui-corner-all ui-icon-bars ui-btn-left menu-button">Menu</a>
    </div>


<div data-role="panel" data-position="left" data-position="fixed" data-display="push" data-theme="a" id="nav-panel"  >
     <ul data-role="listview" >
<li data-role="list-divider">Administración</li>
       <li data-icon="cloud"><a data-rel="close" href="#main_content" onclick="javascript:load_page('carrier_portal','domains');">Dominios</a></li>
       <li data-icon="phone"><a data-rel="close" href="#main_content" onclick="javascript:load_page('carrier_portal','extensions');">Extensiones</a></li>
       <li data-icon="arrow-u-r"><a data-rel="close" href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Plan de Marcado</a></li>
       <li data-icon="arrow-d-l"><a data-rel="close" href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Llamadas Entrantes</a></li>

       <li data-icon="grid"><a data-rel="close" href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Grupos de Monitoreo</a></li>
       <li data-icon="location"><a data-rel="close" href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Conferencias</a></li>
       <li data-icon="comment"><a data-rel="close" href="#main_content" onclick="javascript:load_page('admin_portal','servers');">IVR</a></li>
       <li data-icon="clock"><a data-rel="close" href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Colas de Llamadas</a></li>
<li data-role="list-divider">Herramientas</li>
       <li data-icon="audio"><a data-rel="close" href="#main_content">Grabaciones de Llamadas</a></li>
       <li data-icon="eye"><a data-rel="close" href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Monitoreo de Llamadas</a></li>
       <li data-icon="bars"><a data-rel="close" href="#main_content">CDR</a></li>
       <li data-icon="star"><a data-rel="close" href="#main_content">Mi Información</a></li>
       <li data-icon="user"><a data-rel="close" href="#main_content">Usuarios</a></li>
       <li data-icon="shop"><a data-rel="close" href="#main_content">Paquetes</a></li>
       <li data-icon="calendar"><a data-rel="close" href="#main_content">Facturación</a></li>
       <li data-icon="lock"><a data-rel="close" href="#main_content" onclick="javascript:load_page('home','logout');">Cerrar sesión</a></li>
     </ul>
</div>

<div data-position="left" data-position="fixed" data-theme="a" id="nav-panel-2" class="sidebar"  >
     <ul data-role="listview" >
<li data-role="list-divider">Administración</li>
       <li data-icon="cloud"><a href="#main_content" onclick="javascript:load_page('carrier_portal','domains');">Dominios</a></li>
       <li data-icon="phone"><a href="#main_content" onclick="javascript:load_page('carrier_portal','extensions');">Extensiones</a></li>
       <li data-icon="arrow-u-r"><a href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Plan de Marcado</a></li>
       <li data-icon="arrow-d-l"><a href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Llamadas Entrantes</a></li>

       <li data-icon="grid"><a href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Grupos de Monitoreo</a></li>
       <li data-icon="location"><a href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Conferencias</a></li>
       <li data-icon="comment"><a href="#main_content" onclick="javascript:load_page('admin_portal','servers');">IVR</a></li>
       <li data-icon="clock"><a href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Colas de Llamadas</a></li>
<li data-role="list-divider">Herramientas</li>
       <li data-icon="eye"><a href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Monitoreo de Llamadas</a></li>
       <li data-icon="audio"><a href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Grabaciones de Llamadas</a></li>
       <li data-icon="bars"><a href="#main_content" onclick="javascript:load_page('admin_portal','servers');">CDR</a></li>
       <li data-icon="star"><a href="#main_content">Mi Información</a></li>
       <li data-icon="user"><a href="#main_content">Usuarios</a></li>
       <li data-icon="shop"><a href="#main_content">Paquetes</a></li>
       <li data-icon="calendar"><a href="#main_content">Facturación</a></li>
       <li data-icon="lock"><a href="#main_content" onclick="javascript:load_page('home','logout');">Cerrar sesión</a></li>
     </ul>
</div>





<div id="main_content" class="main" data-role="content">
</div>



</body>
</html>
