<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==1){


$acc=array(
'user' => time().rand(0,9),
'password' => rand(10000,99999)
);


dynamic_module_view("admin_portal",'new_client',$acc);




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
