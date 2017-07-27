<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){


$users=select_mysql("*","tiendas","deleted!=1");

foreach($users['result'] as $s){

$users_a[]=array(
"id"=>$s['id'],
"name"=>$s['name'],
"prefix"=>$s['prefix'],
"shortname"=>$s['shortname'],
"aliases"=>$s['aliases'],


);

}


dynamic_module_view("admin_portal",'users',array('users'=>$users_a));




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
