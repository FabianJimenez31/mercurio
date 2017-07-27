<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==3){

$mmn=update_mysql("domains",array('shortname'=>$_POST['shortname'] , 'status'=>$_POST['status']),"id=".$_POST['id']);


echo "<script>alert('Dominio Modificado');</script>";
$servers=select_mysql("*","domains","main_user=".get_user_id($var_array['username'],$var_array['domain']));

foreach($servers['result'] as $s){

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

$extensiones=select_mysql("*","subscriber","domain='".$s['domain']."' ");

$server[]=array(
"id"=>$s['id'],
'name'=>$s['shortname'],
'domain'=>$s['domain'],
'extensions'=>$extensiones['count'],
'status'=>$type

);

}

dynamic_module_view("carrier_portal",'domains',array('servers'=>$server));


}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
