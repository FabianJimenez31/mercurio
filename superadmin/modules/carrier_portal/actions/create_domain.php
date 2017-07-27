<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==3){

$domain_a=array(

'status'=>1,
'shortname'=>$_POST['shortname'],
'main_user'=>get_user_id($var_array['username'],$var_array['domain']),
'expires'=>date('Y-m-d', strtotime(date('Y-m-d'). ' + 7 days')),
'unique_id'=>$_POST['unique_id']

);



$fst=insert_mysql("domains",$domain_a);
$domain_name="srv".str_pad($fst['last_id'],3,"0",STR_PAD_LEFT).".nodoip.com";
$mmn=update_mysql("domains",array('domain'=>$domain_name),"id=".$fst['last_id']);


echo "<script>alert('Dominio Creado');</script>";
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
