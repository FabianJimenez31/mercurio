<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){

$tiendas_a=select_mysql("*","tiendas","deleted!=1");
$options="";
foreach($tiendas_a['result'] as $t){

$options.="\n<option value='".$t['id']."'>".$t['name']." [ ".$t['shortname']." ]</option>";

}

dynamic_module_view("admin_portal",'import_existing',array('options'=>$options));




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
