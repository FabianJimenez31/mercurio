<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){


$s['now']=date("Y-m-d");
dynamic_module_view("reports",'main',$s);




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
