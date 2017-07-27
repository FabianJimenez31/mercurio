<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==3){

$servers=select_mysql("*","domains","main_user=".get_user_id($var_array['username'],$var_array['domain']));

foreach($servers['result'] as $d){


$ext=select_mysql("*","subscriber","domain='".$d['domain']."'");

foreach($ext['result'] as $s){

switch($s['status']){

case 1 :
	$type="Activo";
	break;

case 2 :
	$type="Inactivo";
	break;

case 3 :
	$type="Eliminado";
	break;



}

$reg=select_mysql("*","location","username='".$s['username']."' and domain='".$s['domain']."'");
$register=($reg['count']>=1)?"SI [".$reg['count']."]":"NO";
$extensions[]=array(
"id"=>$s['id'],
'name'=>$s['username'],
'domain'=>$s['domain'],
'related_to'=>$s['related_to'],
'registered'=>$register,
'status'=>$type

);
}
}

dynamic_module_view("carrier_portal",'extensions',array('extensions'=>$extensions));




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
