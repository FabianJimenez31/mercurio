<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){

$store_id=$_GET['store_id'];

update_mysql("tiendas",array(
'deleted'=>'1'
),"id='".$store_id."'");


$store_name="store_".$store_id;
$new_store_dir=str_replace("superadmin/","",APPDIR)."tiendas/".$store_name;

exec("mv $new_store_dir ".$new_store_dir.".DELETED");

echo "<script>alert('Tienda Eliminada');</script>";

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

dynamic_module_view("admin_portal",'users',array('users'=>$users_a));


}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
