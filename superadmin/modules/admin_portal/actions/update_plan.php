<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){





update_mysql("tiendas",$_POST,"id=".$_POST['id']);

$new_store_dir=str_replace("superadmin/","",APPDIR)."tiendas/".$_POST['shortname'];

$contents_php="<?php

define('SITE_NAME','".$_POST['name']."');

?>";

$fp = fopen($new_store_dir . "/contents.php","w");
fwrite($fp,$contents_php);
fclose($fp);

$users=select_mysql("*","tiendas","deleted!=1");

foreach($users['result'] as $s){

$users_a[]=array(
"id"=>$s['id'],
"name"=>$s['name'],
"prefix"=>$s['prefix'],
"shortname"=>$s['shortname'],
"aliases"=>$s['aliases']

);

}

echo "<script>alert('Tienda Modificada');</script>";
dynamic_module_view("admin_portal",'users',array('users'=>$users_a));


}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
