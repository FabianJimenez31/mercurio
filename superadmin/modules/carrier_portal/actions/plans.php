<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==1){


$servers=select_mysql("*","billing_plans");

foreach($servers['result'] as $s){

$server[]=array(
"id"=>$s['id'],
'name'=>$s['name'],
'description'=>substr(str_replace("\n","<br/>",$s['description']),0,100)."...",
'country'=>$s['country'],
'billing_method'=>$s['billing_method'],
'cost'=> number_format($s['cost'],2)

);

}

dynamic_module_view("admin_portal",'plans',array('plans'=>$server));




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
