<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){

dynamic_module_view("admin_portal",'import_client_mysql',array('env'=>$_POST));




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
