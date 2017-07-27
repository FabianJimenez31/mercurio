<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<title>Revisar Inventario</title>
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
show_loading_screen('block');
$.post( url, function( data ) {
$( "#main_content" ).html( data ).enhanceWithin();
show_loading_screen('none');
});

}

function load_page_get(module,process,get_string){
var url = "?" + "module=" + module + "&action=" + process + "&" + get_string;
show_loading_screen('block');
$.post( url, function( data ) {
$( "#main_content" ).html( data ).enhanceWithin();
show_loading_screen('none');
});

}

function submit_form(form_id,destination_url){
var curr_for = "#" + form_id;
var post_inf = $( curr_for ).serialize();
show_loading_screen('block');
$.post( destination_url,  post_inf ,function( data ) {
$( "#main_content" ).html( data ).enhanceWithin();
show_loading_screen('none');
});
return false;
}

function submit_form_file(form_id,destination_url){

show_loading_screen('block');

$.ajax( {
      url: destination_url,
      type: 'POST',
      data: new FormData( document.getElementById(form_id) ),
      processData: false,
      contentType: false,
      success: function(result){
        $("#main_content").html(result).enhanceWithin();
	show_loading_screen('none');
    }

    } );


return false;
}

function show_loading_screen(how_show){


document.getElementById("submit_files_loader").style.display = how_show;



}

window.onload = function() {

load_page_get('reports','item_inventory','app_force_key={[app_force_key]}&product_id={[product_id]}');
};
</script>
<script language="javascript" type="text/javascript" src="js/plot/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="js/plot/jquery.jqplot.css" />
  <script class="include" language="javascript" type="text/javascript" src="js/plot/jqplot.dateAxisRenderer.min.js"></script>
  <script class="include" language="javascript" type="text/javascript" src="js/plot/jqplot.canvasTextRenderer.min.js"></script>
  <script class="include" language="javascript" type="text/javascript" src="js/plot/jqplot.canvasAxisTickRenderer.min.js"></script>
  <script class="include" language="javascript" type="text/javascript" src="js/plot/jqplot.categoryAxisRenderer.min.js"></script>
  <script class="include" language="javascript" type="text/javascript" src="js/plot/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="js/plot/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="js/plot/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="js/plot/jqplot.pointLabels.min.js"></script>
	</head>

<body>

<div id="submit_files_loader" style="width:100%;height:100%;position:fixed;top:0;left:0;right:0;bottom:0;opacity:0.9;background-color:black;color:white;z-index:999999999;display:none;"><center><br/><br/><br/><br/><br/><br/><b>Estamos procesando su solicitud.<br/>Espere un momento por favor</b></center>
</div>

    <div data-role="header" data-position="fixed">
        <h1>Revisar Inventario</h1>
        <a href="#nav-panel" class="ui-btn ui-btn-icon-notext ui-corner-all ui-icon-bars ui-btn-left menu-button">Menu</a>
    </div>


<div data-role="panel" data-position="left" data-position="fixed" data-display="push" data-theme="a" id="nav-panel"  >
     <ul data-role="listview" >
       <li data-icon="recycle"><a data-rel="close" href="../?app_force_key={[app_force_key]}" data-ajax="false" >Cambiar de Producto</a></li>
     </ul>
</div>

<div data-position="left" data-position="fixed" data-theme="a" id="nav-panel-2" class="sidebar"  >
     <ul data-role="listview" >
       <li data-icon="recycle"><a href="../?app_force_key={[app_force_key]}" data-ajax="false">Cambiar de Producto</a></li>
     </ul>
</div>





<div id="main_content" class="main" data-role="content">
</div>



</body>
</html>
