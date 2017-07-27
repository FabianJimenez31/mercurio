<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==3){





dynamic_module_view("carrier_portal",'new_domain',array('unique_id'=>guid()));




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
