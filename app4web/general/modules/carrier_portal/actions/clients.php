<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==1){


$users=select_mysql("*","users","domain='admin.nodoip.com' ");

foreach($users['result'] as $s){

$crm_info_a=select_mysql("*","crm_information","user_id='".$s['id']."'");
$crm_info=$crm_info_a['result'][0];
$domains=select_mysql("*","domains","main_user='".$s['id']."'");

switch($s['status']){

case 1:
	$status="Activo";
	break;

case 2:
	$status="Inactivo";
	break;

case 3:
	$status="Eliminado";
	break;


}

$users_a[]=array(
"id"=>$s['id'],
'name'=>$crm_info['name'].",".$crm_info['last_name'],
'domains'=>$domains['count'],
'country'=>$crm_info['country'],
'status'=>$status

);

}


dynamic_module_view("admin_portal",'users',array('users'=>$users_a));




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
