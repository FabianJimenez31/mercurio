<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==1){





dynamic_module_view("admin_portal",'new_plan');




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
