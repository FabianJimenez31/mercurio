<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){


$plan_info=select_mysql("*","tiendas","id=".$_GET['plan_id']);
$info=$plan_info['result'][0];

dynamic_module_view("admin_portal",'edit_plan',$info);




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
